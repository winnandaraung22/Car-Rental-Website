<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login</title>
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
        	<div class="userlogin-box">
            	<h2>User Login</h2>
            	
            	<!-- User Login Form -->
            		<form action="userlogin.php" method="POST" onsubmit="return validateform()">
            			<label> Username </label>
                		<input type="text" name="txtUsername" placeholder="Username" id="txtUsername">

                		<label> Email </label>
                		<input type="Email" name="txtEmail" placeholder="Email" id="txtEmail">

                		<label> Password </label>
                		<input type="password" name="txtPsw" placeholder="Password" required>

                		<button type="submit" name="btnLogin">Login</button>
                		<p> If you don't have account, <p>
                		<a href="register.php">Create Account</a> 
            		</form>
        	</div>
    	</div>
	</section>

	<script type="text/javascript">
		function validateform() {
			// null value
			var name = document.getElementById("txtUsername")
			var mail = document.getElementById("txtEmail")
			if(name.value == "")
			{
				alert("Fill the username!")
				return false
			}
			if(mail.value == "")
			{
				alert("Fill the email!")
				return false
			}
		}
	</script>

	<?php
		//check whether clicked the button on the form
		if(isset($_POST['btnLogin']))
		{
			//Connect to database
			$connection = connect();

			//Accept user inputs
			$username = $_POST['txtUsername'];
			$mail = $_POST['txtEmail'];
			$psw = $_POST['txtPsw'];

			//select query
			$sql = "select * from register where cusname=? and email=? and cuspsw=?";
			$stmt = $connection->prepare($sql);

			//bind parameter
			$stmt->bind_param("sss", $username, $mail, $psw);

			//Execute
			$stmt->execute();

			//Get the result set
			$result = $stmt->get_result();

			//validate whether Admin ID and Password are equal
			if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();

    			$_SESSION['userid'] = $row['id'];        
    			$_SESSION['username'] = $row['cusname']; 
				echo "<script>
					alert('Login Successful');
					window.location = 'carinfo_afterlogin.php'</script>";
				//$_SESSION['username'] = $username;
			}
			else
			{
				echo "<script type = 'text/javascript'>
					alert('Login Failed! Please Try Again');
				</script>" . $stmt->error;
			}

			$stmt->close();
			$connection->close();
		}
	?>
</body>
</html>