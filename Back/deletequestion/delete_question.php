<?php
	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
 # $connection = mysqli_connect("localhost","root","password","mmd38");    	
  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);                       #Get the response
  
  #$array = array("questionid"=>2);
  
  echo json_encode($response,true);
	$questionid=$array['questionid'];
	
	
	$queue="SELECT * FROM premade WHERE id='$questionid'";
	$result=mysqli_query($connection,$queue);
	
	$row=mysqli_fetch_assoc($result);
	$question=$row['question'];
	
	$queue="SHOW TABLES";
	$result=mysqli_query($connection,$queue);
	
	
	while($table=mysqli_fetch_assoc($result)){//Delete the existence of the question in all tables
		
		$tablename=$table['Tables_in_mmd38'];
		#echo "$tablename <br>";
		$queue2="DELETE FROM $tablename WHERE question='$question'";
		$result2=mysqli_query($connection,$queue2);
		
		
	}
	
	
	#$queue="DELETE FROM premade WHERE id='$questionid'";
	#$result=mysqli_query($connection,$queue);
	


	   mysqli_close($connection);
	   
	   $array=array("response"=>"deleted");
	   
	   echo json_encode($array,true);
	 
?>
