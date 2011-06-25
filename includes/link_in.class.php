<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/* This class is a core part of the implementation of Nexus it allows for modules
 * to plug directly into core features and run events, methods and other actions
 * at any time during the execution of nexus allowing for more options to extend
 * the system
 */
class link_in{
    public $events = array(), $modules = array();
    
    public function __construct(){
        $this->load_configs();
    }
    public function run($name, $params = array()){
        /*
         * This function runs the $name actions methods that are in the $events
         * array it will also pass the $params array
        */
        if(!isset($this->events[$name])){
            return;
        }
        foreach($this->events[$name] as $method){
            if(is_array($method)){
                $key = array_keys($method);
                foreach($key as $value){
                    if(filter_var($value, FILTER_VALIDATE_INT) && function_exists($method[$value])){
                        call_user_func($method[$value], $params);
                        var_dump($value);
                        continue;
                    }
                    $object =& load_class($value);
                    if(method_exists($object,$method[$value])){
                        $object->$method[$value]($params);
                    }
                }
            }else{
                if(function_exists($method)){
                    call_user_func($method, $params);
                }
            }
        }
    }
    public function add($name, $what, $where = 1){
        /*
         * Adds an event to the events array where $name is the event and $what
         * is the method/function to be called
         * $where is where in the list it should be added 1 =end, 0 = beginning
        */
        @$events =& $this->events[$name];
        if(!isset($events)){
            $events = array();
        }
        $events[count($events)] = $what;
    }
    public function load_configs(){
        /*
         * Loads all of the config files and adds their events to the events
         * array
        */
        if(file_exists_for_include('cache/system/events.json.php')){
            $cache = file_get_contents('cache/system/events.json.php');
            $jsoncache = json_decode($cache, true);
            if($jsoncache != null){
                $this->events = $jsoncache['events'];
                foreach($jsoncache['modules'] as $module){
                    include_once "modules/$module/$module.class.php";
                }
            }
            return;
        }
        $pattern = 'modules/*';
        foreach(glob($pattern) as $file){
            if(!is_dir($file)) continue;
            $module = substr($file, strlen($pattern)-1);
            $contents = file_get_contents("$file/$module.json.php");
            $json = json_decode($contents, true);
            if($json['active'] == 0 || !isset($json['events'])){
                continue;
            }
            // load the class file so that the method can be present for running
            include_once "$file/$module.class.php";
            $this->modules[count($this->modules)] = $module;
            foreach($json['events'] as $key => $event){
                $this->add($key, $event);
            }
        }
        $this->write_cache();
    }
    public function write_cache(){
        /*
         * If load config doesn’t find a cache then after it compiles all of the
         * module events it calls this which should write a config file based on
         * the events array
        */
        $ob = array('events' => $this->events, 'modules' => $this->modules);
        $file = fopen('cache/system/events.json.php', 'w');
        fwrite($file, json_encode($ob));
        fclose($file);
    }
    public function remove($name, $method){
        /*
         * removes a method from the events array array
        */
        foreach($this->events[$name] as $id => $func){
            if($func == $method){
                unset($this->events[$name][$id]);
            }
        }
    }
}
?>
