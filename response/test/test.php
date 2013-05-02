<?php
class ajaxTest
{

 function alertCall()
 {
     $response = new JAXResponse;
     $response->addAlert('ya success');
	 return $response->sendResponse();
 }
 function emptyCall()
 {
  $response = new JAXResponse; 
  $response->addScriptCall('jQuery("<div />").addClass("testCtnr").html("yes this element is created from ajax response").appendTo("#div1");');
  return $response->sendResponse();
 }
 
 function argumentCallSingle($value)
 {
   $response = new JAXResponse; 
   $response->addAssign('div2','innerHTML','The value '.$value.' from ajax response');
   return $response->sendResponse();
 }
 
 function argumentCallMultiple($value1,$value2)
 {
    $response = new JAXResponse; 
    $response->addAssign('div3','innerHTML','The value '.$value1.' and '.$value2.' from ajax response');
    return $response->sendResponse();
 }
 
 function outputFromTemplate()
 {
	 $tmpl = new Template();
	 $html = $tmpl->set('title','Hello World')
	              ->set('description','This Content Is Fetch From A Template')
				  ->fetch('helloworld.php');
	$response = new JAXResponse; 
    $response->addAssign('div3','innerHTML', $html);
    return $response->sendResponse(); 
 }
 
}