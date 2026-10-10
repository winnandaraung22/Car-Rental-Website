<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Car Management_Insert</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="dashboard">
	<!-- Header -->
	<header class="title1">
    	<div class="title2">CityDrive Rentals</div>

    	<div class="admin-info">
        	<img src="Images/person.jpg" class="admin-img">
        	<span> 
        		<?php 
        		//if admin is logged in, dashboard access. if not, redirect admin login
        			if(isset($_SESSION['adminname']))
        			{
        			echo $_SESSION['adminname']; 
        			}
        			else
        			{
        				header("Location: adminlogin.php");
        				exit();
        			}
        		?> 
        	</span>
    	</div>
	</header>

	<!-- Sidebar + Content -->
	<div class="container">

    	<!-- Sidebar -->
    	<div class="sidebar">
        	<h3>Dashboard</h3>

        	<a href="carmanage.php" class="active">🚗 Cars Management</a>
        	<a href="bookingRequest.php">📅 Booking Management</a>
        	<a href="cusManage.php">👤 Customer Information</a>
			<a href="logout.php">🚪 Logout</a>	
    	</div>

    	<!-- Right Side -->
    	<div class="right-content">

    		<!-- Main Content -->
    		<div class="main-content">
        		<h2>Welcome to Admin Dashboard</h2>
        		<p>🙋Hello <?php echo $_SESSION['adminname']; ?> </p>
        	</div>

        	<div class="car-section">
        		<div class="form-container">
    				<form action="" method="POST" enctype="multipart/form-data" onsubmit="return validate()">

    				<table class="form-table">
    					<h2>Add New Car</h2>

        			<!-- Row 1 -->
        			<tr>
            			<td>
                			<label>Car Name</label><br>
                			<input type="text" name="txtCarname" id="txtCarname">
            			</td>

            			<td>
                			<label>Type</label><br>
                			<input type="text" name="txtType" id="txtType">
            			</td>
        			</tr>

        			<!-- Row 2 -->
        			<tr>
            			<td>
                			<label>Model</label><br>
                			<input type="text" name="txtModel" id="txtModel">
            			</td>

            			<td>
                			<label>Seats</label><br>
                			<input type="number" name="txtSeats" id="txtSeats">
            			</td>
        			</tr>

        			<!-- Row 3 -->
        			<tr>
            			<td>
                			<label>Fuel Type</label><br>
                			<input type="text" name="txtFuel" id="txtFuel">
            			</td>

            			<td>
                			<label>Transmission</label><br>
                			<input type="text" name="txtTransmission" id="txtTransmission">
            			</td>
        			</tr>

        			<!-- Row 4 -->
        			<tr>
            			<td>
                			<label>Engine Power</label><br>
                			<input type="text" name="txtEngine" id="txtEngine">
            			</td>

            			<td>
                			<label>Price Per Day</label><br>
                			<input type="number" name="txtPrice" id="txtPrice">
            			</td>
        			</tr>

        			<!-- File Upload -->
        			<tr>
            			<td colspan="2">
                			<label>Car Image</label><br>
                			<input type="file" name="image">
            			</td>
        			</tr>

        			<!-- Button -->
        			<tr>
            			<td colspan="2" class="form-btn-right">
                			<input type="submit" name="txtInsert" value="Insert Car" class="btninsert">
            			</td>
        			</tr>
        			<tr>
        				<td>
        					<a href="carmanage.php" class="btn">Back</a>
        				</td>
        			</tr>
    				</table>
					</form>
				</div>	
    		</div>
		</div>

		<!--Validate the form -->
		<script type="text/javascript">
			function validate()
			{
				//null value
				var cname = document.getElementById("txtCarname").value
				var ctype = document.getElementById("txtType").value
				var cmodel = document.getElementById("txtModel").value
				var seat = document.getElementById("txtSeats").value
				var fuel = document.getElementById("txtFuel").value
				var transmission = document.getElementById("txtTransmission").value
				var engine = document.getElementById("txtEngine").value
				var price = document.getElementById("txtPrice").value
				if(cname == "" || ctype == "" || cmodel == "" || seat == "" || fuel == "" || transmission == "" || engine == "" || price == "")
				{
    				alert("Fill all the textbox!");
    				return false;
				}
			}
		</script>

		<?php
			if(isset($_POST['txtInsert']))
			{
				//Connect to database
				$connection = connect();

				//accept input
				$cname = $_POST['txtCarname'];
				$ctype = $_POST['txtType'];
				$cmodel = $_POST['txtModel'];
				$seat = $_POST['txtSeats'];
				$fuel = $_POST['txtFuel'];
				$transmission = $_POST['txtTransmission'];
				$engine = $_POST['txtEngine'];
				$price = $_POST['txtPrice'];
				$filename = $_FILES['image']['name'];

				//check image is empty or not
				if($filename == "")
				{
					echo "<script> alert('Please insert the photo') </script>";
					exit();
				}

				//move image from local to server image folder
				$temp = $_FILES['image']['tmp_name'];

				// get file extension
				$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

				// allowed types
				$allowed = array("jpg", "jpeg", "png");

				if(!in_array($ext, $allowed))
				{
    				echo "<script>alert('Only JPG, JPEG, PNG, GIF files are allowed!')</script>";
				}
				else
				{
					$folder = './Images/'.$filename;
					move_uploaded_file($temp, $folder);
				}

				//insert query
				$sql = "insert into cars(cname, ctype, cmodel, seats, fuel, transmission, enginepower, priceperday, photo) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$stmt = $connection->prepare($sql);

				//parameter bind
				$stmt->bind_param("sssisssds", $cname, $ctype, $cmodel, $seat, $fuel, $transmission, $engine, $price, $filename);

				//execute
				if($stmt->execute())
				{
					echo "<script>window.location='carmanage.php';</script>";
				}
				else
				{
					echo "<script> 
					alert('Inserted Unsuccessfully!')
					</script>";
				}
			}
		?>
</body>
</html>