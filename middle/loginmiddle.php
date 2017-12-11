<?php
	$response = file_get_contents('php://input');
	$data = json_decode($response,true);
	

$data_string = json_encode($data,true);
   
  $curl = curl_init();

//========================================================
$url = "https://web.njit.edu/~mmd38/CS490/rc/Back/login/loginstudent.php";
#$url = "localhost:8080/php/FINAL/login/loginstudent.php";

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $data_string
  ));
  $resp = curl_exec($curl);
  $array = json_decode($resp,true);
//========================================================

  #echo $resp;
  $studentresponse = $array['Response'];





  $curl = curl_init();
 //======================================================== 
 $url = "https://web.njit.edu/~mmd38/CS490/rc/Back/login/loginteacher.php";
#$url = "localhost:8080/php/FINAL/login/loginteacher.php"; 
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $data_string
  ));
  $resp = curl_exec($curl);
  $array = json_decode($resp,true);
//========================================================  
  
     
  $teacherresponse = $array['Response'];
   
   
   

if($studentresponse=="MATCH"){
  $array = array();
  
  $array = array("login" => "student");
  
  echo json_encode($array);

}
else if($teacherresponse=="MATCH"){
  $array = array();
  
  $array = array("login" => "teacher");
  
  echo json_encode($array);
}
else{
  $array = array();
  
  $array = array("login" => "failed");
  
  echo json_encode($array);
}

   


   #echo $resp;
?>