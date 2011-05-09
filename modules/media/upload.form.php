<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
include_once '/includes/form.class.php';
class media_upload_form extends form{
    public function __construct(){
        $action = 'media';
        $method = 'upload';
        $fields = array(
            array(
                'name' => 'image',
                'label' => 'Image',
                'type' => 'file',
                'default' => ''
            ),
            array(
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'type' => 'submit',
                'default' => 'Upload'
            )
        );
        parent::__construct($action, $method, $fields);
    }
    public function process($form, db $db){
        $dbprefix = DBPREFIX;
        $db->prepare("SELECT value FROM {$dbprefix}options WHERE name=? LIMIT 1");
        $name = 'max_image_size';
        $db->sql->bind_param('s', $name);
        $db->sql->bind_result($maxsize);
        $db->query();
        $upload = $form['image'];
        //see if the image is under the maximum file size in megabytes
        if(filesize($upload['tmp_name'])/1048576 < (int)$maxsize){
            list($width, $height, $type2) = getimagesize($upload['tmp_name']);
            $type =  image_type_to_mime_type($type2);
            if((($type == "image/jpeg") || ($type == "image/pjpeg") || ($type == "image/gif") || ($type == "image/png"))){
                if($upload['error'] == 0){  
                    $username = $_SESSION['username'];
                    $ext = substr($upload['name'],strrpos($upload['name'],"."));
                    $new_src = $_SERVER['DOCUMENT_ROOT'].substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],'/index.php',1));
                    $relative  = "media/".date('Y/m/d/');
                    $new_src .= $relative;
                    if(!is_dir($new_src)){
                        if(!mkdir($new_src, 0777, true)){
                            return $this->error($form, 'Failed to Create Path');
                        }
                    }
                    $title = htmlentities($form['title']);
                    $new_src .= $form['title'].$ext;
                    $relative .= $form['title'].$ext;
                    include_once '/modules/user/user.class.php';
                    $user = new user();
                    $userid = $user->get_user_info('id');
                    if(!file_exists($new_src)){
                        //query and get type_id
                        $db->prepare("SELECT type FROM {$dbprefix}content_type WHERE `desc`='image'");
                        $db->sql->bind_result($type);
                        $db->query();
                        //query and get the new content_id
                        $db->prepare("SELECT content_id FROM {$dbprefix}content ORDER BY content_id DESC LIMIT 1");
                        $db->sql->bind_result($id);
                        $db->query();
                        $id++;
                        move_uploaded_file($upload['tmp_name'], $new_src);
                        $db->prepare("INSERT INTO {$dbprefix}content( content_id, type, user_id, published, permissions) VALUES(?,?,?,?,10)");
                        $db->sql->bind_param('iiis', $id, $type, $userid, date('Y-m-d G:i:s'));
                        $db->query();
                        $db->prepare("INSERT INTO {$dbprefix}media(id, title, url) VALUES(?, ?, ?)");
                        $db->sql->bind_param('iss', $id, $title, $relative);
                        $db->query();
                        return $this->error($form, "Image Uploaded");
                    }else{
                        return $this->error($form, "File with same title already taken");
                    }
                }else{
                    return $this->error($form, "unexpected file error");
                }
            }else{
                return $this->error($form, "invalid file type");
            }
        }else{
            return $this->error($form, "file size is to big");
        }
    }
}
?>