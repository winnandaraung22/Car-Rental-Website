<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Booking Requests </title>
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
	<div class="container1">

    	<!-- Sidebar -->
    	<div class="sidebar1">
        	<h3>Dashboard</h3>

        	<a href="carmanage.php">🚗 Cars Management</a>
        	<a href="bookingRequest.php" class="active">📅 Booking Management</a>
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
        
        	<!-- Booking Request Table -->
        	<div>
    			<div class="car-section">
        			<table class="cartable">
            		<!-- Table Title -->
            		<tr>
                		<th colspan="11" class="table-title">Booking Requests</th>
            		</tr>

            		<!-- Table Header -->
            		<tr>
                		<th>Customer Name</th>
                		<th>Phone</th>
                		<th>Email</th>
                		<th>Age</th>
                		<th>Car ID</th>
                		<th>Start Date</th>
                		<th>End Date</th>
                		<th>Total Amount</th>
                		<th>Status</th>
                		<th>Registered User Account Name</th>
                		<th> </th>
            		</tr>

            		<!-- data from database -->
                	<?php
                		//connect to database
                		$connection = connect();

                		//select query
                		$sql = "select booking.*, register.cusname as reg_name from booking join register on booking.register_id = register.id";
                		$stmt = $connection->prepare($sql);

                		//execute
                		$stmt->execute();

                		//get result
                		$result = $stmt->get_result();

                		if($result->num_rows > 0)
                		{
                    		while($row = $result->fetch_assoc())
                    		{
                        		echo "<tr onclick='selectRow(this)'>
                                	<td><input type='radio' name='carid' value='{$row['booking_id']}' hidden> {$row['customername']}
                                	</td>
                                	<td>{$row['phone']}</td>
                                	<td>{$row['mail']}</td>
                                	<td>{$row['age']}</td>
                                	<td>{$row['id']}</td>
                                	<td>{$row['start_date']}</td>
                                	<td>{$row['end_date']}</td>
                                	<td>{$row['total']}</td>
                                	<td>{$row['status']}</td>
                                	<td>{$row['reg_name']}
                                	</td>

                                	<td>";
					  				if($row['status'] == 'Cancelled')
					  				{
    					    			echo "Finished";
					  				}
					  				else
					  				{
    					     			echo "<form method='POST'>
            							 <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
            							 <input type='submit' name='btnCancel' value='Open Booking' class='delete' onclick='return confirm(\"Are you sure you want to open booking?\")'>
          								</form>";
					    			}
					    			
									echo "</td>
                              	</tr>";
                    		}
                		}
                		else
                		{
                    		echo "<tr><td colspan='11'>No data found</td></tr>";
                		}
                	?>
                		</table>
            		</div>
        		
    		</div>
    	</div>
    </div>

    <?php
    	//validate the form button
    	if(isset($_POST['btnCancel']))
		{	
			//accept input
    		$booking_id = $_POST['booking_id'];

    		//connect to database
    		$connection = connect();

    		//update query to control booking finish or not finish
    		$sql = "update booking set status='Cancelled' where booking_id=?";
    		$stmt = $connection->prepare($sql);
    		$stmt->bind_param("i", $booking_id);

    		if($stmt->execute())
    		{
        		echo "<script>
            	  alert('Booking is Finished');
                  window.location='bookingRequest.php';
          		</script>";
    			exit();
    		}
		}
    ?>

</body>
</html>