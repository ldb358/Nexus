<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class media_upload extends widget{
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
        $this->header = 'Upload Image';
    }
    public function set_body(){
        include_once '/modules/media/media.class.php';
        if(class_exists('media')){
            $page = new media(true);
            $form = $page->get_upload_form_object();
            $form->set_action('admin');
            $form->set_method('media');
            $form->set_widget('upload');
            $this->body = $form->get_form();
        }
    }
}