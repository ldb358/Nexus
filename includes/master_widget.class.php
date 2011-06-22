<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class master_widget{
    protected $widgets = array(), $from, $db, $params, $forms = array();
    public function __construct($from){
        include_once 'config/db_settings.php';
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
        /* check if the widget is an auto load widget if it is return a copy of it */
        $file = "{$this->from}{$type}_{$name}.widget.php";
        @include_once $file;
        $widget = "{$type}_{$name}";
        if(class_exists($widget)){
            return new $widget($this->db, $this->from);
        }else{
            /* check if a widget is a call load widget if it is return a copy */
            $file = "{$this->from}{$type}".ucfirst($name).".widget.php";
            include_once $file;
            $widget = "{$type}_{$name}";
            if(class_exists($widget)){
                return new $widget($this->db, $this->from);
            }
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
    public function process($values){
        /* this function will process all form data for page widgets */
        //seperate the array into $module = 'module name' exp. page and $values = form data
        $module = $values[0];
        $values = $values[1];
        $widget_name = $values['widget'];
        unset($values['widget']);
        $widget = $this->get_widget($module, $widget_name);
        $widget->process($module, $widget_name, $values);
        $this->add_form($widget);
    }
}