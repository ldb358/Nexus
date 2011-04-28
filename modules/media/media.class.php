<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class media extends nexus_core{
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
    public function get_image_uploader(){
        include_once 'upload.form.php';
        $upload = new media_upload_form();
        return $upload->get_form();
    }
    public function actionUpload(){
        $this->view->form = $this->get_image_uploader();
        $this->view->load();
    }
    public function get_embed_form(){
        include_once 'embed.form.php';
        $upload = new media_embed_form();
        return $upload->get_form();
    }
    public function actionEmbed(){
        $this->view->form = $this->get_embed_form();
        $this->view->load();
    }
    public function process($method, $values){
        include_once "$method.form.php";
        $class = "media_{$method}_form";
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