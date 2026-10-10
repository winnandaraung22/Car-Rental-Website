<?php
	session_start();
	include("DBConnect.php");

	if(!isset($_GET['id']))
    {
        header("Location: carinfo.php");
        exit();
    }
    else
    {
        //get car id
        $id = $_GET['id'];

        //connect to db
        $connection = connect();

        //select query
        $sql = "select * from cars where id=?";
        $stmt = $connection->prepare($sql);

        //bind parameter
        $stmt->bind_param("i", $id);

        //execute
        $stmt->execute();

        //get result
        $result = $stmt->get_result();
        $car = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Booking Form</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<div class="logo"> 
			CityDrive Rentals 
		</div>
		<nav class="customer">
			<a href="carinfo_afterlogin.php">Cars</a>
			<a href="booking.php" class="active">Booking</a>
			<a href="logout.php">Logout</a>
			<div class="admin-info">
        	<img src="Images/person.jpg" class="cus-img">
        	<span> 
        		<?php 
        		//if user is logged in, booking form access. If not, redirect user login
        			if(isset($_SESSION['username']))
        			{
        			    echo $_SESSION['username']; 
        			}
        			else
        			{
        				header("Location: userlogin.php");
        				exit();
        			}
        		?> 
        	</span>
    		</div>
		</nav>
	</header>

	<section class="loginimg">
        <div class="overlay">
            <div class="mainbox">
                <div class="booking-container">
                    <!-- LEFT --> 
                    <div class="car-image"> <img src="Images/<?php echo $car['photo']; ?>" width="250"> </div>
                    <div class="booking-form">
                        <form action="" method="POST" onsubmit="return validate()">
                            <h2>Booking Form</h2>

                            <input type="hidden" name="carid" value="<?php echo $car['id']; ?>">

                            <div class="form-columns">

                                <!-- COLUMN 1 -->
                                <div class="form-col">
                                    Name: <input type="text" name="txtName" id="txtName">
                                    Age: <input type="text" name="txtAge" id="txtAge">
                                    Category: <input type="text" value="<?php echo $car['ctype']; ?>" readonly>
                                    Start Date: <input type="date" name="startdate" id="startdate">
                                    Price: <input type="text" id="price" value="<?php echo $car['priceperday']; ?>" readonly>
                                </div>

                                <!-- COLUMN 2 -->
                                <div class="form-col">
                                    Email: <input type="email" name="txtEmail" id="txtEmail">
                                    Phone: <input type="text" name="txtPhone" id="txtPhone">
                                    Model: <input type="text" value="<?php echo $car['cmodel']; ?>" readonly>
                                    End Date: <input type="date" name="enddate" id="enddate">
                                    Total: <input type="text" name="txtTotal" id="txtTotal" readonly>
                                </div>

                            </div>

                            <input type="submit" name="btnConfirm" value="Confirm Booking" class="btn-book">

                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        //validate the form
        function validate() 
        {
            //null value
            var name = document.getElementById('txtName').value;
            var age = document.getElementById('txtAge').value;
            var email= document.getElementById('txtEmail').value;
            var phone = document.getElementById('txtPhone').value;
            var start = document.getElementById('startdate').value;
            var end = document.getElementById('enddate').value;
            if(name == "" || age == "" || email == "" || phone == "" || start == "" || end == "")
            {
                alert("Fill in the form!");
                return false;
            }
        }
    </script>

    <script type="text/javascript">
        //calculate the total
        document.getElementById("startdate").addEventListener("change", calculate);
        document.getElementById("enddate").addEventListener("change", calculate);

        function calculate() 
        {
            var start = document.getElementById("startdate").value;
            var end = document.getElementById("enddate").value;
            var price = parseFloat(document.getElementById("price").value);
            if(start == "" || end == "")
            {
                return;
            }

            var startDate = new Date(start);
            var endDate = new Date(end);

            //convert milliseconds to days
            var timedifference = endDate - startDate;
            var days = timedifference / (1000 * 60 * 60 * 24);

            if(days >= 0)
            {
                document.getElementById("txtTotal").value = days * price; 
            }
            else
            {
                document.getElementById("txtTotal").value = "";
                alert("Minimum booking is 1 day!");
            }
        }
        
    </script>

    <?php
        if(isset($_POST['btnConfirm']))
        {
            //connect to database
            $connection = connect();

            //accept input
            $name = $_POST['txtName'];
            $phone = $_POST['txtPhone'];
            $email = $_POST['txtEmail'];
            $age = (int) $_POST['txtAge'];
            $carid = $_POST['carid'];
            $start = $_POST['startdate'];
            $end = $_POST['enddate'];
            $total = $_POST['txtTotal'];

            //check total whether empty
            if(empty($total))
            {
                echo "<script type='text/javascript'>alert('Please select dates to calculate total!');</script>";
                return;
            }

            $user_id = $_SESSION['userid'];

            //insert query
            $sql = "insert into booking (customername, phone, mail, age, id, start_date, end_date, total, register_id)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);

            //parameter bind
            $stmt->bind_param("sssiissdi", $name, $phone, $email, $age, $carid, $start, $end, $total, $user_id);

            if($stmt->execute())
            {
                echo "<script type='text/javascript'>alert('Booking Successful'); window.location='carinfo_afterlogin.php';</script>";
            }
        }
    ?>

</body>
</html>