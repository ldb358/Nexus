<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class admin extends nexus_core{
    public function __construct($isview = false){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
        if(!$isview){
            $this->current_view_dir = 'themes/admin/';
            $this->view->set_dir('themes/admin/');
        }
    }
    public function __call($id, $args){
        $this->method = $id;
        if($id == 'default'){
            $this->load_all_widgets();
        }
        if(!method_exists($this, 'action'.ucfirst($id))){
            @include_once "admin.$id.php";
            $class = "admin_$id";
            if(class_exists($class)){
                $master_widget = new $class(__dir__.'/widgets/');
                $this->view->set_widgets($master_widget->get($args[0]));
            }
            $this->actionDefault($args);
        }else{
            $method = 'action'.ucfirst($id);
            $this->$method($id,$args);
        }
    }
    public function load_all_widgets(){
        $all_widgets = array();
        foreach(glob(__dir__."/admin.*.php") as $id){
            include_once $id;
            $start = strrpos($id,'admin');
            $end = strpos($id,'.php', $start);
            $id = str_replace('.','_', substr($id, $start, $end-$start));
            if(class_exists($id)){
                $master_widget = new $id(__dir__.'/widgets/');
                if($master_widget instanceof master_widget){
                    $all_widgets = array_merge($all_widgets,$master_widget->get());
                }
            }
        }
        $this->view->set_widgets($all_widgets);
    }
    public function actionDefault(){
        $this->view->load();
    }
    public function set_values($results){
        
    }
    public function actionProcess($id, $args){
        @include_once "admin.{$args[0]}.php";
        $class = "admin_{$args[0]}";
        if(class_exists($class)){
            $master_widget = new $class(__dir__.'/widgets/');
            $master_widget->process($args);
            $id = array($id);
            $this->view->set_widgets($master_widget->get(array_merge($id, $args[1])));
        }
        $this->actionDefault($args);
    }
}