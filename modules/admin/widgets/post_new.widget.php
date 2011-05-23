<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class post_new extends widget{
    protected $control, $params;
    public function __construct(db $db, $params){
        try{
            parent::__construct($db, $params);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function set_header(){
        $this->header = 'New Post';
    }
    public function set_body(){
        include_once '/modules/post/post.class.php';
        if(class_exists('post')){
            $page = new post(true);
            $form = $page->get_new_form_object();
            $form->set_action('admin');
            $form->set_method('post');
            $form->set_widget('new');
            $this->body = $form->get_form();
        }
    }
}