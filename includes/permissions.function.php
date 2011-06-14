<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
    /* encapsulated function that will check the settings for the module and method to be loaded
    * to ensure that the user is of the appropriate level to perform the action that
    * they are trying to do it also checks that the module being loaded is active
    */
include_once 'modules/user/user.class.php';
$user = new user(true);
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
    }else{
        $active = false;
    }
    if(!$active || $page_level < $level){
        $redirect = new reroute();
        $redirect->route('error', 'permission');
    }
}
//clean up the global scope
unset($user, $level, $action, $method, $settings, $page_level);
?> 