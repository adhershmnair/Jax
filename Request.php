<?php
include(realpath(__DIR__).'/Define.php');
include(realpath(__DIR__).'/Json.php');
include(realpath(__DIR__).'/Response.php');
include(realpath(__DIR__).'/Template.php');
include(realpath(__DIR__).'/Ajax.php');


//create ajax object
$ajax = new Ajax();
 
//routing the request
$ajax->route();
 
//execution
$ajax->run(); 

?>