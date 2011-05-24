<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class page extends nexus_core{
    private $id, $contents, $title, $permissions, $published, $username;
    public function __construct($isview = false){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function __call($id, $args){
        if($this->db instanceof db){
            $dbprefix = DBPREFIX;
            $results = array();
            if(!filter_var($id,FILTER_VALIDATE_INT)){
                //is a page name
                $this->db->prepare("SELECT {$dbprefix}page.id, {$dbprefix}page.title, {$dbprefix}page.contents, {$dbprefix}content.permissions, {$dbprefix}content.published, {$dbprefix}users.username FROM {$dbprefix}page JOIN {$dbprefix}content ON {$dbprefix}content.content_id = {$dbprefix}page.id JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id WHERE {$dbprefix}page.title=?");
                $this->db->sql->bind_param('s', $id);
            }else{
                //is a page id
                $this->db->prepare("SELECT {$dbprefix}page.id, {$dbprefix}page.title, {$dbprefix}page.contents, {$dbprefix}content.permissions, {$dbprefix}content.published, {$dbprefix}users.username FROM {$dbprefix}page JOIN {$dbprefix}content ON {$dbprefix}content.content_id = {$dbprefix}page.id JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id WHERE {$dbprefix}page.id=?");
                $this->db->sql->bind_param('i', $id);
            }
            $results = array();
            $this->db->sql->bind_result($results['id'], $results['title'], $results['contents'], $results['permissions'], $results['date'], $results['username']);
            $this->db->query();
            if(empty($results['id'])){
                $redirect = new reroute();
                $redirect->route();
            }
            include_once 'page_item.class.php';
            $page = new page_item();
            $this->view->control = $page;
            $page->set_values($results);
            $this->view->load();
        }
    }
    public function actionDefault(){
        $home = $this->get_site_option('home');
        $this->$home;
    }
    public function get_new_form(){
        $form = $this->get_new_form_object();
        return $form->get_form();
    }
    public function get_new_form_object(){
        include_once 'new.form.php';
        $form =  new page_new_form();
        return $form;
    }
    public function process($method, $values){
        include_once "$method.form.php";
        $class = "page_{$method}_form";
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
}
?>
