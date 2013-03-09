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
 
}