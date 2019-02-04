<?php



	$con = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	#$con = mysqli_connect("localhost","root","password","mmd38");

	
	$result = mysqli_query($con,"SELECT * FROM students WHERE id like '$id'");
	$row = mysqli_fetch_assoc($result);
	
	$studentlastname = $row['lastname'];
	$studentlastname = strtolower($studentlastname);
	
	mysqli_close($con);
	
?>