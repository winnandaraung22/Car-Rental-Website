<?php
	function connect()
	{
		$host = "localhost";
		$username = "root";
		$password = "admin";
		$dbname = "citydrive";

		$conn = mysqli_connect($host, $username, $password, $dbname);

		if(mysqli_connect_error())
		{
			echo "Failed to connect database!";
			exit();
		}
	return $conn;
	}
?>