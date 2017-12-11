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
	$connection = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");    
      #$connection = mysqli_connect("localhost", "root" ,"password","mmd38");                                                                                
/*    if (!mysql_select_db('usernames',$connection)){
      echo "\nCould not Select Database";
      }
    if($connection == false){
      echo "\nBad Connection";
      }*/
#===================================================================================  
      
    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);                       #Get the response
    
    
    $username = $decoder['Username'];
    $password = $decoder['Password'];

	#$username = "mmd38";
	#$password = "123";
    
    $result = mysqli_query($connection,"SELECT * FROM teachers WHERE username like '$username'");
    
    if(!$result){
      echo "\nNOT VALID QUERY";
    }
    
    $row = mysqli_fetch_assoc($result);   
    $match = mysqli_num_rows($result);
    
    
    if ($match != 0){ 
        #If there is a row that means theres a match
        #Save the information $information = mysqli_fetch_assoc($result); #Get the result
      
        $name       = $row['username'];
        $pass       = $row['password'];  
        $firstname  = $row['firstname'];
        $lastname   = $row['lastname'];
        
        if(password_verify($password,$pass)){
            $array = array("Response"=>"MATCH", "firstname" => $firstname, "lastname" => $lastname);

			
            echo json_encode($array,true);
        }
        else{
        $log = array("Response"=>"NO MATCH");
        
        echo json_encode($log,true);                                     #Echo the response
        }  
        
    }
    else{
        $log = array("Response"=>"NO MATCH");
        
        echo json_encode($log,true);                                     #Echo the response
    }
    
    mysqli_close($connection);                                                   #Close the database
    



?>
