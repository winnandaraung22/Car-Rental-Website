<?php
	session_start();
	unset($_SESSION['adminname']);
	session_destroy();
	header("Location: index.php");
?>