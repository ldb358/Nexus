<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class master_widget{
    protected $widgets = array(), $from, $db, $params, $forms = array();
    public function __construct($from){
        include_once '/config/db_settings.php';
        include_once 'widget.class.php';
        $this->db = db_factory();
        if(!$this->db instanceof db){
            throw new Exception('No Database');
        }
        $this->from = $from;
    }
    public function load_widgets($args){
        $type = $args[0];
        array_shift($args);
        $this->params = $args;
        $widgets = array();
        //load all widgets
        foreach(glob("{$this->from}{$type}_*.widget.php") as $file){
            include_once $file;
            //get widget name
            $start = strlen($this->from);
            $end = strpos($file, '.', $start);
            $widget = substr($file, $start, $end-$start);
            if(class_exists($widget)){
                //check that there isn't a presaved widget
                foreach($this->forms as $form){
                    if(is_a($form, $widget)){
                        $widget = $form;
                    }
                }
                //if no presaved widget create a new one
                $widget = is_object($widget)? $widget : new $widget($this->db, $args);
                $widgets[] = $widget;
            }
        }
        $this->widgets = array_merge($this->widgets, $widgets);
    }
    public function get_widget($type, $name){
        include_once $file;
        $end = strpos($file, '.', $start);
        $widget = substr($file, strlen($this->from) ,$end-$start);
        if(class_exists($widget)){
            return new $widget($this->db, $from);
        }
    }
    public function add_widget($widget){
        /* adds a widget to the widgets array can either pass a widget or an array with the name and type vars*/
        if(is_array($widget)){
            $widget = $this->get_widget($widget[0], $widget[1]);
        }
        if($widget instanceof widget){
            $this->widgets[count($this->widgets)] = $widget;
        }
    }
    public function set_from($from){
        $this->from = $from;
    }
    public function get($type = array('*')){
        if(count($this->widgets) == 0){
            $this->load_widgets($type);
        }
        return $this->widgets;
    }
    public function add_form(widget $form){
        $this->forms[count($this->forms)] = $form;
    }
}