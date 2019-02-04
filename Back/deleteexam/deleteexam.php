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
    
   # $decoder=array("username"=>"prof1","examid"=>5);
    
	
	$username = $decoder['username'];
	$examid=$decoder['examid'];
	
	#$username="prof1";
	$data=['user'=>$username];
	extract($data);
	require 'getteacherlastname.php';

	
	
	
	$identification ="t{$id}_{$lastname}";
	
	#echo $identification;
	
	$queue="SELECT * FROM $identification WHERE ID=$examid";
	$result=mysqli_query($connection,$queue);
	
	$row=mysqli_fetch_assoc($result);
	$examname=$row['examname'];

	
	
	$queue="DELETE FROM $identification WHERE ID=$examid";
	$result = mysqli_query($connection,$queue);

	
	
	$identification1="e{$examid}_{$examname}_{$lastname}";
	
	
	
	$queue="DROP TABLE $identification1";
	$result = mysqli_query($connection,$queue);
	
	
	$queue="SELECT * FROM students";
	$result =mysqli_query($connection,$queue);
	
	while($row=mysqli_fetch_assoc($result)){
		$studentlastname=$row['lastname'];
		$studentid=			$row['id'];
		
		$identification2="s{$studentid}_{$studentlastname}";
		$queue2="DELETE FROM $identification2 WHERE ID='$examid' AND examname='$examname' AND professor='$lastname'";
		$result2=mysqli_query($connection,$queue2);
			
	
		
		$identification3="sub{$examid}_{$examname}_{$studentlastname}_{$lastname}";
		$queue3="DROP TABLE $identification3";

		
		
		$result3=mysqli_query($connection,$queue3);

	}
	#==================================================================================
	#==================================================================================
echo "Deleted";
mysqli_close($connection);
//*/
?>
