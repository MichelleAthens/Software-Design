<?php
	$response = file_get_contents('php://input');
	$send = json_decode($response,true);
	
	
	
	$out=json_encode($send,true);
	$curl = curl_init();

	#echo $out;


	#$url="localhost:8080/php/FINAL/releaseexam/release_able_exams.php";
 $url="https://web.njit.edu/~mmd38/CS490/rc/middle/see_grades_teacher/update_grade_middle.php";
	#$url="localhost:8080/php/rc/middle/create_premade_middle/get_premade_middle.php";
	//========================================================
	# $url="https://web.njit.edu/~mmd38/CS490/rc/middle/loginmiddle.php";
	  
	  curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => $out
	  ));
	$resp = curl_exec($curl);
	
	
	echo $resp;
	//========================================================

?>