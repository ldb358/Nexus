<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once 'includes/form.class.php';
class media_edit_form extends form{
    public function __construct(){
        $action = 'media';
        $method = 'new';
        $fields = array(
            array(
                'name' => 'title',
                'label' => 'Title:',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'type' => 'submit',
                'default' => 'Submit Post'
            )
        );
        parent::__construct($action, $method, $fields);
    }
    public function process($form, db $db){
        $dbprefix = DBPREFIX;
        @$title = $form['title'];
        @$id = $form['id'];
        if(!empty($title) && (!empty($id) && $id !== 0)){
            //query and get the new content_id
            $db->prepare("SELECT content_id FROM {$dbprefix}content WHERE {$dbprefix}content.content_id=?");
            $db->sql->bind_param('i', $id);
            $db->sql->bind_result($id);
            $db->query();
            if(!empty($id)){
                //update feed
                $db->prepare("UPDATE {$dbprefix}media SET {$dbprefix}media.title=? WHERE {$dbprefix}media.id=?");
                $db->sql->bind_param('si', $title, $id);
                $db->query();
                return $this->error(array('title'=>'', 'contents'=> ''), "Media Updated");
            }else{
                return $this->error(array('title' => $title, 'contents' => $contents), 'Invalid Form');
            }
        }else{
            return $this->error(array('title'=> $title, 'contents'=> $contents), "All Fields Are Required");
        }
    }
}
?>