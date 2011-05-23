<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class post_new_form extends form{
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
                'name' => 'desc',
                'label' => 'Enter a Short Summery of the Post:',
                'type' => 'textarea',
                'default' => ''
            ),
            array(
                'name' => 'body',
                'label' => 'Enter Post Contents:',
                'type' => 'textarea',
                'default' => ''
            ),
            array(
                'name' => 'image',
                'label' => 'Select a post thumbnail (optional)',
                'type' => 'file'
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
        @$body = $form['body'];
        @$desc = $form['desc'];
        @$image = $form['image'];
        if(!empty($title) && !empty($body)){
            //upload the image
            include_once '/modules/media/upload.form.php';
            $image = new media_upload_form();
            $uploaded = $image->process($form, $db);
            if($uploaded != 'Image Uploaded'){
                return $this->error($form, $uploaded);
            }
            $image_src = $image->path;
            //query and get the new content_id
            include_once '/modules/user/user.class.php';
            $user = new user();
            $userid = $user->get_user_info('id');
            //query and get type_id
            $db->prepare("SELECT type FROM {$dbprefix}content_type WHERE `desc`='post'");
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
            //insert into page
            $db->prepare("INSERT INTO {$dbprefix}post(content_id, title, desc, body, image) VALUES(?, ?, ?, ?, ?)");
            $db->sql->bind_param('iss', $id, $title, $desc, $body, $image_src);
            $db->query();
            return $this->error(array(), "Page Added");
        }else{
            return $this->error($form, "All Fields Are Required");
        }
    }
}
?>