<?php
/*CREATE A QUESTION
===================================================================================

+-------------+------------+------------------+------------+-----------+
| questionid| question | cases              | difficulty | createdby |
+-------------+------------+------------------+------------+-----------+
| 0               | example | x+y|var*char  | easy       | default   |
+-------------+------------+------------------+------------+-----------+                                                      
===================================================================================  
      

#Debuger==========================================================
	$array[] = array("username"=>"prof1");
	$array[] = array("examid" => "1", "examname" => "Final");
	$array[] = array("examid" => "2", "examname" => "Midterm");
Debuger==========================================================

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

	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");   
	#$connection=mysqli_connect("localhost","root","password","mmd38");
    $response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
#	$array= array("question" => "sample", "cases" => "case", "category" => "default","level"=>"easy");
 
 
//	$arraysize= count($array);


			
			/*$transarray=array("username"=>$stringdata);
			extract($transarray);
			require 'getteacherlastname.php';*/

			
			$question    = $array['question'];
			$cases		   = $array['cases'];
			$level  = $array['level'];
			$category = $array['category'];
			
			
			
			
			$result = mysqli_query($connection,"SELECT max(ID) FROM premade");
			$row= mysqli_fetch_assoc($result);
			
			
			$idmax=$row['max(ID)'];			
			$idmax=$idmax+1;
			
			$queue = "INSERT INTO premade (id, question,category, level, cases) VALUES
			('$idmax','$question','$category','$level','$cases')";
			
			$result = mysqli_query($connection,$queue);
			
			
				$response = array("response"=>"created");
				echo json_encode($response);
			
			
		
		
	
	
	    
?>
