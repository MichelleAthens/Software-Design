<?php
/*Take exam
===================================================================================

*/
#==============================================================================
	$array = array();
	
	$questionid=1;
	$question   ="";
	$caseshit		="";
	$casesmissed ="";
	$submitted  ="";
	#$connection = mysqli_connect("localhost","root","password","mmd38");     
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
	//$array[] = array("examid" => "1", "examname" => "Final", "professor" => "ryan");
 
 
	/*
	$array[] = array("username" => "mmd38");
	$array[] = array("examid" => "1", "examname" => "easy", "professor" => "ryan", "grade" => "90");
	$array[] = array("questionid" => "1", 
								"question" => "question",
								"cases" => "cases",
								"answers" => "answers",
								"submitted" => "code",
								"caseshit"	=> "x+y",
								"casesmissed" => "x*y");
	$array[] = array("questionid" => "2", 
								"question" => "question",
								"cases" => "cases",
								"answers" => "answers",
								"submitted" => "code",
								"caseshit"	=> "x+y",
								"casesmissed" => "x*y");
								
								*/
	$arraysize= count($array);
	$finals=json_encode($array,true);
	
	
#========================Exam Select Retrieve exam======================
									#e1_final_ryan
	$username = $array[0]['username'];
	$examid	   = $array[1]['examid'];
	$examname= $array[1]['examname'];
	$examname = strtolower($examname);
	$professor  = $array[1]['professor'];
	$grade		   = $array[1]['grade'];
#=================================================================
#Make Table
	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
	$identification = "sub{$examid}_{$examname}_{$studentlastname}_{$professor}";
	
	
	$queue = "CREATE TABLE $identification (
	ID INTEGER(50),
	question VARCHAR(250),
	caseshit	 VARCHAR(250),
	casesmissed	 VARCHAR(250),
	pointsgot	INT(50),
	pointstotal INT(50),
	submitted VARCHAR(500),
	feedback VARCHAR(500))
	";

	$result = mysqli_query($connection,$queue);
#===================================================================
#Insert Questions

	for($i=2;$i<=$arraysize-1;$i++){
		
		$test=json_encode($array,true);
		#echo "<br><br>In For $test";
		
		$questionid=$array[$i]['questionid'];
		$question   =$array[$i]['question'];
		$caseshit		= $array[$i]['caseshit'];
		$casesmissed = $array[$i]['casesmissed'];
		$submitted  =$array[$i]['submitted'];
		$pointsgot  =$array[$i]['pointsgot'];
		$pointstotal  =$array[$i]['pointstotal'];

		
		$caseshit=str_replace("'"," ",$caseshit);
		$casesmissed=str_replace("'"," ",$casesmissed);
		$submitted=str_replace("'","\"",$submitted);

		
		$queue="INSERT INTO $identification(ID,question,caseshit,casesmissed,pointsgot,pointstotal,submitted,feedback) VALUES
		('$questionid','$question','$caseshit','$casesmissed','$pointsgot','$pointstotal','$submitted','')";
			
		$result = mysqli_query($connection,$queue);		
		

		}
#===================================================================
#Update data in student's database

	$identification2="s{$studentid}_{$studentlastname}";
	
	$queue="UPDATE $identification2 SET submitted='yes' WHERE ID='$examid'";
	$result = mysqli_query($connection,$queue);
	
	$queue ="UPDATE $identification2 SET grade='$grade' WHERE ID='$examid'";
	$result = mysqli_query($connection,$queue);
	
	$sendarray = array("response"=>"submitted");
	echo json_encode($sendarray);

	
?>
