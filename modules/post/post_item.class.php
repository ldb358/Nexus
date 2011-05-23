<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class post_item extends nexus_core{
    protected $id, $title, $desc, $body, $image, $author, $published, $permissions;
    public function __construct($isview){
        try{ parent::__construct($isview); }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function __call($id, $args){
        $dbprefix = DBPREFIX;
        $sql = "SELECT {$dbprefix}post.content_id, {$dbprefix}post.title, {$dbprefix}post.desc, {$dbprefix}post.body, {$dbprefix}post.image,
                {$dbprefix}content.published, {$dbprefix}content.permissions,
                {$dbprefix}users.username,
                FROM {$dbprefix}post
                JOIN {$dbprefix}content ON {$dbprefix}post.content_id = {$dbprefix}content.content_id
                JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id ";
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
        $this->db->sql->bind_result($results['id'], $results['title'], $results['desc'],
                                    $results['body'], $results['image'], $results['published'],
                                    $results['permissions'], $results['username']);
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
    public function get_body(){
        return $this->body;
    }
    public function get_desc(){
        return $this->desc;
    }
    public function get_author(){
        return $this->author;
    }
    public function get_image($max_width = 300, $max_height = 300){
        return $this->image;
    }
    public function get_published($format){
        return date($format, strtotime($this->published));
    }
    public function get_permissions(){
        return $this->permissions;
    }
}