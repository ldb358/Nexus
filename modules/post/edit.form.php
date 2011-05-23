<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class page_edit_form extends form{
    public function __construct(){
        $action = 'page';
        $method = 'new';
        $fields = array(
            array(
                'name' => 'title',
                'label' => 'Title:',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'contents',
                'label' => 'Enter Page Contents:',
                'type' => 'textarea',
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
        @$contents = $form['contents'];
        @$id = $form['id'];
        if(!empty($title) && !empty($contents) && (!empty($id) && $id !== 0)){
            //query and get the new content_id
            $db->prepare("SELECT content_id FROM {$dbprefix}content WHERE {$dbprefix}content.content_id=?");
            $db->sql->bind_param('i', $id);
            $db->sql->bind_result($id);
            $db->query();
            if(!empty($id)){
                //update feed
                $db->prepare("UPDATE {$dbprefix}page SET {$dbprefix}page.title=?, {$dbprefix}page.contents=? WHERE {$dbprefix}page.id=?");
                $db->sql->bind_param('ssi', $title, $contents, $id);
                $db->query();
                return $this->error(array('title'=>'', 'contents'=> ''), "Page Updated");
            }else{
                return $this->error(array('title' => $title, 'contents' => $contents), 'Invalid Form');
            }
        }else{
            return $this->error(array('title'=> $title, 'contents'=> $contents), "All Fields Are Required");
        }
    }
}
?>