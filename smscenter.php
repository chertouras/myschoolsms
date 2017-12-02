<?php
/************************************************ 
 * 
 * 
 * Παρακαλώ μελετήστε τις λεπτομέρειες που παρέχονται 
 * στο https://easysms.gr/app/sms-http-api
 * 
 * Εταιρία TERN: http://www.tern.gr/
 *  
 * 
 * 
*************************************************/
// Simple SMS send function
	session_start();
	$now = time();
	if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
		
		session_unset();
		session_destroy();
	   
	}
	
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=1){
		header('Location: index.php');
		exit();
	}
	
	$key='xxxxxxxxxx';//PUT TERN www.easysms.gr KEY HERE
	$message=$_POST['message'];
	$to=$_POST['to'];
	$type='json';
	$originator='xxxxxxxx'; //From whom
	
	function sendSMS($key, $to, $message, $originator , $type) {
		$URL = "https://easysms.gr/api/sms/send?key=" . $key . "&to=" . $to;
		$URL .= "&text=" . urlencode( $message ) . '&from=' . urlencode( $originator ) . "&type=" . $type ;
		$fp = fopen( $URL, 'r' );
		return fread( $fp, 1024 );
	}
	// Example of use sendSMS
    $response = sendSMS( $key, $to, $message, $originator , $type);
  	echo $response;







?>