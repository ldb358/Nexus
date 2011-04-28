<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class user_login_form extends form{
    public function __construct(){
        $action = 'user';
        $method = 'login';
        $fields = array(
            array(
                'name' => 'username',
                'label' => 'Username',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'deafault' => ''
            ),
            array(
                'type' => 'submit',
                'default' => 'Login'
            )
        );
        parent::__construct($action, $method, $fields);
    }
    
    public function process($form, db $db){
        if(!empty($form['username']) && !empty($form['password'])){
            $db->prepare('SELECT id, username, password, email FROM '.DBPREFIX.'users WHERE username=?');
            $db->sql->bind_param('s', $form['username']);
            $db->sql->bind_result($id, $username, $password, $email);
            $db->query();
            $password2 = hash('sha512',$id.$form['password'].$email);
            if($username == $form['username'] && $password == $password2){
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
            }else{
                return $this->error($form, 'invalid username or password');
            }
        }else{
            return $this->error($form, 'There are missing fields');
        }
    }
}
?>