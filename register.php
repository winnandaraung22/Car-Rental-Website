<?php
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registeration</title>
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
			<a href="register.php" class="active">Register</a>

			<div class="dropdown">
        		<a href="#" class="dropbtn">Login<span class="arrow">▼</span> </a>

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
        	<div class="register-box">
            	<h2>Registration Form</h2>
            	
            	<!-- Register Form -->
            		<form action="" method="POST" onsubmit="return validate()">
            			<label> Name </label>
                		<input type="text" name="txtName" placeholder="Your Name" required>

                		<label> Email </label>
                		<input type="Email" name="txtEmail" placeholder="Email" required id="txtEmail">

                		<label> Password </label>
                		<input type="password" name="txtPsw" placeholder="Password" required id="txtPsw">

                		<label> Re-type Password </label>
                		<input type="password" name="txtRePsw" placeholder="Re-type Password" required id="txtRePsw">

                		<label> Contact </label>
                		<input type="text" name="txtContact" placeholder="Your Phone Number" id="txtContact" required>

                		<label> Gender </label>
                		<select name="gender">
                			<option value="Male">Male</option>
                			<option value="Female">Female</option>
                		</select>

                		<button type="submit" name="btnRegister">Register</button>
            		</form>
        	</div>
    	</div>
	</section>

	<script type="text/javascript">
		function validate() 
		{
			//whether password and re-type password are equal
			//accept the data
			var psw = document.getElementById('txtPsw')
			var repsw = document.getElementById('txtRePsw')
			if(psw.value != repsw.value)
			{
				alert("Passwords are not same!")

				//clear input fields
				psw.value = ""
				repsw.value = ""

				return false
			}
			//whether phone number must be 11 digit
			var phone = document.getElementById('txtContact')
			if(phone.value.length != 11)
			{
				alert("Exceed the phone number! Must be 11 digit")

				//clear input fields
				phone.value = ""

				return false
			}
		}
	</script>

	<?php
		//whether clicked the button from the form
		if(isset($_POST['btnRegister']))
		{
			//Connect to database
			$connection = connect();

			//Accept user inputs
			$name = $_POST['txtName'];
			$mail = $_POST['txtEmail'];
			$psw = $_POST['txtPsw'];
			$contact = $_POST['txtContact'];
			$gender = $_POST['gender'];

			//Insert query with prepare statement
			$sql = "insert into register(cusname, email, cuspsw, cusphone, gender) values(?, ?, ?, ?, ?)";
			$stmt = $connection->prepare($sql);

			//bind parameter
			$stmt->bind_param("sssss", $name, $mail, $psw, $contact, $gender);

			//Execute
			if($stmt->execute())
			{
				//show alert and redirect
				echo "<script type = 'text/javascript'>
					alert('Registration Successful');
					window.location = 'userlogin.php';
				</script>";
			}
			else
			{
				echo "Error!" . $stmt->error;
			}

			$stmt->close();
			$connection->close();
		}
	?>
</body>
</html>