<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
//should the error report be displayed or generic error page
define('DISPLAY_ERRORS', false);
ini_set('display_errors', DISPLAY_ERRORS);
ini_set('log_errors', 1);
ini_set('error_log','debug.log');
include_once 'includes/widget.class.php';

/*
 * this allows you to set different varibles for the enviroment such as different
 * parameters for production vs. development databases
*/
define('ENVIROMENT', 0);


/* this is the database prefix the default is nx */
define('DBPREFIX', 'nx_');


/* add the nexus root to the include path */
$start = strpos($_SERVER['REQUEST_URI'], 'index.php');
if($start !== false){
    $root = substr($_SERVER['REQUEST_URI'],0,$start);
}else{
    $root = $_SERVER['REQUEST_URI'];
}
$path = $_SERVER['DOCUMENT_ROOT'].$root;
ini_set('include_path', get_include_path() . PATH_SEPARATOR . $path);
unset($start, $root, $path);
/*
 * This function is a simple function that checks if a file exists on the 
 * Include path as well as in its regular path
 *
 * @param string $file the name of the file
 * @return bool
 */
function file_exists_for_include($file){
    if(!file_exists($file)){
        $paths = explode(PATH_SEPARATOR,get_include_path());
        foreach($paths as $p){
            if(file_exists(preg_replace('%/$%','',$p)."/$file")){
                return true;
            }
        }
        return false;
    }
    else{
        return true;
    }
}
/*
 * This is a function that helps to simplify the loading
 * of core classes and components as well as creating global instances of
 * objects
 *
 * @param string $classname the name of the class
 * @param any $optional an optional parameter to pass info to the constructor
 * @return bool
 */
function &load_class($classname , $optional = true){
    static $objects = array();
    if(isset($objects[$classname])){
        return $objects[$classname];
    }
    if(file_exists_for_include("modules/$classname/$classname.class.php")){
        include_once "modules/$classname/$classname.class.php";
    }elseif(file_exists_for_include("includes/$classname.class.php")){
        include_once "includes/$classname.class.php";
    }else{
        $objects[$classname] = false;
        return $objects[$classname];
    }
    $class =& instantiate_ref(new $classname($optional));
    $objects[$classname] = $class;
    return $class;
}
/*
 * This function fill attempt load classes that have not been
 * loaded(including dependencies) and on fail it will redirect to an error page
 *
 * @param string $classname the name of the class that hasen't been loaded
*/
function __autoload($classname){
    $instance =& load_class($classname);
    if(!class_exists($classname)){
        return false;
    }
}
/*
 * This is a simple class that creates a memory referance to an object instead of
 * a createing just an object
 *
 * @param object $instance pass this a new class instance and it returns a memory referance for example "new page()"
 * @return object it returns the object
*/
function &instantiate_ref(&$instance){
    return $instance;
}
?>