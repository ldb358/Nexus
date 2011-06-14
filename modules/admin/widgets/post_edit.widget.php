<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class post_edit extends widget{
    protected $control, $params;
    public function __construct(db $db, $params){
        try{
            parent::__construct($db, $params);
        }catch(Exception $e){
            $redirect = new reroute();
            $redirect->route('error', 'database');
        }
    }
    public function set_header(){
        $this->header = 'Edit posts';
    }
    public function set_body(){
        $body = '';
        /*this needs to loop through the feed list all of the posts ids, titles,
         the user who published it and the date with a form hidden under it
         with all of the editable fields
        */
        //get the current user info
        @include_once 'modules/user/user.class.php';
        $user = new user(true);
        $user_level = $user->get_user_info('level');
        if(!filter_var($user_level, FILTER_VALIDATE_INT)){
            $user_level = 10;
        }
        //get the feed
        @include_once 'modules/feed/feed.class.php';
        if(!class_exists('feed')){
            return 'An error has occured';
        }
        $feed = new feed(true);
        $dbprefix = DBPREFIX;
        $posts = $feed->get_feed('post')->level($user_level)->order_by("{$dbprefix}content.published")->execute();
        //get form
        @include_once 'modules/post/post.class.php';
        if(!class_exists('post')){
            return 'An error has occured';
        }
        $post_class = new post(true);
        $form = $post_class->get_new_form_object();
        $form->set_action('admin');
        $form->set_method('post');
        $form->set_widget('edit');
        $form_fields = $form->get_fields();
        $form_fields[count($form_fields)] = array(
            'name' => 'id',
            'type' => 'hidden',
            'default' => ''
        );
        ob_start();
        include 'themes/post_edit.php';
        $contents = ob_get_clean();
        $this->body = $contents;
    }
}