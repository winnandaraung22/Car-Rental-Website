<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Car Management</title>
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

        	<!-- Car Table -->
        	<div>
        		<form action="" method="POST">
    				<div class="car-section">
        				<table class="cartable">
            			<!-- Table Title -->
            			<tr>
                			<th colspan="9" class="table-title">Car Information</th>
            			</tr>

            			<!-- Table Header -->
            			<tr>
                			<th>Car Name</th>
                			<th>Type</th>
                			<th>Model</th>
                			<th>Seats</th>
                			<th>Fuel Type</th>
                			<th>Transmission</th>
                			<th>Engine Power</th>
                			<th>Price Per Day</th>
                			<th>Photo</th>
            			</tr>

            			<!-- data from database -->
                		<?php
                			$connection = connect();
                			$sql = "select * from cars";
                			$stmt = $connection->prepare($sql);
                			$stmt->execute();
                			$result = $stmt->get_result();

                			if($result->num_rows > 0)
                			{
                    			while($row = $result->fetch_assoc())
                    			{
                        			echo "<tr onclick='selectRow(this)'>
                                	<td><input type='radio' name='carid' value='{$row['id']}' hidden> {$row['cname']}
                                	</td>
                                	<td>{$row['ctype']}</td>
                                	<td>{$row['cmodel']}</td>
                                	<td>{$row['seats']}</td>
                                	<td>{$row['fuel']}</td>
                                	<td>{$row['transmission']}</td>
                                	<td>{$row['enginepower']}</td>
                                	<td>{$row['priceperday']}</td>
                                	<td><img src='Images/{$row['photo']}' alt='photo' width='80'>
                                	</td>
                              		</tr>";
                    			}
                			}
                			else
                			{
                    			echo "<tr><td colspan='9'>No data found</td></tr>";
                			}
                		?>

            			<!-- Buttons Row -->
            			<tr>
                			<td colspan="9" class="table-buttons">
                    			<input type="submit" name="btnInsert" value="Insert" class="insert">
                    			<input type="submit" name="btnUpdate" value="Update" class="update">
                    			<input type="submit" name="btnDelete" value="Delete" class="delete">
                			</td>
            			</tr>
        				</table>
    				</div>
    			</form>
    		</div>
    	</div>
	</div>

	<script type="text/javascript">
		//check the onclick event
		function selectRow(row)
		{
    		// remove old selection
    		var rows = document.querySelectorAll(".cartable tr");
    		rows.forEach(r => r.classList.remove("selected-row"));

    		// highlight new row
    		row.classList.add("selected-row");

    		// check radio button
    		row.querySelector("input[type=radio]").checked = true;
		}
	</script>

	<?php
	//validate the button from the form
		if(isset($_POST['btnInsert']))
		{
    		echo "<script>window.location='insertcar.php?id=".$id."';</script>";
		}

		if(isset($_POST['btnUpdate']))
		{
			if(isset($_POST['carid']))
    		{
        		$id = $_POST['carid'];
        		echo "<script>window.location='updatecar.php?id=".$id."';</script>";
    		}
    		else
    		{
        		echo "<script>alert('Please select a car!')</script>";
    		}
    		
		}

		if(isset($_POST['btnDelete']))
		{
    		echo "<script>window.location='deletecar.php?id=".$id."';</script>";
		}
	?>
</body>
</html>