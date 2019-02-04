<?php
/*Take exam
===================================================================================

*/
#==============================================================================
	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
    #$connection = mysqli_connect("localhost","root","password", "mmd38");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
/*
   $array[]=array("username"=>"mmd38");
   $array[]=array("examid"=>1,"examname"=>"easy","professor"=>"ryan");
	*/
	$arraysize= count($array);

	
#========================Exam Select Retrieve exam======================
									#e1_final_ryan
	$username	= $array[0]['username'];
	$examid 		= $array[1]['examid'];
	$examname = $array[1]['examname'];
	$professor	= $array[1]['professor'];
	
	$sendarray[] = array("username" => $username);
	$sendarray[] = array("examid" => $examid, "examname" => $examname, "professor" => $professor);
	
	$identification = "e{$examid}_{$examname}_{$professor}";
	
	$queue = "SELECT * FROM $identification";
	$result = mysqli_query($connection,$queue);
	
	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$question    = $row['question'];
    $points      = $row['points'];
	
		
		$sendarray[] = array("questionid" => $questionid, 
										   "question"    => $question,
                       "points"      => $points);
		
		
		}
		
		$finalarray = json_encode($sendarray);
		
		echo $finalarray;
	
	
	
	    
?>
