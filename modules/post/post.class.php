<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class post extends nexus_core{
    protected $id, $title, $desc, $body, $image, $author, $published, $permissions;
    public function __construct($isview){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function __call($id, $args){
        $dbprefix = DBPREFIX;
        $sql = "SELECT {$dbprefix}post.content_id, {$dbprefix}post.title, {$dbprefix}post.desc, {$dbprefix}post.body, {$dbprefix}post.image,
                {$dbprefix}content.published, {$dbprefix}content.permissions,
                {$dbprefix}users.username,
                FROM {$dbprefix}post
                JOIN {$dbprefix}content ON {$dbprefix}post.content_id = {$dbprefix}content.content_id
                JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id ";
        if(filter_var($id, FILTER_VALIDATE_INT)){
            //is id
            $this->db->prepare($sql.= "WHERE {$dbprefix}content.content_id=?");
            $this->db->sql->bind_param('i', $id);
        }else{
            //is title
            $this->db->prepare($sql.= "WHERE {$dbprefix}content.title=?");
            $this->db->sql->bind_param('s', $id);
        }
        $results = array();
        $this->db->sql->bind_result($results['id'], $results['title'], $results['desc'],
                                    $results['body'], $results['image'], $results['published'],
                                    $results['permissions'], $results['username']);
        $this->db->query();
        foreach($results as $key => $value){
            $this->$key = $value;
            $this->view->$key = $value;
        }
        if(empty($this->id)){
            $redirect = new reroute();
            $redirect->route();
        }
        $this->view->load();
    }
    public function get_new_form(){
        $form = $this->get_new_form_object();
        return $form->get_form();
    }
    public function get_new_form_object(){
        include_once 'new.form.php';
        $form =  new post_new_form();
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