<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class page_item extends nexus_core{
    private $id, $contents, $title, $permissions, $published, $username;
    public function __construct($isview = false){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function set_values($results){
        foreach($results as $key => $value){
            $this->$key = $value;
        }
    }
    public function get_contents(){
        return $this->contents;
    }
    public function get_title(){
        return $this->title;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_permissions(){
        return $this->permissions;
    }
    public function get_published($format){
        return date($format, strtotime($this->published));
    }
    public function get_author(){
        return $this->username;
    }
}
?>