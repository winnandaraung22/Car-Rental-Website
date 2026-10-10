<?php
	include("DBConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cars Information</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="logo"> 
			CityDrive Rentals 
		</div>
		<nav>
			<a href="index.php">Home</a>
			<a href="carinfo.php" class="active">Cars</a>
			<a href="register.php">Register</a>

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

	<section class="hero">
		<div class="hero-overlay">
			<div class="hero-content">
				<h1>Drive Your Perfect Ride Today</h1>
				<p>
					A car is not just metal; it's a dream on wheels.
				</p>
			</div>
		</div>
	</section>

	<section class="vehicle">
		<div> <h2> Car Details </h2> </div>

		<?php
			// get category from URL
			$type = isset($_GET['type']) ? $_GET['type'] : '';

			$connection = connect();

			if($type == "")
			{
    			// show all cars
    			$sql = "select * from cars";
    			$stmt = $connection->prepare($sql);
			}
			else
			{
    			// show only selected category
    			$sql = "select * from cars where ctype = ?";
    			$stmt = $connection->prepare($sql);
    			$stmt->bind_param("s", $type);
			}

			$stmt->execute();
			$result = $stmt->get_result();
		?>

		<h2>
			<?php 
				if($type == "")
				{
    				echo "All Cars Brand Names";
				}
				else
				{
    				echo $type;
    				echo '<div> <a href="carinfo.php" class="btn">View All Cars</a> </div>';
				}
			?>
		</h2>

		<div class="car-list">
			<?php
				if($result->num_rows > 0)
				{
    				while($row = $result->fetch_assoc())
    				{
						//connect to database
						$connection = connect();

						//accept car id
    					$carid = $row['id'];

    					//select query
    					$sql = "select * from booking where id=? and status = 'Booked'";

    					//statement
						$stmt = $connection->prepare($sql);

						//bind parameter
						$stmt->bind_param("i", $carid);

						//execute
						$stmt->execute();

						//get result
						$booked = $stmt->get_result();

						if($booked->num_rows > 0)
						{
    						$status = "Unavailable";
    						$btn = "<button class='btn disabled'>Unavailable</button>";
						}
						else
						{
    						$status = "Available";
    						$btn = "<a href='booking.php?id={$row['id']}' class='btn'>Book Now</a>";
						}

        				echo "
        				<div class='car-card'>
            
            			<div class='car-image'>
                			<img src='Images/{$row['photo']}' alt='car'>
            			</div>

            			<div class='car-details'>
                			<h3>{$row['cname']}</h3>
                				<p><strong>Model:</strong> {$row['cmodel']}</p>
                				<p><strong>Seats:</strong> {$row['seats']}</p>
                				<p><strong>Fuel:</strong> {$row['fuel']}</p>
                				<p><strong>Transmission:</strong> {$row['transmission']}</p>
                				<p><strong>Engine Power:</strong> {$row['enginepower']}</p>
                				<p><strong>Rental Rate:</strong> {$row['priceperday']} MMK/day</p>
            			</div>

            			<div>
            				$btn
            			</div>

        				</div>
        				";
    				}
				}
				else
				{
    				echo "<p>No cars found</p>";
				}
			?>

		</div>

	</section>

</body>
</html>