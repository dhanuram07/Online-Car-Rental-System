<?php
session_start(); // Start the session

$server = "localhost";
$username = "root";
$password = "";
$database = "rental_system";

$car_details = array();
$rent_details = array();

// Creating connection
$conn = mysqli_connect($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

// If sign-out is clicked
if (isset($_POST['signout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: index.php");
    exit();
}

// Retrieve car details based on car ID passed through URL
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Fetch car details from the database
    $sql = "SELECT * FROM `car` WHERE carid = '$car_id'";
    $result = $conn->query($sql);

    if ($result) {
       
        $car_details = $result->fetch_assoc();
        $_SESSION['car_details']=$car_details;

        $car_dayprice = $car_details['dayprice'];
        $car_hourprice = $car_details['hourprice'];

         $_SESSION['rent_details']['dayP'] = $car_dayprice;
        $_SESSION['rent_details']['hrP'] = $car_hourprice;
        
    } else {
        echo "Car not found!";
    }
}

// Initialize rent_details array


// Check if price_type and ac_type are set
if (isset($_POST['confirmButton'])) {
    $price_type = $_POST['price_type'];
    $ac_type = $_POST['ac_type'];
    $rent_details = array(
        'price_type' => $price_type,
        'ac_type' => $ac_type
    );

    // Calculate rental amount based on price_type and ac_type
    if ($price_type == 'perday') {
        $start = new DateTime($_POST['start_date']);
        $end = new DateTime($_POST['end_date']);
        $period = $start->diff($end); // Using $start and $end objects
        $days = $period->days;
        $price=$_SESSION['rent_details']['dayP'];

        
        $final_amt = $price * $days;

        if ($ac_type == 'ac') {
            $final_amt += (0.15 * $car_dayprice);
        }
        
        $rent_details['start'] = $_POST['start_date'];
        $rent_details['end'] = $_POST['end_date'];
        $rent_details['days'] = $days;
        $rent_details['final_amt'] = $final_amt;
    } elseif ($price_type == 'perhour') {
        $hours = $_POST['time'];
        echo $hours;
        $price=$_SESSION['rent_details']['hrP'];
        $final_amt = $price * $hours;

        if ($ac_type == 'ac') {
            $final_amt += (0.15 * $price);
        }
        echo $final_amt;
        $rent_details['hours'] = $hours;
        $rent_details['final_amt'] = $final_amt;
    }

    
    
    $_SESSION['rent_details']=$rent_details;
    header("Location: rental_final.php");
}
// print_r($rent_details);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAM SHETTY CAR RENTALS</title>
    <link rel="stylesheet" href="style_rental.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@402&display=swap" rel="stylesheet">
</head>

<body>

    <div class="navbar">
        <div class="navbar_brand">
            <a class="nav_links" href="home.php">RAM SHETTY CAR RENTALS</a>
        </div>
        <div class="navbar_items">
            <div class="home"><a class="nav_links" href="home.php">HOME</a></div>
            <!-- <BOOKINGS DROPDOWN> -->
        <div class="bookings">
  <button class="button">BOOKINGS &nbsp; ▼</button>
  <div class="dropdown-content">
    <a id="top" href="book_current.php">CURRENT</a>
    <a id="bottom" href="book_history.php">HISTORY</a>
  </div>
</div>
<!-- <BOOKINGS DROPDOWN END> -->
            <div class="user">
                <?php echo $_SESSION['input_username']; ?>
            </div>

            <form method="post">
                <button class="signout_button" type="submit" name="signout">SIGN OUT</button>
            </form>
        </div>
    </div>

    <!-- Car Details Section -->
    <div class="detail_section">
   <div class="detail">
    <section class="purchase_form">

        <img class="car_image" src="<?php echo $car_details['image']; ?>" alt="Car Image">
        <h2 class="car_details">
            <?php echo $car_details['carname']; ?>
        </h2>
        <p class="car_details">Seats:
            <?php echo $car_details['seating']; ?>
        </p>
        <p class="car_details">Car Number:
            <?php echo $car_details['carnum']; ?>
        </p>
        <p class="car_details">Price: Rs.
            <?php echo $car_details['hourprice']; ?> per hour
        </p>
        <p class="car_details">Price: Rs.
            <?php echo $car_details['dayprice']; ?> per Day
        </p>
    </section>
    </div>
 
<!-- Rental Form Section -->
<div class="rental">
<section class="rental-form">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
        <input type="radio" id="per_day" name="price_type" value="perday" required>
        <label for="per_day">Price Per Day</label><br>
        <div name="date_inputs" >
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" >
            <br>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" >
            <br>
        </div>
        <input type="radio" id="per_hour" name="price_type" value="perhour">
        <label for="per_hour">Price Per Hour</label><br>

        <div name="time_input" >
            <label for="time">Time (in hours):</label><br>
            <input type="number" id="time" name="time" min="1" placeholder="0">
            <br>
        </div>

        

        <input type="radio" id="ac" name="ac_type" value="ac" required>
        <label for="ac">A/C</label><br>
        <input type="radio" id="nac" name="ac_type" value="nac">
        <label for="nac">Non-A/C</label><br>
        <div id="final_amount" style="display: none;">
            <label for="final_amt">Final Amount:</label>
            <span id="final_amt_value"></span>
        </div>

        <!-- Other rental preferences/options here -->

        <button type="submit" name="confirmButton">
    
        Confirm Details
        </div>
 </div> 
</button>
    </form>
</section>



</body>

</html>