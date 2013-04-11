<?php
include('Define.php');
include('Json.php');
include('Response.php');
include('Template.php');
include('Ajax.php');


//create ajax object
$ajax = new Ajax();
 
//routing the request
$ajax->route();
 
//execution
$ajax->run(); 

?>