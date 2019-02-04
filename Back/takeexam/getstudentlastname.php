<?php


#Get student name by username
	$con = mysqli_connect("sql2.njit.edu","mmd38","passwrd","mmd38");
	#$con = mysqli_connect("localhost","root","password","mmd38");

	
	$result = mysqli_query($con,"SELECT * FROM students WHERE username like '$username'");
	$row = mysqli_fetch_assoc($result);
	
	$studentlastname = $row['lastname'];
	$studentid			  = $row['id'];
	$studentlastname = strtolower($studentlastname);
	
	mysqli_close($con);
	
?>