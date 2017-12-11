<?php
#Receive selected exam and display grade
	$array = array();
	
	#$connection = mysqli_connect("localhost","root","password","mmd38");
	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");   
	$response = file_get_contents('php://input');
   	$array  = json_decode($response,true);        
	$sendarray = array();
	
  #$array=array("username" =>"mmd38", "examid" => 5, "examname" => "k", "professor" => "ryan");
	
	$username 	= $array['username'];
	$examid 		= $array['examid'];
	$examname = $array['examname'];
	$professor	=	$array['professor'];
	
	$sendarray[] = array("username" => $username);
	
	
	
	
	
	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
 
	$identification = "s{$studentid}_{$studentlastname}";
	$queue = "SELECT * FROM $identification WHERE ID='$examid'";
	
	$result = mysqli_query($connection,$queue);
	$row	= mysqli_fetch_assoc($result);
	
	$grade = $row['grade'];
	
	$sendarray[] = array("examid" => $examid, "examname" => $examname, "professor" => $professor, "grade" => $grade);
	
	
	
	$identification2 = "sub{$examid}_{$examname}_{$studentlastname}_{$professor}";
	
 
   #echo $identification2;
	$queue = "SELECT * FROM $identification2";
	
	$result = mysqli_query($connection,$queue);
	if($result){
	while($row=mysqli_fetch_assoc($result)){
		
		$questionid	= $row['ID'];
		$question 		= $row['question'];
		$caseshit		= $row['caseshit'];
		$casesmissed= $row['casesmissed'];
    $pointsgot  =$row['pointsgot'];
    $pointstotal=$row['pointstotal'];
		$submitted	= $row['submitted'];
    $feedback   = $row['feedback'];
		
		$sendarray[] = array("questionid" => $questionid, "question" => $question, "caseshit" => $caseshit,"pointsgot"=>$pointsgot,"pointstotal"=>$pointstotal, "casesmissed" => $casesmissed, "submitted" => $submitted,"feedback"=>$feedback);
	}
	}
 else{
   $sendarray[]=array("response"=>"Never submitted");
 }
	echo json_encode($sendarray,true);
	
	
	mysqli_close($connection);
	
?>