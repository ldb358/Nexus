<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class post_feed extends feed{
    public function __construct($isview = false, $query){
        $this->query = $query;
        try{
            parent::__construct($isview);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function execute(){
        //build query
        include_once 'modules/post/post.class.php';
        $dbprefix = DBPREFIX;
        $sql = "SELECT {$dbprefix}post.content_id, {$dbprefix}post.title, {$dbprefix}post.desc, {$dbprefix}post.body, {$dbprefix}post.image,
                {$dbprefix}content.published, {$dbprefix}content.permissions,
                {$dbprefix}users.username
                FROM {$dbprefix}post
                JOIN {$dbprefix}content ON {$dbprefix}post.content_id = {$dbprefix}content.content_id
                JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id";
        //add joins
        $sql .= $this->build();
        $this->db->prepare($sql);
        $results = array();
        $this->db->sql->bind_result(
            $results['id'], $results['title'], $results['desc'],
            $results['body'], $results['image'], $results['published'],
            $results['permissions'], $results['username']
        );
        $this->db->sql->execute();
        @include_once 'modules/post/post_item.class.php';
        while($this->db->sql->fetch()){
            $post = new post_item(true);
            $post->set_values($results);
            $this->feed[] = $post;
        }
        $this->db->sql->close();
        return $this;
    }
}
?>