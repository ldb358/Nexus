<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class media_item extends nexus_core{
    protected $id, $title, $url, $author, $published, $permissions;
    public function __construct($isview){
        if(!$isview){
            try{ parent::__construct($isview); }catch(Exception $e){
                $redirect = new reroute();
                $redirect->route('error', 'database');
            }
        }
        $this->mpath = 'http://'.$_SERVER['SERVER_NAME'].(strpos($_SERVER['REQUEST_URI'],'.php')===false? substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-1) : substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/',strpos($_SERVER['REQUEST_URI'],'.php')-strlen($_SERVER['REQUEST_URI'])))).'/';
    }
    public function __call($id, $args){
        $dbprefix = DBPREFIX;
        $sql = "SELECT {$dbprefix}media.id, {$dbprefix}media.title, {$dbprefix}media.url,
                {$dbprefix}content.published, {$dbprefix}content.permissions,
                {$dbprefix}users.username
                FROM {$dbprefix}media
                JOIN {$dbprefix}content ON {$dbprefix}media.id = {$dbprefix}content.content_id
                JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id";
        if(filter_var($id, FILTER_VALIDATE_INT)){
            //is id
            $this->db->prepare($sql.= "WHERE id=?");
            $this->db->sql->bind_param('i', $id);
        }else{
            //is title
            $this->db->prepare($sql.= "WHERE title=?");
            $this->db->sql->bind_param('s', $id);
        }
        $results = array();
        $this->db->sql->bind_result($results['id'], $results['title'], $results['url'],
                                    $results['published'], $results['permissions'],
                                    $results['username']);
        $this->db->query();
        foreach($results as $key => $value){
            $this->$key = $value;
            $this->view->$key = $value;
        }
        if(empty($this->id)){
            $redirect = new reroute();
            $redirect->route();
        }
        $this->view->load();
    }
    public function set_values($results){
        foreach($results as $key => $value){
            $this->$key = $value;
        }
    }
    public function get_id(){
        return $this->id;
    }
    public function get_title(){
        return $this->title;
    }
    public function get_url(){
        return $this->url;
    }
    public function get_embed($width){
        if(preg_match('/youtube\.com.*?v=(?P<code>.+?)(&|$|\/)/', $this->url,$matches)){
            $code = $matches['code'];
            $height = $width*(390/640);
            return "<iframe title='YouTube video player' width='$width' height='$height' src='http://www.youtube.com/embed/$code' frameborder='0' allowfullscreen></iframe>";
        }else{
            return "<img src='{$this->mpath}{$this->url}' alt='{$this->title}' />";
        }
    }
    public function get_published($format){
        return date($format, strtotime($this->published));
    }
    public function get_permissions(){
        return $this->permissions;
    }
}