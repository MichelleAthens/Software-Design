<?php
	$response = file_get_contents('php://input');
	$send = json_decode($response,true);
	
	$curl = curl_init();


	$send = json_encode($send,true);

	#$url="https://web.njit.edu/~mmd38/FINAL/createexam_premade/get_premade.php";
	#$url="https://web.njit.edu/~mmd38/FINAL/deletequestion/delete_question.php";
	//========================================================
	$url="https://web.njit.edu/~mmd38/CS490/rc/middle/deletequestion/deletequestion_middle.php";
	  
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

?>