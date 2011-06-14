<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class page_feed extends feed{
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
        include_once 'modules/page/page_item.class.php';
        $dbprefix = DBPREFIX;
        $sql = "SELECT {$dbprefix}page.id, {$dbprefix}page.title, {$dbprefix}page.contents,
                {$dbprefix}content.published, {$dbprefix}content.permissions,
                {$dbprefix}users.username
                FROM {$dbprefix}page
                JOIN {$dbprefix}content ON {$dbprefix}page.id = {$dbprefix}content.content_id
                JOIN {$dbprefix}users ON {$dbprefix}content.user_id = {$dbprefix}users.id";
        //add joins
        $sql .= $this->build();
        $this->db->prepare($sql);
        $results = array();
        $this->db->sql->bind_result(
            $results['id'], $results['title'],
            $results['contents'], $results['published'],
            $results['permissions'], $results['username']
        );
        $this->db->sql->execute();
        while($this->db->sql->fetch()){
            $post = new page_item(true);
            $post->set_values($results);
            $this->feed[] = $post;
        }
        $this->db->sql->close();
        return $this;
    }
}
?>