<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/* This is the abstract for all database objects */
abstract class db{
    public $db, $args, $fields, $sql;
    public function __construct($args){
        $this->args = $args;
        $this->db = $this->connect();
    }
    abstract protected function connect();
    abstract public function close();
    abstract public function prepare($sql);
    abstract public function query($sql = null);
    abstract public function get_error_message();
}
?>