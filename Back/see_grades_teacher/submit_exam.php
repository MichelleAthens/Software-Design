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
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
    #$connection = mysqli_connect("localhost","root","password", "mmd38");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
	//$array[] = array("examid" => "1", "examname" => "Final", "professor" => "ryan");
 
 /*
	
	$array[] = array("studentusername" => "mmd38","examid" => "1", "examname" => "eval", "professor" => "ryan");
	$array[] = array("questionid" => "1", 
							"feedback"=>"hiya","points"=>"12");
	$array[] = array("questionid" => "2", 
							"feedback"=>"test","points"=>"");
								
	//*/
	$arraysize= count($array);
	$finals=json_encode($array,true);
	
	
#========================Exam Select Retrieve exam======================
									#e1_final_ryan
	$username = $array[0]['studentusername'];
	$examid	   = $array[0]['examid'];
	$examname= $array[0]['examname'];
	$examname = strtolower($examname);
	$professor  = $array[0]['professor'];
	
#=================================================================
#Make Table
	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
	$identification = "sub{$examid}_{$examname}_{$studentlastname}_{$professor}";

#===================================================================
	
	$queue = "SELECT * FROM $identification";
	
	$result1 = mysqli_query($connection,$queue);
	$i=1;
	
#===================================================================
	while($row=mysqli_fetch_assoc($result1)){
		
		$questionid = $array[$i]['questionid'];
		$feedback = $array[$i]['feedback'];
		$newpoints = $array[$i]['points'];
		
		$i++;
		#===============If they updating the points=========================
		if($newpoints!=""){
				$newpoints = (int)$newpoints;
				$queue = "UPDATE $identification SET pointsgot='$newpoints' WHERE ID='$questionid'";
				$result = mysqli_query($connection,$queue);
		}
		
					
			
		$queue = "UPDATE $identification SET feedback='$feedback' WHERE ID='$questionid'";				
		$result = mysqli_query($connection,$queue);		
					
	}
#===================================================================		
#Update data in student's database
	$queue = "SELECT * FROM $identification";
	$result = mysqli_query($connection,$queue);
	
	$points=0;
	$total=0;
	
	while($row=mysqli_fetch_assoc($result)){
		$pointsgot = $row['pointsgot'];
		$totalamount	= $row['pointstotal'];
		
		$points = $points + $pointsgot;
		$total   = $total + $totalamount;
		
	}
	
	$newgrade = $points / $total;
	
	$score = number_format((float)($newgrade),2,'.','');
	$score = $score*100;
	$identification2="s{$studentid}_{$studentlastname}";
	
	echo $score;
	$queue ="UPDATE $identification2 SET grade='$score' WHERE ID='$examid'";
	$result = mysqli_query($connection,$queue);
		
	$sendarray = array("response"=>"submitted");
	echo json_encode($sendarray,true);
?>
