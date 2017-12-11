<?php

	$send=array();
	$response = file_get_contents('php://input');
	
	$send = json_decode($response,true);
	
	
	
	
	$send=json_encode($send,true);



	$curl = curl_init();
	
	$url="https://web.njit.edu/~mmd38/CS490/rc/Back/createexam_premade/create_exam_p.php";
	#$url="localhost:8080/php/FINAL/createexam_premade/create_exam_p.php";

  //========================================================
	# $url="https://web.njit.edu/~mmd38/CS490/rc/middle/loginmiddle.php";
	  
	  curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => $send
	  ));
	$resp = curl_exec($curl);
	echo $resp
	//========================================================
//*/
?>