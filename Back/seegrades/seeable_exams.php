<?php


#Get student name by username
	//$con = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	$array = array();
	$studentlastname = "";
	$studentid="";
	#$connection = mysqli_connect("localhost","root","password","mmd38");   
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
    $response = file_get_contents('php://input');
    $array  = json_decode($response,true);         
	
	#$array = array("username" => "mmd38");
	
	$username = $array['username'];
	
	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
	$identification = "s{$studentid}_{$studentlastname}";
	$queue = "SELECT * FROM $identification";
	
	$result = mysqli_query($connection,$queue);
	$sendarray = array();

 
	while($row=mysqli_fetch_assoc($result)){
		
		$available = $row['available'];
		if($available==="yes"){
			
			$examid 		= $row['ID'];
			$examname = $row['examname'];
			$professor 	= $row['professor'];
		
			$sendarray[] = array("examid" => $examid, "examname" => $examname, "professor" => $professor);
		}
	}
	
	
	if(!$sendarray){
		$sendarray[] = array("response" => "no released exams");
	}
	
	echo json_encode($sendarray,true);
	
	mysqli_close($connection);
	
?>