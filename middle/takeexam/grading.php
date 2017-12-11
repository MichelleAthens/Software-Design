<?php

//Test Cases
//Getting username,
//examid, examname, professor
//question id, question
//0 1 2 3 4 5 = 4
	//$connection = mysqli_connect("sql2.njit.edu","mmd38","password","mmd38");    
	$array1  = array();
 	#$middlepath = $GLOBALS['middle'];
	$finalarray = array();
	$sendarray = array();
	$questionsarray=array();
	$caseshit="";
	$casesmissed="";
	$questionid=0;
		//======================================================================
	#$connection = mysqli_connect("localhost","root","password","mmd38");    
	$response = file_get_contents('php://input');
    $array1   = json_decode($response,true);       
	//======================================================================
	
/*
	$array1 [] 	=array("username" => "mmd38");
	$array1 []	=array("examid" => 1, "examname" => "eval", "professor" => "ryan");
	$array1[]	=array("questionid" => 1, "code" => "def check(x,y):
		return x+y");
	$array1[]	=array("questionid" => 2, "code" => "def check(x,y):
		return x-y");
	/*$array1 []	=array("questionid" => 1, "code" => "def check(n):
  if n == 1:
    return \"A\"
  elif n == 2:
    return \"B\"
  elif n == 3:
    return \"C\"
  else:
    return 'none'
	");
	
	$array1 []	=array("questionid" => 2, "code" => "def check(n):
  if n == 1:
    return \"A\"
  elif n == 2:
    return \"B\"
  elif n == 3:
    return \"C\"
  else:
    return 'none'
	");
	
	/*$array1 []	=array("questionid" => 1, "code" => "def addition(x,y):
	sum = x+y
	return (sum)");
	*/

	
	
	$username 	= $array1 [0]['username'];
	$examid		= $array1 [1]['examid'];
	$examname	=$array1 [1]['examname'];
	$professor	=$array1 [1]['professor'];
	
	//======================================================================
	//======================================================================
	#$username="mmd38";
	#$examid=1;
	#$examname="Final";
	#$professor="ryan";
	
	$sendingarray = array("username" => $username, "examid" => $examid, "examname" => $examname, "professor" => $professor);
	

	$sendingarray=json_encode($sendingarray,true);
	#echo "sending $sendingarray";
	
	
	
//=======================cases in format INPUT 5|SOLUTION 10|FIND x|COUNT ELIF WANT 3|
	$ch=curl_init();
	
		 $req = "https://web.njit.edu/~mmd38/CS490/rc/Back/takeexam/get_cases.php";

    curl_setopt_array($ch, array(
    CURLOPT_URL => $req,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $sendingarray
  ));  
  	$resp = curl_exec($ch);
 //=====================================================================
 # echo "RESPONSE \n $resp";
	
  $sendarray = json_decode($resp,true);
	$casearray=$sendarray;

  curl_close($ch);
//=====================================================================

	
$arraysize = count($array1);
$points=0;
$inputpoints=0;
$input="";
$totalsize=0;
$totalscore = 0;
//|0|1|2
//|0|1|2|3|



//|0|1|2|3|4|5
//|0|1|2|3
$totalpoints=0;
for($count=2;$count<$arraysize;$count++) 	#For each case in the array
{
  $pointsgot=0;
	global $casesmissed;
	$casesmissed="";
	global $caseshit;
	$caseshit	="";

	global $questionid;
	$questionid		= $sendarray[$count-2]['questionid'];
	$case 					= $sendarray[$count-2]['cases'];
  $amount         = $sendarray[$count-2]['points'];
	$code 					= $array1[$count]['code'];
	$question				= $sendarray[$count-2]['question'];
	
	$totalpoints=$totalpoints+$amount;
 #  echo"Question id $question";

	$casearray = explode("|",$case);

	$size = sizeof($casearray); //2

	global $totalsize;

	//$result = shell_exec("python g.py 2>&1");
	
	#====================================================Testing
#=========================================================
#

		for ($i=0; $i<$size;$i++) 					#FOR EVERY IDENTIFING CASE
		{

			$data = $casearray[$i]; 						#Line of a case
			$data = trim($data);
			

			
			$pieces = explode(" ", $data);
			$id = $pieces[0]; 								//Get the id type
			#echo "<br> I IS $i <br>";
			switch($id){
			#=========================================================	
				case "INPUT":
					$input ="";
					$inputpoints=0;
					$input = "$pieces[1]";
					$inputpoints++;
					
					#echo "<br>INPUT IS $input<br>";
					$i++;
					$nextdata = $casearray[$i];
					$nextdata = trim($nextdata);
					
					$pieces = explode(" ", $nextdata);
					$datasol = $pieces[1];
					#$test = $pieces[2];
			
					
					solution($code,$input,$datasol);
					break;
				#=========================================================			
				case "COUNT":
					$dataline = $casearray[$i];
					$datarray= explode(" ", $dataline);

			
					$pos=1;
					
					$data=$datarray[$pos];
					
					while(!$data){
						$pos++;
						$data=$datarray[$pos];
					}
					
					$wanted=$data;
					
					$pos++;
					
					$dataid=$datarray[$pos];
					
					if($dataid=="WANT"){
						$pos++;
						
						$data=$datarray[$pos];
						
						while(!$data){
							$pos++;
							$data=$datarray[$pos];
						}
						
						$counting = $datarray[$pos];
						
						counting($wanted,$counting);
					}
					break;
				#=========================================================	
				case "FIND":
					
          
          $search = $pieces[1];
				
				if (strpos($code,$search)!==false){
					$points++;
					
					$score = $amount/$size;
					$score = number_format((float)($score),2,'.','');
					
					$pointsgot = $pointsgot + $score;
				    $caseshit = "$caseshit|FOUND $search 	(+$score)";	
				}
        else{
			
					$score = $amount/$size;
					$score = number_format((float)($score),2,'.','');
					
				
					$casesmissed = "$casesmissed|COULD NOT FIND $search  	(-$score)";
        }

			break;
          /*	$search = $pieces[1];
						echo "Searching for $search";
						$bodycode = preg_replace('/^.+\n/', '',$code);//Skip the first line 
						
						
						$wordCounts = array_count_values(str_word_count($bodycode,1));
						$codecount = (isset($wordCounts[$search])) ? $wordCounts[$search] : 0;
				
        
            echo "Count is $codecount";
						if($codecount>=1){
							#echo "<br>FOUND <br>";
							$caseshit = "$caseshit|<br>FOUND $search";
							$points++;
						}
						else{
							$casesmissed = "$casesmissed|<br>COULD NOT FIND $search";
							#echo "<br>NOT FOUND";
						}
						/*if (strpos($code,$search)){
							$points++;
							
						}*/

				#=========================================================
				case "FUNCTION-NAME":
					$functionname = $pieces[1];
					
					$lines=explode("\n",$code);
					$firstline = $lines[0];//Get only the first line
					
             
          #$search = $pieces[1];
				
  				if (strpos($firstline,$functionname)!==false){
  					$points++;
					
					$score = $amount/$size;
					$score = number_format((float)($score),2,'.','');
					
					$pointsgot = $pointsgot + $score;
  				    $caseshit = "$caseshit|FOUND $functionname 	(+$score)";	
  				}
          else{
          
					$score = $amount/$size;
					$score = number_format((float)($score),2,'.','');
					
  					$casesmissed = "$casesmissed|COULD NOT FIND $functionname 	(-$score)";
          }
                     
					/*$wordCounts = array_count_values(str_word_count($firstline,1));
					$codecount = (isset($wordCounts[$functionname])) ? $wordCounts[$functionname] : 0;
					
					if($codecount==1){
						$caseshit = "$caseshit|FOUND DESIRED FUNCTION NAME $functionname";
						$points++;
					}
					else{
						$casesmissed="$casesmissed|MISMATCHED FUNCTION NAME WANTED $functionname";
					}
				break;*/
			    break;
          
          }
	


		}
	$caseshit = trim($caseshit,"|");
	$casesmissed = trim($casesmissed,"|");
	
	$totalscore = $totalscore + $pointsgot;
	$questionsarray[] = array("questionid" => $questionid, "question" => $question,"caseshit" => $caseshit, "casesmissed" => $casesmissed,"pointsgot"=>$pointsgot,"pointstotal"=>$amount, "submitted" => $code);

}
	#echo "TOTAL POINTS $points";
	#echo "TOTAL SIZE $totalsize ";
	$calculatescore = ($totalscore/$totalpoints)*100;
	
	$calculatescore = number_format((float)($calculatescore),2,'.','');
	//echo "FINAL SCORE IS $calculatescore";
	$finalarray[]=array("username"=>$username);
	$finalarray[] = array("examid"=>$examid, "examname" => $examname, "professor" => $professor, "grade" => $calculatescore);
	
	#echo $calculatescore;
	$final = array_merge($finalarray,$questionsarray);
	
	#echo "";
	$test=json_encode($final);
	
	//echo "TESTING $test";
	
	
	//echo "<br>$caseshit<br>";
	//echo "<br>$casesmissed<br>";
	
#======================================================	
#======================================================	

   	$ch=curl_init();
	
		 $req = "https://web.njit.edu/~mmd38/CS490/rc/Back/takeexam/submit_exam.php";
		 #$req = "localhost:8080/php/FINAL/takeexam/submit_exam.php";
#======================================================	
 	 //  $url = "{$path}loginteacher.php";
    curl_setopt_array($ch, array(
    CURLOPT_URL => $req,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => json_encode($final,true)
  ));  
  	$resp = curl_exec($ch);
#======================================================	
#======================================================	  
	  echo $resp;
//*/
#======================================================	
#======================================================
#======================================================	
#======================================================
#======================================================	
#======================================================
#======================================================	
#======================================================
function makepyfile($code,$params){ //Write the code to file
	global $casesmissed;
	global $input;
	$funccall="";

	$tok = strtok($code," \n\t"); //Get the first token should be def

		if($tok=="def"){
		$tok=strtok(" \n\t");
		
		$line = $tok;
		$func=explode("(",$line);
		
		//Pull out the function in order to make a call
		$funccall = $func[0];
	}
  
 
  $infile="grade.py";
	file_put_contents("grade.py", "");
  $file = fopen($infile,"w");		#Make a file
	
 
	$header = ""; 
	#"#!/Users/Michelle/AppData/Local/Programs/Python/Python36-32/python.exe";
	$need = "print(\"content-type: text/html\\n\\n\")";
	$output = "\nprint (solution)";
	
	#fwrite($file,$header . "\n");
	fwrite($file,$code."\n");

	if(!fwrite($file,"\n\nsolution = {$funccall}({$input})\n",200)){
   echo"Unable to write";
	}
	
	#fwrite($file,$need);
	
	fwrite($file,$output);
	fclose($file);
	$input="";
	
	$result = exec("python grade.py 2>&1",$output,$return) ;
	
	
	if (!$return){
	}
	else{
		
		
	}
	return $result;
}

#======================================================
function solution($code,$input,$datasol){
	global $points;
	global $inputpoints;
	global $caseshit;
	global $casesmissed;
	global $amount;
	global $pointsgot;
	global $size;
	
	$studentresult = makepyfile($code,$input);
	
	$studentresult=(string)$studentresult;
	$datasol = (string)$datasol;
  #echo "Input is $input";
	#echo "STUDENT $studentresult<br>";
	#echo "WANT $datasol<br>";
	if ($studentresult===$datasol){ #Must convert
		

		$points = $points + $inputpoints +1;
		
		
		$score = $amount/$size;
		$score = number_format((float)($score),2,'.','');
		$score = $score*2;
		
		$pointsgot = $pointsgot + $score;
		$caseshit="$caseshit|INPUTTING $input MATCHED SOLUTION $datasol 	(+$score)";
		
		$inputpoints=0;	
	
	}
	else{
		
		
		
		$score = $amount/$size;
		$score = number_format((float)($score),2,'.','');
		$score = $score*2;
		
		
		$casesmissed = "$casesmissed|INPUTTING $input GOT $studentresult NEEDED $datasol 	(-$score)";
		$inputpoints=0;
	}
}

#======================================================


#======================================================

function counting($want,$need) {
	global $points;
	global $code;
	global $casesmissed;
	global $caseshit;
	global $pointsgot;
	global $size;
	global $amount;
	
	$wantsize = strlen($want);
	$wordCounts = array_count_values(str_word_count($code,1));
	$codecount = (isset($wordCounts[$want])) ? $wordCounts[$want] : 0;
	
	
	if($wantsize==1){ //If looking for a char
		if(substr_count($code,$want)==$need){
			$points++;
		
		
		
		$score = $amount/$size;
		
		$score = number_format((float)($score),2,'.','');
		$pointsgot = $pointsgot + $score;
		$caseshit = "$caseshit|COUNTING $want NEEDED $need 	(+$score)";
		}
		else{
			
			$codecount = substr_count($code,$want);
			$score = $amount/$size;
			$score = number_format((float)($score),2,'.','');
		
		$casesmissed = "$casesmissed|COUNTING $want FOUND $codecount NEED $need 	(-$score)";
		}
	
	}
	else if($codecount==$need){
		$points++;
		
		
		
		
		
		$score = $amount/$size;
		$score = number_format((float)($score),2,'.','');
		$pointsgot = $pointsgot + $score;
		$caseshit = "$caseshit|COUNTING $want NEEDED $need 	(+$score)";

	}
	else{
		
		
		$score = $amount/$size;
		$score = number_format((float)($score),2,'.','');
		
		$casesmissed = "$casesmissed|COUNTING $want FOUND $codecount NEED $need 	(-$score)";
	}
}
#======================================================

#======================================================
#*/
?>