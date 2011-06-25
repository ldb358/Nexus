<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
/*function that will check the settings for the module and method to be loaded
* to ensure that the user is of the appropriate level to perform the action that
* they are trying to do. it also checks that the module being loaded is active.
*/
function validate_permissions(){
    $user =& load_class('user');
    $level = $user->get_user_info('level');
    if($level === false){
        $level = 10;
    }
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        $method = $_POST['method'];
    }else if(isset($_GET['action'])){
        $action = $_GET['action'];
        $method = $_GET['action'];
    }
    if(isset($action)){
        ob_start();
        @include "modules/{$action}/{$action}.json.php";
        $settings = ob_get_contents();
        ob_end_clean();
        if(!empty($settings)){
            $settings = json_decode($settings, true);
            if(isset($settings[$method]['user_level'])){
                $page_level = $settings[$method]['user_level'];
            }else{
                $page_level = $settings['user_level'];
            }
            if(isset($settings[$method]['active'])){
                $active = $settings[$method]['active'];
            }else{
                $active = $settings['active'];
            }
            if(isset($settings[$method]['executable'])){
                $exe = $settings[$method]['executable'];
            }else{
                $exe = $settings['executable'];
            }
        }else{
            $active = false;
        }
        if(!$active || $page_level < $level || !$exe){
            $redirect = new reroute();
            $redirect->route('error', 'permission');
        }
    }
}
function run_route(){
    $LK =& load_class('link_in');
    if(isset($_POST['action'])){
        if(file_exists_for_include("modules/{$_POST['action']}/{$_POST['action']}.class.php")){
            $LK->run('pre_post_action');
            include_once "modules/{$_POST['action']}/{$_POST['action']}.class.php";
            $page = new $_POST['action']();
            $page->process($_POST['method'],array_merge($_POST[$_POST['method']], @$_FILES));
            $LK->run('post_post_action');
        }else{
            $LK->run('pre_error_action');
            $redirect = new reroute();
            $redirect->route($_GET['method'], $_GET['action']);
            $LK->run('post_error_action');
        }
    }else if(!empty($_GET['action'])){
        /* else load the appopreate module via get*/
        if(file_exists_for_include("modules/{$_GET['action']}/{$_GET['action']}.class.php")){
            include_once "modules/{$_GET['action']}/{$_GET['action']}.class.php";
            $method = !empty($_GET['method'])? $_GET['method'] : 'default';
            $page = new $_GET['action']();
            @$extra = $_GET['extra'];
            $extra = explode('/', $extra);
            $page->$method($extra);
        }else{
            $redirect = new reroute();
            $redirect->route();
        }
    }else{
        /* else load the home page */
        if(file_exists_for_include('modules/page/page.class.php')){
            include_once 'modules/page/page.class.php';
            $page = new page();
            $home = $page->get_site_option('home_page');
            if(!empty($home)){
                $page->$home();
            }else{
                $redirect = new reroute();
                $redirect->route('error', '404');
            }
        }else{
            $redirect = new reroute();
            $redirect->route('error', '404');
        }
    }
}
?>