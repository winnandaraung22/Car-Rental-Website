<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="logo"> 
			CityDrive Rentals 
		</div>
		<nav>
			<a href="index.php" class="active">Home</a>
			<a href="carinfo.php">Cars</a>
			<a href="register.php">Register</a>

			<div class="dropdown">
        		<a href="#" class="dropbtn">Login<span class="arrow">▼</span> </a>

        		<!--  -->
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
					Affordable, reliable, and comfortable car rentals for every journey.
				</p>

				<div class="hero-buttons">
					<a href="carinfo.php" class="btn btn-primary">View Cars</a>
					<a href="userlogin.php" class="btn btn-secondary">Book Now</a>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="vehicle">
			<h2>A vehicle that meets your needs</h2>
			<p>
				Seeking to test the new models
			</p>
			<div class="photo">
				<div>
					<img src="Images/Compact Car.png">
					<img src="Images/Luxury Car.png">
					<img src="Images/Minivan.png">
					<img src="Images/Standard SUV.png">
				</div>

				<div>
					<p> Compact Car </p>
					<p> Luxury Car </p>
					<p> Minivan </p>
					<p> Standard SUV </p>
				</div>

				<div>
					<a href="carinfo.php?type=Compact Car">See More</a>
					<a href="carinfo.php?type=Luxury Car">See More</a>
					<a href="carinfo.php?type=Minivan">See More</a>
					<a href="carinfo.php?type=Standard SUV">See More</a>
				</div>
			</div>
		</div>
	</section>

	<div class="about">
		<div class="about1">
			<h2> About Us </h2>
			<p>
				CityDrive Rentals is a trusted car rental company dedicated to providing affordable, reliable, 
            	and convenient transportation solutions for customers. Whether you need a car for business trips, 
            	family travel, or daily commuting, CityDrive Rentals offers a wide selection of well-maintained vehicles 
            	to suit your needs.
			</p>
		</div>

		<div class="about2">
			<h2> Why Choose Us? </h2>
			<p>
				CityDrive Rentals is committed to providing customers with affordable, reliable, and convenient car rental services. With a wide range of well-maintained vehicles, an easy online booking process, and customer-focused support, we ensure a smooth and comfortable travel experience for every journey.
			</p>
		</div>
	</div>

	<section class="contact">
    	<div>
        	<h2>Contact Us</h2>
        	<p>
            	Have questions or need assistance with your booking? Our team at CityDrive Rentals is here to help.
            	Feel free to reach out to us through the following contact details.
        	</p>

        	<div class="contact-info">
            	<p> <strong> Address: </strong> Yangon, Myanmar </p>
            	<p> <strong> Phone: </strong> +95 9 79 546 812 64 </p>
            	<p> <strong> Email: </strong> info@citydrive.com </p>
        	</div>
    	</div>
	</section>

	<footer class="footer">
		<p> &copy; 2026 CityDrive Rentals.  All Rights Reserved. </p>
	</footer>
	
</body>
</html>