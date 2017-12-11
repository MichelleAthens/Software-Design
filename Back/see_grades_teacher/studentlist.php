<?php
	$array = array();
	#$connection = mysqli_connect("localhost","root","password","mmd38");        
	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");    
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
	//$array = array("username"=>"mmd38");
	
 
	$sendarray=array();
	$queue = "SELECT * FROM students";
	$result =  mysqli_query($connection,$queue);
	
	while($row=mysqli_fetch_assoc($result)){
		$studentid = $row['id'];
		$studentlastname=$row['lastname'];
		$studentfirstname=$row['firstname'];
		$studentusername=$row['username'];
		
		$sendarray[]=array("username" => $studentusername,"studentid" => $studentid, "studentfirstname" => $studentfirstname,"studentlastname" => $studentlastname);
	}
	
	echo json_encode($sendarray,true);
	mysqli_close($connection);
	
	    
?>
