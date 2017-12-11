<?php
	$response = file_get_contents('php://input');
	$data = json_decode($response,true);

 
 $username = $data['username'];
 $username = "111";
 $array = array("username" => $username, "testing this" => 777);
 
 $send = json_encode($array,true);
	

 echo $send;
?>