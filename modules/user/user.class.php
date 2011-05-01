<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class user extends nexus_core{
    public $user = array();
    public function __construct($isview = false){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
            exit();
        }
    }
    public function actionDefault(){
        $redirect = new reroute();
        $redirect->route();
    }
    public function actionLogin(){
        include_once 'login.form.php';
        $form = new user_login_form();
        $this->view->form = $form->get_form();
        $this->view->load();
    }
    public function actionLogout(){
        session_destroy();
        unset($this->user);
        $redirect = new reroute();
        $redirect->route();
    }
    public function actionRegister(){
        include_once 'register.form.php';
        $form  = new user_register_form();
        $this->view->form = $form->get_form();
        $this->view->load();
    }
    public function process($method, $values){
        include_once "$method.form.php";
        $class = "user_{$method}_form";
        $form = new $class();
        $return = $form->process($values, $this->db);
        if(!empty($return)){
            $this->view->form = "<p>$return</p>";
            $this->view->form .= $form->get_form();
        }else{
            $this->view->form = $form->on_success();
        }
        $this->view->load();
    }
    public function is_logged_in(){
        if(isset($_SESSION['username'], $_SESSION['password'])){
            if(!isset($this->user['username'], $this->user['password'])){
                $this->set_user();
            }
            if($this->user['username'] == $_SESSION['username'] && $this->user['password'] == $_SESSION['password']){
                return true;
            }
        }
        return false;
    }
    public function is_level($content_id){
        $this->db->prepare('SELECT permissions FROM '.DBPREFIX.'content where id=?');
        $this->db->sql->bind_param('i', $content_id);
        $this->db->sql->bind_result($level);
        $this->db->query();
        if($this->is_logged_in()){
            if($level <= $this->get_user_info('level')){
                return true;
            }
        }else{
            if($level == 10){
                return true;
            }
        }
        return false;
    }
    public function set_user(){
        $this->db->prepare('SELECT id, username, password, email, firstname, lastname, level FROM '.DBPREFIX.'users WHERE username=?');
        $this->db->sql->bind_param('s', $_SESSION['username']);
        $this->db->sql->bind_result($id, $username, $password, $email, $first, $last, $level);
        $this->db->query();
        if(@$_SESSION['username']== $username && @$_SESSION['password'] == $password){
            $this->user['id'] = $id;
            $this->user['username'] = $username;
            $this->user['password'] = $password;
            $this->user['email'] = $email;
            $this->user['first'] = $first;
            $this->user['last'] = $last;
            $this->user['level'] = $level;
        }
    }
    public function get_user(){
        if(!isset($this->user['username'])){
            $this->set_user();
        }
        return $this->user['username'];
    }
    public function get_user_info($name){
        if(!isset($this->user[$name])){
            $this->set_user();
        }
        if(isset($this->user[$name])){
            return false;
        }
        return $this->user[$name];
    }
}
?>