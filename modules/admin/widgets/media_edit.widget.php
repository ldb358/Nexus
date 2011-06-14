<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
class media_edit extends widget{
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
        $this->header = 'Edit Media';
    }
    public function set_body(){
        $body = '';
        /*this needs to loop through the feed list all of the pages ids, titles,
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
        $media_items = $feed->get_feed('media')->level($user_level)->order_by("{$dbprefix}content.published")->execute();
        //get form
        @include_once 'modules/media/media.class.php';
        if(!class_exists('media')){
            return 'An error has occured';
        }
        $media_class = new media(true);
        $form = $media_class->get_upload_form_object();
        $form->set_action('admin');
        $form->set_method('media');
        $form->set_widget('edit');
        $form_fields = $form->get_fields();
        $form_fields = array(
            array(
                'name' => 'id',
                'type' => 'hidden',
                'default' => ''
            ),
            array(
                'name' => 'title',
                'type' => 'text',
                'default' => ''
            ),
            array(
                'name' => 'submit',
                'type' => 'submit',
                'default' => 'Edit Title'
            )
        );
        ob_start();
        include 'themes/media_edit.php';
        $contents = ob_get_clean();
        $this->body = $contents;
    }
}