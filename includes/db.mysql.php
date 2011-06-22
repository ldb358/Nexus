<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/* This is the mysql implmentation of the db abstract */
include_once 'db.abstract.php';
if(!class_exists('db')){ exit(); }
class db_mysql extends db{
    public $info;
    protected function connect(){
        if(isset($this->args['host'], $this->args['username'],$this->args['password'],$this->args['database'])){
            $this->db = new mysqli($this->args['host'],$this->args['username'],$this->args['password']);
            $this->db->select_db($this->args['database']);
            if($this->db instanceof db){
                unset($this->args);
            }
            return $this->db;
        }else{
            return false;
        }
    }
    public function prepare($sql){
        $this->sql = $this->db->prepare($sql);
    }
    public function close(){
        $this->db->close();
    }
    public function query($sql = null){
        if(!is_null($sql)){
            return $this->db->query($sql);
        }else{
            $this->sql->execute();
            $this->info = array($this->sql->num_rows, $this->sql->affected_rows, $this->sql->error);
            $this->sql->fetch();
            $this->sql->close();
        }
        $this->sql = null; 
    }
    public function get_error_message(){
        return $this->db->error;
    }
    public function get_affected_rows(){
        return $this->info[1];
    }
}
?>