<?php 
	$conn = new mysqli("localhost","root", "123456", "nideanime");
	if ($conn->connect_Error) {
		echo $conn->connect_Error;
	}

?>