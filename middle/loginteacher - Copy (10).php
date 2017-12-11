<?php
	include "path.php";
?>

<?php
	$response = file_get_contents('php://input');
	$array = json_decode($response,true);
	
	$url = "{$path}loginteacher.php";
	
	
	
	$data_string = json_encode($array,true);
	$path = $GLOBALS['back'];
	 $curl = curl_init();
	 $url="http://localhost:8080/php/grade/casing.php";

	curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $data_string
	));
  $resp = curl_exec($curl);
  #$response = json_decode($resp);
	
	
   curl_close($curl);

   echo $resp;
?>