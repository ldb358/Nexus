<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class admin_page extends master_widget{
    protected $control, $params;
    public function __construct($from){
        try{
            parent::__construct($from);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function process($values){
        /* this function will process all form data for page widgets */
        //seperate the array into $module = 'module name' exp. page and $values = form data
        $module = $values[0];
        $values = $values[1];
        $widget_name = $values['widget'];
        unset($values['widget']);
        $widget = $this->get_widget($module, $widget_name);
        $widget->process($widget_name, $values);
        $this->add_form($widget);
    }
    public function load_widgets($args){
        $args[0] = 'page';
        parent::load_widgets($args);
    }
}