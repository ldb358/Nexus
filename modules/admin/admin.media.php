<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class admin_media extends master_widget{
    protected $control, $params;
    public function __construct($from){
        try{
            parent::__construct($from);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function load_widgets($args){
        $args[0] = 'media';
        parent::load_widgets($args);
    }
}