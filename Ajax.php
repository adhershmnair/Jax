<?php
class Ajax
{
	var $option = null;
    var $func = null;
	var $args = null;
	
	function nl2brStrict($text) {
		return preg_replace("/\r\n|\n|\r/", " <br />", $text);
	}
	
	function br2nl($text){
		$text = str_replace(' <br />', "\n", $text);
		return $this->_fixQuote($text);	
	}
	
	function _fixQuote($text){
		return str_replace('&quot;', '"', $text);
	}

	function singleLineIt($text){
		return preg_replace("((\r\n)+)", '', $text);
	}
		
	/**
	 *
	 */	 	
	function route()
	{
 
		if(!defined('SERVICES_JSON_SLICE'))
		{
			include_once('Json.php');
		}
			
		$json = new Services_JSON();
		
		if(@isset($_REQUEST['task']) && ($_REQUEST['task'] == 'azrul_ajax'))
		{	
 
			
			$func = @$_REQUEST['func'];
			$option = @$_REQUEST['option'];
			// Security fix.
			// 1. check if user are trying to run an eval
			
			# build an array of args
			$args = array();
			$argCount = 0;
			
			# All POST data that are meant to be send to the function will
			# be appended by 'arg' keyword. Only pass this vars to the function
			foreach($_REQUEST as $key => $postData)
			{
				if(substr($key, 0, 3) == 'arg' )
				{
					//if ( get_magic_quotes_gpc() ) {
						$postData = stripslashes($postData);
					//}


					$postData = ($this->nl2brStrict($postData));
					//var_dump($postData);				
					$decoded = $json->decode($postData);
					$key = "";
					$val = "";

// print_r($decoded);
// exit;
					# if the args is an array, we need to pass it as an array
					# todo@ we need to expand this array further. We now assume,
					# if an array is passed, it comes in a pair of (key/value)												
					if(is_array($decoded))
					{
						foreach($decoded as $index => $value)
						{
							$tempArray	= array();
							
							if( is_array($value) )
							{
								foreach($value as $val)
								{
									
									
									// The value is an array so we need to chuck them in
									// a multidimensional array instead
									if( is_array($val) )
									{
										// Since the values here are array, we will
										// always assume that the index 0 is always the key
										$key	= $val[0];
										$data	= $this->br2nl( rawurldecode($val[1]) );
										
										// We will also always assume that the index 1 will be the value
										$decoded[$key][]	= $data;
									}
									else
									{
										// We always assume that the index 0 is the key of the array.
										$key	= $value[0];
										
										// We always assume that the index 1 is the data of the array.
										$data	= $this->br2nl(rawurldecode($value[1]));
										
										if( substr($value[0], 0, 6) == '_d_' )
										{
											$decoded = array($val);
										}
										else
										{
											$newArray	= array( $key => $data );
											$decoded	= array_merge( $decoded, $newArray );
											//$newA		= array($key => $val);
											//$decoded	= array_merge($decoded, $newA);
										}
									}
								}
							} else{
								// If data passed is not array we treat
								if($value != '_d_' ){
									$decoded = $this->br2nl(rawurldecode($value));
								}
							}
						}

						$args[] = $decoded;
					} else {
						$args[] = $this->br2nl(rawurldecode($decoded));
					}
					$argCount++;
				}
			}

 
			$this->func = $func ;
			$this->args = $args ;
			$this->option = $option ;
  
		}
	}
	
    function run()
    {
			// Built-in ajax calls go here
			 		 
			 
			$func		=  $this->func; //$_REQUEST['func'];
			$args       =  $this->args;
			$option     =  $this->option;
			
			$callArray	= explode(',', $func);

			$viewController = strtolower($callArray[0]);
			$viewControllerFile	= 'Response'.'/'.$option.'/'.$viewController . '.php';
			if(file_exists( $viewControllerFile ) )
			{	
				require_once('Response'.'/'.$option.'/'.$viewController . '.php' );
				$viewController = ucfirst($viewController);
				$viewController	= 'ajax'.$viewController;
				$controller		 = new $viewController();
		
				// Perform the Request task
				$output = call_user_func_array(array(&$controller, $callArray[1]), $args);
			}
			else
			{
				echo sprintf( 'File %1$s not found!' ,$viewControllerFile );
				exit;
			}
    }	
	
}

?>