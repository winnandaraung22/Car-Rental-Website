<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Car Management_Delete</title>
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

    	<!-- sidebar -->
    	<div class="sidebar">
        	<h3>Dashboard</h3>

        	<a href="carmanage.php" class="active">🚗 Cars Management</a>
        	<a href="bookingRequest.php">📅 Booking Management</a>
        	<a href="cusManage.php">👤 Customer Information</a>
			<a href="logout.php">🚪 Logout</a>
    	</div>

    	<!-- Right Side -->
    	<div class = "right-content">

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
            			<!-- table title -->
            			<tr>
                			<th colspan="9" class="table-title">Car Information</th>
            			</tr>

            			<!-- table header -->
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
                                	  <td><img src='Images/{$row['photo']}' alt='photo' width='80'> </td>
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
                    			<input type="submit" name="btnDelete" value="Delete" class="delete" onclick="return confirmDelete()">
                    			<a href="carmanage.php" class="btnback">Back</a>
                			</td>
            			</tr>
        				</table>
        			</div>
        		</form>
    		<div>
    	</div>
	</div>

	<script type="text/javascript">
		//check row selected or not
		function selectRow(row)
		{
    		var rows = document.querySelectorAll(".cartable tr");
    		rows.forEach(r => r.classList.remove("selected-row"));

    		row.classList.add("selected-row");

    		row.querySelector("input[type=radio]").checked = true;
		}

		//show confirm message
		function confirmDelete()
		{
    		var selected = document.querySelector("input[name='carid']:checked");

    		if(!selected)
    		{
        		alert("Please select a car!");
        		return false;
    		}
    		else
    		{
    			return confirm("Are you sure you want to delete?");
    		}
		}

	</script>

	<?php
		//validate the delete button
		if(isset($_POST['btnDelete']))
		{
			//check car is selected or not
    		if(isset($_POST['carid']))
    		{
    			//accept car id to delete
        		$id = $_POST['carid'];

        		//connect to database
        		$connection = connect();

        		//check if car is booked
        		$sql = "select * from booking where id=?";
        		$stmt = $connection->prepare($sql);

        		//bind parameter
        		$stmt->bind_param("i", $id);

        		//execute
        		$stmt->execute();

        		//getresult
        		$result = $stmt->get_result();

        		//validate executation
        		if($result->num_rows > 0)
        		{
            		echo "<script>
                    alert('Cannot delete. Car is already booked!');
                  </script>";
        		}
        		else
        		{
        			//delete query
        			$sql = "delete from cars where id=?";
        			$stmt = $connection->prepare($sql);
        			$stmt->bind_param("i", $id);
        			if($stmt->execute())
        			{
        				echo "<script> alert('Car deleted Successfully!');
        					window.location='carmanage.php';
        				 </script>";
        			}
        			else
        			{
            			echo "<script>alert('Delete failed!')</script>";
            		}
        		}
    		}
    		else
    		{
        		echo "<script>alert('Please select a car!')</script>";
    		}
		}
	?>
</body>
</html>