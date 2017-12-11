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
	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");    
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
	#$array[1] = array("studentusername"=>"mmd38");
	
 
 
	$arraysize= count($array);

	
	$username=$array[1]['studentusername'];

	$transarray=array("username"=>$username);
	extract($transarray);
	require 'getstudentlastname.php';
	
	
	$identification = "s{$studentid}_{$studentlastname}";
	
	$queue="SELECT * FROM $identification";
	
	$result=mysqli_query($connection,$queue);
	
	$rows = mysqli_num_rows($result);
	$array2[]=array("studentusername"=>$username);
	if($rows!=0){
		while($row=mysqli_fetch_assoc($result))
		{
			$examid		=$row['ID'];
			$examname	=$row['examname'];
			$professor	=$row['professor'];
			$submitstatus=$row['submitted'];
		
			$array2[]=array("examid" => $examid, "examname" => $examname, "professor" =>$professor,"submitted"=>$submitstatus);
		
		
		}
	}
	else{
		$array2[] = array("response" => "none");
	}
	
	
	
	echo json_encode($array2,true);
	
	
	mysqli_close($connection);
	
	    
?>
