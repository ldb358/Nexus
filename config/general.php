<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
//should the error report be displayed or generic error page
define('DISPLAY_ERRORS', false);
ini_set('display_errors', DISPLAY_ERRORS);
ini_set('log_errors', 1);
ini_set('error_log','debug.log');
/*this allows you to set different varibles for the enviroment such as different
**parameters for production vs. development databases
*/
define('ENVIROMENT', 0);
/* this is the database prefix the default is nx */
define('DBPREFIX', 'nx_');
?>