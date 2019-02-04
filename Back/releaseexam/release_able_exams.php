<?php
#STUDENT LOGIN
#
#+----------+--------------------------------------------------------------+------------+
#| username | password                                                     | exam       |
#+----------+--------------------------------------------------------------+------------+
#| mmd38    | ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~| EXAMSAMPLE |
#+----------+--------------------------------------------------------------+------------+

#===================================================================================
									#host     user    password     database
	$array=array();
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	#$connection = mysqli_connect("localhost","root","password","mmd38");    

    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);                       #Get the response
    
    
    $username = $decoder['username'];
	
#	$username="prof1";
	$data=['user'=>$username];
	extract($data);
	require 'getteacherlastname.php';

	
	$identification ="t{$id}_{$lastname}";

	
	$result = mysqli_query($connection,"SELECT * FROM $identification WHERE releasable like 'yes'");

	$rows = mysqli_num_rows($result);

	#==================================================================================
	for($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_assoc($result);
		$examid = $row['ID'];
		$examname = $row['examname'];
		
		$array[] =  array("examid" => $examid, "examname" => $examname);
		
	}
	//echo $array;
	$code = json_encode($array,true);
	mysqli_close($connection); 
	echo $code;

	#==================================================================================



?>
