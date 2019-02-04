<?php

	$connection = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	#$connection = mysqli_connect("localhost","root","password","mmd38");      	
	$queue = "SELECT * FROM students";
	$result = mysqli_query($connection,$queue);
	$string="|";
	$numofrows = mysqli_num_rows($result);

	for($i=1;$i<=$numofrows;$i++){
		
		$number = (string)$i;
	$string = "{$string}{$number}|";
	}	    
?>
