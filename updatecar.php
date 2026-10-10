<?php
	session_start();
	include("DBConnect.php");

	// check id
	if(!isset($_GET['id']))
	{
    	header("Location: carmanage.php");
    	exit();
	}

	$id = $_GET['id'];

	// connect DB
	$connection = connect();

	// get selected car data
	$sql = "select * from cars where id=?";
	$stmt = $connection->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Car Management_Update</title>
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
        		//if admin is logged in, dashboard access. If not, redirect admin login
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
    					<h2>Update Car Information</h2>

        			<!-- Row 1 -->
        			<tr>
            			<td>
                			<label>Car Name</label><br>
                			<input type="text" name="txtCarname" id="txtCarname" value="<?php echo $row['cname']; ?>">
            			</td>

            			<td>
                			<label>Type</label><br>
                			<input type="text" name="txtType" id="txtType" value="<?php echo $row['ctype']; ?>">
            			</td>
        			</tr>

        			<!-- Row 2 -->
        			<tr>
            			<td>
                			<label>Model</label><br>
                			<input type="text" name="txtModel" id="txtModel" value="<?php echo $row['cmodel']; ?>">
            			</td>

            			<td>
                			<label>Seats</label><br>
                			<input type="number" name="txtSeats" id="txtSeats" value="<?php echo $row['seats']; ?>">
            			</td>
        			</tr>

        			<!-- Row 3 -->
        			<tr>
            			<td>
                			<label>Fuel Type</label><br>
                			<input type="text" name="txtFuel" id="txtFuel" value="<?php echo $row['fuel']; ?>">
            			</td>

            			<td>
                			<label>Transmission</label><br>
                			<input type="text" name="txtTransmission" id="txtTransmission" value="<?php echo $row['transmission']; ?>">
            			</td>
        			</tr>

        			<!-- Row 4 -->
        			<tr>
            			<td>
                			<label>Engine Power</label><br>
                			<input type="text" name="txtEngine" id="txtEngine" value="<?php echo $row['enginepower']; ?>">
            			</td>

            			<td>
                			<label>Price Per Day</label><br>
                			<input type="number" name="txtPrice" id="txtPrice" value="<?php echo $row['priceperday']; ?>">
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
                			<input type="submit" name="txtUpdate" value="Update Car" class="btninsert">
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
	</div>

	<script type = "text/javascript">

		function validate()
		{
			//check null value
			var carname = document.getElementById("txtCarname").value
			var type = document.getElementById("txtType").value
			var model = document.getElementById("txtModel").value
			var seat = document.getElementById("txtSeats").value
			var fuel = document.getElementById("txtFuel").value
			var transmission = document.getElementById("txtTransmission").value
			var engine = document.getElementById("txtEngine").value
			var price = document.getElementById("txtPrice").value

			if(carname == "" || type == "" || model == "" || seat == "" || fuel == "" || transmission == "" || engine == "" || price == "")
    		{
        		alert("All fields must not be empty!");
        		return false;
    		}
		}
	</script>

	<?php
		if(isset($_POST['txtUpdate']))
		{
    		$cname = $_POST['txtCarname'];
    		$ctype = $_POST['txtType'];
    		$cmodel = $_POST['txtModel'];
    		$seat = $_POST['txtSeats'];
    		$fuel = $_POST['txtFuel'];
    		$transmission = $_POST['txtTransmission'];
    		$engine = $_POST['txtEngine'];
    		$price = $_POST['txtPrice'];

    		// check if new image uploaded
    		if($_FILES['image']['name'] != "")
    		{
        		$filename = $_FILES['image']['name'];
        		$temp = $_FILES['image']['tmp_name'];

        		$folder = "./Images/".$filename;
        		move_uploaded_file($temp, $folder);

        		//update query
        		$sql = "update cars set cname=?, ctype=?, cmodel=?, seats=?, fuel=?, transmission=?, enginepower=?, priceperday=?, photo=? where id=?";
        		$stmt = $connection->prepare($sql);

        		//parameter bind
        		$stmt->bind_param("sssisssdsi", $cname, $ctype, $cmodel, $seat, $fuel, $transmission, $engine, $price, $filename, $id);
    		}
    		else
    		{
        		// no image update
        		$sql = "update cars set cname=?, ctype=?, cmodel=?, seats=?, fuel=?, transmission=?, enginepower=?, priceperday=? where id=?";
        		$stmt = $connection->prepare($sql);
        		$stmt->bind_param("sssisssdi", $cname, $ctype, $cmodel, $seat, $fuel, $transmission, $engine, $price, $id);
    		}

    		if($stmt->execute())
    		{
        		echo "<script> window.location='carmanage.php';</script>";
    		}
    		else
    		{
        		echo "<script>alert('Update failed!')</script>";
    		}
		}
	?>
	
</body>
</html>