<?php
/*Sets releasable to no
Sets available to see to yes
===================================================================================
t1_ryan
		+--------------+-----------------+---------------------+--------------+
		|	examid		|	examname	|	releaseexam	|	students	|
		+--------------+-----------------+---------------------+--------------+
		|		1			|		Final			|			Yes			|	 1, 2,  3	|
		+--------------+-----------------+---------------------+--------------+
	                                                                                    
===================================================================================  
      

#Debuger==========================================================

	
Debuger==========================================================

===================================================================================
INPUT NEED USERNAME IN ARRAY INDEX 0 0
SELECT EXAMS AFTER 0 0
ARRAY |  0  |  1  |  2  |
|  0  | "username" => "prof1"
|  1  | "examid" => "1", "examname" => "Final";
|  2  | "examid" => "2", "examname" => "Midterm";
===================================================================================

	
*/	

	$array = array();
	
$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
#$connection = mysqli_connect("localhost","root","password","mmd38");    
  
  $response = file_get_contents('php://input');
  $array = json_decode($response,true);                       #Get the response
    
    /*
	$array[] = array("username"=>"prof1");
	$array[] = array("examid" => "2", "examname" => "Final");
	$array[] = array("examid" => "4", "examname" => "Midterm");
	*/
  $arraysize= count($array);
	$identification="";

	
	for($i = 0; $i<$arraysize; $i++){
		if ($i==0){
			//$data=
			$stringdata=$array['0']['username'];
			
			$transarray=array("username"=>$stringdata);
			extract($transarray);
			require 'getteacherlastname.php';

			$identification ="t{$id}_{$lastname}";
		}
		else{
			$examid=$array[$i]['examid'];
			$examname=$array[$i]['examname'];
			
      
      echo $examid;
			#No longer able to release this exam again
			$queue = "UPDATE $identification SET releasable='no' WHERE ID='$examid'";
			$result=mysqli_query($connection,$queue);
			
#==========================================================================
		
			$queue = "SELECT * FROM students";
			$result=mysqli_query($connection,$queue);
			
		#For every student on the list
			while($row = mysqli_fetch_assoc($result)){
				
				$studentlastname = $row['lastname'];
        $studentlastname = strtolower($studentlastname);
				$studentid=$row['id'];
			
					
#==========================================================================
													#s1_Dizon
				$identification1="s{$studentid}_{$studentlastname}";
				$queue1="UPDATE $identification1 SET available='yes' WHERE ID='$examid'";
				
				$result1 = mysqli_query($connection,$queue1);

				
				}
				
			
		}
	
	}
	
	$response=array("response"=>"updated");
	$message = json_encode($response,true);
	
	echo $message;

	
	

	
	
	
	    
?>
