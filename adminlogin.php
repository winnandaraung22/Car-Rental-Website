<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="logo"> 
			CityDrive Rentals 
		</div>
		<nav>
			<a href="index.php">Home</a>
			<a href="carinfo.php">Cars</a>
			<a href="register.php">Register</a>

			<div class="dropdown">
        		<a href="#" class="dropbtn 
        		<?php 
        		//highlight the tab in the current page
        			 if(basename($_SERVER['PHP_SELF'])=='adminlogin.php' || 
           				basename($_SERVER['PHP_SELF'])=='userlogin.php') 
        			echo 'active';  
        		?>">
        			Login<span class="arrow">▼</span> </a>

        		<!-- Login navigation -->
        		<div class="dropdown-content">
            		<a href="adminlogin.php">Login as Admin</a>
            		<a href="userlogin.php">Login as User</a>
        		</div>
    		</div>
		</nav>
	</header>

	<section class="loginimg">
    	<div class="overlay">
        	<div class="login-box">
            	<h2>Admin Login</h2>
            	
            	<!-- Admin Login Form -->
            		<form action="" method="POST" onsubmit="return validate()">
                		<input type="text" name="txtAdminID" placeholder="Admin ID" id="txtAdminID">
                		<input type="text" name="txtAdminName" placeholder="Admin Name" id="txtAdminName">
                		<input type="password" name="txtPsw" placeholder="Password" id="txtPsw">

                		<button type="submit" name="btnLogin">Login</button>
            		</form>
        	</div>
    	</div>
	</section>

	<script type="text/javascript">
		function validate() {
			// null value
			var admid = document.getElementById("txtAdminID")
			var admname = document.getElementById("txtAdminName")
			var psw = document.getElementById("txtPsw")
			if(admid.value == "")
			{
				alert("Fill the Admin ID!")
				return false
			}
			if(admname.value == "")
			{
				alert("Fill the Admin Name!")
				return false
			}
			if(psw.value == "")
			{
				alert("Fill the password!")
				return false
			}
		}
	</script>

	<?php
		//whether clicked the button from the form
		if(isset($_POST['btnLogin']))
		{
			//Connect to database
			$connection = connect();

			//Accept user inputs
			$admid = $_POST['txtAdminID'];
			$admname = $_POST['txtAdminName'];
			$psw = $_POST['txtPsw'];

			//select query
			$sql = "select * from admin where admid=? and admname=? and admpsw=?";
			$stmt = $connection->prepare($sql);

			//bind parameter
			$stmt->bind_param("sss", $admid, $admname, $psw);

			//Execute
			$stmt->execute();

			//Get the result set
			$result = $stmt->get_result();

			//validate whether Admin ID and Password are equal
			if($result->num_rows > 0)
			{
				$_SESSION['adminname'] = $admname;	
				header("Location:carmanage.php");
			}
			else
			{
				echo "<script>
					alert('Invalid Login!');
				</script>" . $stmt->error;
			}

			$stmt->close();
			$connection->close();
		}
		
	?>

</body>
</html>