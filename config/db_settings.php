<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/* This function is the key to connecting to the database of your choice as well
 * as choose the proper abstraction layer for that database
 * @param int $enviroment this parameter tells the function what settings to load
 * in order to connect to the database
 */
if(!isset($DB)) $DB = null;
function db_factory($enviroment = ENVIROMENT){
    /* This should be an array that contains all of the connection information needed
     * by the abstraction layer in order to connect to the database the only required
     * varible is type( so that it can load the database )
     */
    global $DB;
    if($enviroment == 1){
        $args = array(
            'type' => 'mysql',
            'host' => 'localhost',
            'username' => 'lane',
            'password' => 'enter1',
            'database' => 'nexus'
        );
    }else if($enviroment == 0){
         $args = array(
            'type' => 'mysql',
            'host' => 'localhost',
            'username' => 'lane',
            'password' => 'enter1',
            'database' => 'nexus'
        );
    }
    if($DB instanceof db){
        return $DB;
    }else{
        try{
            $class = "db_{$args['type']}";
            include_once "includes/db.{$args['type']}.php";
            if(class_exists($class)){
                $db = new $class($args);
                if($db) throw new Exception('created');
                else throw new Exception('failed');
            }
            throw new Exception('failed');
        }catch(Exception $e){
            if($e->getMessage() == 'failed'){
                return false;
            }else{
                $DB = $db;
                return $db;
            }
        }
    }
}
?>