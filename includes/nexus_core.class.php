<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class nexus_core{
    public $view, $current_view_dir, $default_view, $method, $load_modules = array(), $isview;
    
    public function __construct($isview = false){
        include_once 'view.class.php';
        include_once 'config/db_settings.php';
        $this->db = db_factory();
        if(!$this->db instanceof db){
            throw new Exception('No Database');
        }
        $this->isview = $isview;
        if(!$isview){            
           $this->view = new view(array($this->get_current_view_dir(), $this->get_default_view()));
           $this->view->control = $this;
           $this->view->reroute = load_class('reroute');
           $this->view->site_name = $this->get_site_option('title');
        }
    }
    public function &load_module($name){
        //this will any core module with out a view
        $class =& load_class($name);
        if($class !== false){
            return $class;
        }
    }
    public function __call($name, $args){
        if(empty($this->method) && !$this->isview){
            $this->default_view = '';
            $this->get_default_view();
        }
        $this->method = $name;
        if(method_exists($this, 'action'.ucfirst($name))){
            call_user_func(array($this,'action'.ucfirst($name)),$args);
        }else if(strpos($name, 'get_') === false){
            $this->actionDefault($args);
        }else{
            return;
        }
    }
    public function get_current_view_dir(){
        /* This function gets the view directory that all view files should be
        ** loaded from
        ** 
        ** @return string the current view dir it will also set the value in the class for future access
        */
        if(empty($this->current_view_dir)){
            if($this->db instanceof db){
                $result = $this->get_site_option('theme');
                if(!is_null($result)){
                    $this->current_view_dir = "themes/$result/";
                }else{
                    $this->current_view_dir = 'themes/default/';
                }
            }else{
                $this->current_view_dir = 'themes/default/';
                
            }
        }
        return $this->current_view_dir;
    }
    public function get_default_view(){
        /* This function gets the view file that should be used as a default the
        ** order is controller.method -> controller-> method -> index.php
        **
        ** 
        ** @return string the current view to be used if none is specified
        */
        $controller = get_class($this);
        if(empty($this->default_view)){
            $file = $this->get_current_view_dir()."$controller.{$this->method}.php";
            if(file_exists_for_include($file)){
                return ($this->default_view = "$controller.{$this->method}.php");
            }
            $file = $this->get_current_view_dir()."$controller.php";
            if(file_exists_for_include($file)){
                return ($this->default_view = "$controller.php");
            }
            $file = $this->get_current_view_dir()."{$this->method}.php";
            if(file_exists_for_include($file)){
                return ($this->default_view = "{$this->method}.php");
            }
            return ($this->default_view = 'index.php');
        }
        return $this->default_view;
    }
    public function get_site_option($name){
        /* This will return a site option from the database (useful for themes and modules)
         * given the name key
        */
        $dbprefix = DBPREFIX;
        if($this->db instanceof db){
            $this->db->prepare("SELECT value FROM {$dbprefix}options WHERE name=? LIMIT 1");
            $this->db->sql->bind_param('s', $name);
            $this->db->sql->bind_result($results);
            $this->db->query();
            return $results;
        }else{
            return '';
        }
    }
}

?>