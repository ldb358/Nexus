<?php
session_start();
define('__nexus',true);
include_once 'config/general.php';
include_once 'includes/core.class.php';
include_once 'includes/reroute.class.php';
include_once 'includes/master_widget.class.php';
if(isset($_POST['action'])){
    if(file_exists("modules/{$_POST['action']}/{$_POST['action']}.class.php")){
        include_once "modules/{$_POST['action']}/{$_POST['action']}.class.php";
        $page = new $_POST['action']();
        $page->process($_POST['method'],array_merge($_POST[$_POST['method']], @$_FILES));
    }else{
        $redirect = new reroute();
        $redirect->route($_GET['method'], $_GET['action']);
    }
}else if(!empty($_GET['action'])){
    if($_GET['action'] == 'error'){
        if(file_exists('includes/error.class.php')){
            include_once 'includes/error.class.php';
            $method = !empty($_GET['method'])? $_GET['method'] : 'default';
            $page = new error(DISPLAY_ERRORS);
            $page->$method();
        }else{
            $redirect = new reroute();
            $redirect->route();
        }
    }else{
        if(file_exists("modules/{$_GET['action']}/{$_GET['action']}.class.php")){
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
    }
}else{
    if(file_exists('modules/page/page.class.php')){
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
?>