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
	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");    
#	$connection = mysqli_connect("localhost","root","password","mmd38");    

    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);                       #Get the response
    
    
    $username = $decoder['username'];
	
	#$username="prof1";
	
	$data=['username'=>$username];
	extract($data);
	require 'getteacherlastname.php';

	
	$identification ="t{$id}_{$lastname}";

	
	$result = mysqli_query($connection,"SELECT * FROM $identification");

	$rows = mysqli_num_rows($result);

	
	#==================================================================================
	if($rows){
	for($i = 0; $i < $rows; $i++)
		{
		$row = mysqli_fetch_assoc($result);
		$examid = $row['ID'];
		$examname = $row['examname'];
		$release		=$row['releasable'];
		
		$array[] =  array("examid" => $examid, "examname" => $examname,"release"=>$release);
		
		}
	}
	else{
		$array[]=array("response"=>"no exams");
	}
	//echo $array;
	$code = json_encode($array,true);
	mysqli_close($connection); 
	echo $code;

	#==================================================================================



?>
