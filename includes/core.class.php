<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class nexus_core{
    public $view, $current_view_dir, $default_view, $method, $load_modules = array();
    
    public function __construct($isview = false){
        include_once 'view.class.php';
        include_once '/config/db_settings.php';
        $this->db = db_factory();
        if(!$this->db instanceof db){
            throw new Exception('No Database');
        }
        if(!$isview){
            $this->current_view_dir = $this->get_current_view_dir();
            $this->default_view = $this->get_default_view();
            $this->view = new view($this->current_view_dir,$this->default_view);
            $this->view->reroute = new reroute();
            $this->view->site_name = $this->get_site_option('title');
            $this->view->control = $this;
        }
    }
    
    public function __call($name, $args){
        $this->method = $name;
        if(method_exists($this, 'action'.ucfirst($name))){
            call_user_func(array($this,'action'.ucfirst($name)),$args);
        }else{
            $this->actionDefault($args);
        }
    }
    public function sec_call($call, $args){
        /* This is the function that should be used for all secure actions, such
        ** as any action that destroys
        */
        $this->$call($args);
        
    }
    public function get_current_view_dir(){
        /* This function gets the view directory that all view files should be
        ** loaded from
        ** @return string the current view dir it will also set the value in the class for future access
        */
        if(empty($this->current_view_dir)){
            
            if($this->db instanceof db){
                $result = $this->get_site_option('theme');
                if(!is_null($result)){
                    $this->current_view_dir = "/themes/$result/";
                }else{
                    $this->current_view_dir = '/themes/default/';
                }
            }else{
                $this->current_view_dir = '/themes/default/';
                
            }
        }
        return $this->current_view_dir;
    }
    public function get_default_view(){
        /* This function gets the view file that should be used as a default the
        ** order is controller.method -> method -> controller ->
        ** @return string the current view to be used if none is specified
        */
        $controller = get_class($this);
        if(empty($this->default_view)){
            ob_start();
            @include_once $this->get_current_view_dir()."$controller.{$this->method}.php";
            $ob = ob_get_contents();
            if(empty($ob)){
                @include_once $this->get_current_view_dir()."$controller.php";
                $ob = ob_get_contents();
                if(empty($ob)){
                    @include_once $this->get_current_view_dir()."{$this->method}.php";
                    $ob = ob_get_contents();
                    if(empty($ob)){
                        $this->default_view = 'index.php';
                    }else{
                        $this->default_view = "{$this->method}.php";
                    }
                }else{
                    $this->default_view = "$controller.php";
                }
            }else{
                $this->default_view = "$controller.{$this->method}.php";
            }
            ob_end_clean();
        }
        return $this->default_view;
    }
    public function get_site_option($name){
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