<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class page_new_form extends form{
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
                'default' => 'Create Post'
            )
        );
        parent::__construct($action, $method, $fields);
    }
    public function process($form, db $db){
        $dbprefix = DBPREFIX;
        @$title = $form['title'];
        @$contents = $form['contents'];
        if(!empty($title) && !empty($content)){
            include_once '/modules/user/user.class.php';
            $user = new user();
            $userid = $user->get_user_info('id');
            //query and get type_id
            $db->prepare("SELECT type FROM {$dbprefix}content_type WHERE `desc`='page'");
            $db->sql->bind_result($type);
            $db->query();
            //query and get the new content_id
            $db->prepare("SELECT content_id FROM {$dbprefix}content ORDER BY content_id DESC LIMIT 1");
            $db->sql->bind_result($id);
            $db->query();
            $id++;
            //insert into the content feed
            $db->prepare("INSERT INTO {$dbprefix}content( content_id, type, user_id, published, permissions) VALUES(?,?,?,?,10)");
            $db->sql->bind_param('iiis', $id, $type, $userid, date('Y-m-d G:i:s'));
            $db->query();
            //insert into media
            $db->prepare("INSERT INTO {$dbprefix}page(id, title, contents) VALUES(?, ?, ?)");
            $db->sql->bind_param('iss', $id, $title, $contents);
            $db->query();
            return $this->error(array('title'=>'', 'contents'=> ''), "Page Added");
        }else{
            return $this->error(array('title'=> $title, 'contents'=> $contents), "All Fields Are Required");
        }
    }
}
?>