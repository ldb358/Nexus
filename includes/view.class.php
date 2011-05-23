<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/*  This Class is the defaults view class it allow store values that should be used
 *  and to include_once the files into the view
 */
class view{
    protected $default, $dir, $path, $modules = array(), $widgets = array(), $control;
    public function __construct($dir, $default){
        /*  This is the file to be loaded when the load method is called with out
        **  a parameter 
        */
        $this->dir = $dir;
        $this->default = $default;
        $this->lpath = $this->get_lpath();
    }
    public function get_lpath(){
        return $this->get_url().$this->dir;
    }
    public function get_url(){
        return 'http://'.$_SERVER['SERVER_NAME'].(strpos($_SERVER['REQUEST_URI'],'.php')===false? substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-1) : substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/',strpos($_SERVER['REQUEST_URI'],'.php')-strlen($_SERVER['REQUEST_URI']))));
    }
    public function __set($name, $value){
        $this->$name = $value;
    }
    public function __get($name){
        return;
    }
    public function load($name = null){
        if($name === null){
            $name = $this->default;
        }
        include $this->dir.$name;
        return $this;
    }
    public function module($name){
        if(isset($this->modules[$name])){
            return $this->modules[$name];
        }else{
            try{
                if(!class_exists($name)){
                    include_once "/modules/$name/$name.class.php";
                    if(!class_exists($name)){
                        throw new Exception('The class could not be loaded');
                    }else{
                        $this->modules[$name] = new $name(true);
                        return $this->modules[$name];
                    }
                }else{
                    $this->modules[$name] = new $name(true);
                    return $this->modules[$name];
                }
            }catch(Exception $e){
                return false;
            }
        }
    }
    public function get($name){
        /* This function is used to allow consitant layout peices ie
         * header, footer, nav and will include these files in your theme
        */
        @include $this->dir.$name.'.php';
    }
    public function set_dir($value){
        $this->dir = $value;
        $this->lpath = $this->get_lpath();
    }
    public function get_widgets(){
        return $this->widgets;
    }
    public function set_widgets($widgets){
        $this->widgets = $widgets;
    }
}
?>