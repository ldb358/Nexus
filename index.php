<?php
session_start();
/* prevents include files from being executed */
define('__nexus',true);

/* load the general settings file required for functionality */
include_once 'config/general.php';
$LK = load_class('link_in');

/* pass all init functions a referance to the link_in class so that they can
 * make changes to events/trigger events
 */
$LK->run('init');


$LK->run('end');
?>