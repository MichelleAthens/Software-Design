<?php
/*Get available exams
===================================================================================


INPUT NEED USERNAME IN ARRAY INDEX 0 0
SELECT EXAMS AFTER 0 0
ARRAY |  0  |  1  |  2  |
|  0  | "username" => "prof1"
|  1  | "question" => "sample", "cases"=>"x+y|var","difficulty"=>"easy","createdby"=>"default"
|  2  | "question" => "sample", "cases"=>"x+y|var","difficulty"=>"easy","createdby"=>"default"
===================================================================================	
*/
#==============================================================================
	$array = array();
	#$connection = mysqli_connect("localhost","root","password","mmd38");        
	$connection = mysqli_connect("sql2.njit.edu","mmd38","pass","mmd38");    
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
	//$array = array("username"=>"mmd38");
	
 
 
	$arraysize= count($array);

	
	$username=$array['username'];
	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
	
	$identification = "s{$studentid}_{$studentlastname}";
	
	$queue="SELECT * FROM $identification WHERE submitted='no' AND available='no' ";
	
	$result=mysqli_query($connection,$queue);
	
	$rows = mysqli_num_rows($result);
	
	if($rows!=0){
		$array2[] = array("response" => "yes");
		while($row=mysqli_fetch_assoc($result))
		{
			$examid		=$row['ID'];
			$examname	=$row['examname'];
			$professor	=$row['professor'];
		
			$array2[]=array("examid" => $examid, "examname" => $examname, "professor" =>$professor);
		
		
		}
	}
	else{
		$array2[] = array("response" => "none");
	}
	
	
	
	echo json_encode($array2);
	
	
	mysqli_close($connection);
	
	    
?>
