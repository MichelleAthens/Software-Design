<?php
/*Get cases
===================================================================================

*/
#==============================================================================
	$array = array();
	$sendarray = array();
	global $sendarray;
	#$con = mysqli_connect("localhost","root","password","mmd38");        
	$con = mysqli_connect("sql2.njit.edu","mmd38","oXsWKSx7","mmd38");    
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
#$array = array("username"=>"prof1", "examid" => "1", "examname" => "Final", "professor" => "ryan");
	
 
	$lastname = $array['professor'];	
	$username=$array['username'];
	$examname=$array['examname'];
	$examid =	$array['examid'];
	

	
	$identification = "e{$examid}_{$examname}_{$lastname}";
	
	$queue="SELECT * FROM $identification";
	
	$result=mysqli_query($con,$queue);
	
	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$case			= $row['cases'];
		$question	= $row['question'];
    $points   = $row['points'];
		
		$case = cleancases($case);
		
		
		
		
		$sendarray[] = array("questionid" => $questionid,"question" => $question, "cases" => $case,"points"=>$points);
	}
	
	$sendarray = json_encode($sendarray,true);
	echo $sendarray;
	
	mysqli_close($con);

//======================================================================
//======================================================================
function cleancases($instring){
	$instring = $instring;
	
	
	$outstring = str_replace('\t',' ',$instring);
#	$outstring = preg_replace('/\?\s+/', '|', $instring);
	$outstring = preg_replace('/( )+/', ' ', $instring);
	
	$outstring = str_replace('\n','|',$outstring);
	

	if(endsWith($outstring,'|')){
		$outstring = rtrim($outstring,'|');
	}
	
	if(startsWith($outstring,'|')){
		$outstring = rtrim($outside,'|');
	}
	
	return $outstring;
}
//======================================================================
function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}
//======================================================================
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
	    
?>
