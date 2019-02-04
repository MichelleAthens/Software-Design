<?php
/*CREATE A EXAM CUSTOM QUESTIONS
ONLY USE THIS SCRIPT FOR CREATE EXAM CUSTOM
===================================================================================

e1_final_ryan
+------+----------------------+------------------+-----------------+
| ID    | question              | cases              | answers        |
+------+----------------------+------------------+-----------------+
|    1   | Make a function   | cases|cases   | this answer   |
|    2   | Make a function2 | cases|cases2 | this answer2 |
+------+----------------------+------------------+-----------------+                  


t1_ryan      
+------+--------------+---------------+------------+
| ID    | examname | releasable  | students |
+------+--------------+---------------+------------+
|    1   | Final           | yes             | |1|2|       |
+------+---------------+--------------+------------+                          


premade
+----+------------+--------+------------+-------------+
| ID  | question | cases | difficulty  | createdby |
+----+------------+--------+------------+-------------+
|  1  | sample    | x+y    | easy        | ryan         |
+----+------------+--------+------------+-------------+
===================================================================================
INPUT NEED USERNAME IN ARRAY INDEX 0 0
SELECT EXAMS AFTER 0 0
ARRAY |  0  |  1  |  2  |
//$array[] = array("username"=>"prof1","examid" => "1", "examname" => "Final");
//$array[] = array("question" => "Make a function","answer"=>"this answer","cases"=>"cases|cases");
//$array[] = array("question" => "Make a function2","answer"=>"this answer2","cases"=>"cases|cases2");
===================================================================================

	
*/
	$array = array();
    $lastname="";
    $points=1;
	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	#$connection = mysqli_connect("localhost","root","password","mmd38");      
    
    $response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response

/*
$array[] = array("username"=>"prof1", "examname" => "test");
$array[] = array("questionid" => 1,"points"=>20);

/*
$array = array("username" => "prof1", "name" => "final", "questions" => "1,2");

*/

		
	$arraysize= count($array);

	$stringdata=$array['0']['username'];
			
	$transarray=array("username"=>$stringdata);
	extract($transarray);
	require 'getteacherlastname.php';
	$examname=$array['0']['examname'];
			
		
	$result = mysqli_query($connection,"SELECT max(ID) FROM t{$id}_{$lastname}");
	$row= mysqli_fetch_assoc($result);
	
    #How many exams did the professor already make	
	$idmax=$row['max(ID)'];
	
	require 'getlistofstudents.php';
			
			
	if(!$idmax){ //No previous exams start with 1
			
//===========CREATE ENTRY IN TEACHER's TABLE======================================
			$idmax=1;
			$identification1="t{$id}_{$lastname}";
			
			$queue = "INSERT INTO $identification1 (ID,examname,releasable,students) VALUES
			('1','$examname','yes','$string')";
			$result = mysqli_query($connection,$queue);
			
			require 'sendexam.php';
			
//==============CREATE EXAM TABLE 1============================================
			$identification = "e1_{$examname}_{$lastname}";
			
			$queue = "CREATE TABLE $identification(
			ID INT(50),
			question VARCHAR(250),
			cases VARCHAR(600),
			points INT(50))";
			
			$result = mysqli_query($connection,$queue);
			
			$arraysize= count($array);
			
			
//================INSERT QUESTIONS============================================
			for($i = 1; $i<$arraysize; $i++){ //For every question
			
				$questionid = $array[$i]['questionid'];
				$points     = $array[$i]['points'];
        
				//Retrieve questions from premade table
				$queue = "SELECT * FROM premade WHERE id='$questionid'";
				$result = mysqli_query($connection,$queue);
				
				$row = mysqli_fetch_assoc($result);
				$question = $row['question'];
				$cases = $row['cases'];
        
				
				
				$queue ="INSERT INTO $identification (ID, question, cases,points) VALUES
				('$questionid','$question','$cases','$points')";
				
				
				$result = mysqli_query($connection,$queue);
			}
		}
		
//==========================================================================
//==========================================================================
//==========================================================================
//==========================================================================
//==========================================================================
		else{#Professor already made an exam before
		
			$idmax=$idmax+1;
//===========CREATE ENTRY IN TEACHER's TABLE======================================
			$identification1="t{$id}_{$lastname}";
			$queue = "INSERT INTO $identification1 (ID,examname,releasable,students) VALUES
			('$idmax','$examname','yes','$string')";
			$result = mysqli_query($connection,$queue);
			
											#e1_final_ryan
			$identification = "e{$idmax}_{$examname}_{$lastname}";
			require 'sendexam.php';
//==============CREATE EXAM TABLE 1============================================
			$queue = "CREATE TABLE $identification(
			ID INT(50),
			question VARCHAR(250),
			cases VARCHAR(600),
			points INT(50)
			)";
			
			$result = mysqli_query($connection,$queue);
			#echo $queue;
			#echo mysqli_error($connection);
			
			$arraysize= count($array);
//================INSERT QUESTIONS============================================
			for($i = 1; $i<$arraysize; $i++){ //For every question
			
				$questionid = $array[$i]['questionid'];
				$points     = $array[$i]['points'];
        
				//Retrieve questions from premade table
				$queue = "SELECT * FROM premade WHERE id='$questionid'";
				$result = mysqli_query($connection,$queue);
				
				$row = mysqli_fetch_assoc($result);
				$question = $row['question'];
				$cases = $row['cases'];
				
				
				$queue ="INSERT INTO $identification (ID, question, cases, points) VALUES
				('$questionid','$question','$cases','$points')";
				

				$result = mysqli_query($connection,$queue);
				
				
			}
		}

		
	$response = array("response"=>"created");
	echo json_encode($response,true);
	
	    
?>
