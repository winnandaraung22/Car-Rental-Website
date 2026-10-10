<?php
	session_start();
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customer Information</title>
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
        	<a href="bookingRequest.php">📅 Booking Management</a>
        	<a href="cusManage.php" class="active">👤 Customer Information</a>
            	<a href="logout.php">🚪 Logout</a>
    	</div>

    	<!-- Right Side -->
    	<div class="right-content">
    	<!-- Main Content -->
    	<div class="main-content">
        	<h2>Welcome to Admin Dashboard</h2>
        	<p>🙋Hello <?php echo $_SESSION['adminname']; ?> </p>
        </div>

        	<!-- Customer Management Table -->
    		<div class="car-section">
        		<table class="cartable">
            		<!-- Table Title -->
            		<tr>
                		<th colspan="5" class="table-title">Registered User Information</th>
            		</tr>

            		<!-- Table Header -->
            		<tr>
                		<th>Registered Name</th>
                		<th>Email</th>
                		<th>Password</th>
                		<th>Phone</th>
                		<th>Gender</th>
            		</tr>

            		<!-- data from database -->
                	<?php
                		//connect to database
                		$connection = connect();

                		//select query
                		$sql = "select * from register";
                		$stmt = $connection->prepare($sql);
                		$stmt->execute();
                		$result = $stmt->get_result();

                		if($result->num_rows > 0)
                		{
                    		while($row = $result->fetch_assoc())
                    		{
                        		echo "<tr onclick='selectRow(this)'>
                                <td><input type='radio' name='carid' value='{$row['id']}' hidden> {$row['cusname']}
                                </td>
                                <td>{$row['email']}</td>
                                <td>{$row['cuspsw']}</td>
                               	<td>{$row['cusphone']}</td>
                                <td>{$row['gender']}</td>
                              	</tr>";
                    		}
                		}
                		else
                		{
                    		echo "<tr><td colspan='5'>No data found</td></tr>";
                		}
                	?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>