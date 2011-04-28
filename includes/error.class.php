<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class error extends nexus_core{
    private $display_errors = false;
    public function __construct($display_errors = false){
        $this->display_errors = $display_errors;
        try{ parent::__construct(); }catch(Exception $e){}
    }
    public function action404(){
        if($this->display_errors){
            $this->view->error = "404 Error: The Address That You Have Entered Cannot Be Found";
            $this->view->title = $this->get_site_option('title') . '- 404 error';
            $this->view->load();
        }else{
            $this->actionDefault();
        }
    }
    public function actionDefault(){
        $this->view->error = "There has been an error on the page";
        $this->view->title = $this->get_site_option('title').'- Error';
        $this->view->load();
    }
}
?>