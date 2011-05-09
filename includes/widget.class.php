<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class widget{
    protected $header, $body, $params = array(), $db;
    public function __construct(db $db, $params){
        $this->params = $params;
        $this->db = $db;
    }
    public function get_header(){
        if(empty($this->header)){
            $this->set_header();
        }
        return $this->header;
    }
    public function get_body(){
        if(empty($this->body)){
            $this->set_body();
        }
        return $this->body;
    }
    public function set_header(){
        return;
    }
    public function set_body(){
        return;
    }
    public function process($module, $method, $values){
        include_once "/modules/$module/$method.form.php";
        $class = "{$module}_{$method}_form";
        if(class_exists($class)){
            $form = new $class();
            $return = $form->process($values, $this->db);
            if(!empty($return)){
                $this->set_body();
                $this->body = "<p>$return</p>".$this->body;
            }else{
                $this->body = "page created";
            }
        }
    }
}