<?php
session_start(); // Start the session

$server = "localhost";
$username = "root";
$password = "";
$database = "rental_system";

$car_details = array();
$rent_details = array();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

$car_details=$_SESSION['car_details'];
$rent_details=$_SESSION['rent_details'];
$user_details=$_SESSION['user_details'];
// echo nl2br(print_r($_SESSION, true));

if(isset($_POST['confirm_rent']))
{
  $carid=$car_details['carid'];
  $carnum=$car_details['carnum'];
  $carname=$car_details['carname'];
  $userid=$user_details['userid'];
  $username=$user_details['username'];
  $email=$user_details['email'];
  $finalamt=$rent_details['final_amt'];
  $sql1="SELECT * FROM `booking` WHERE `carnum`='$carnum';";
  $result1=mysqli_query($conn,$sql1);
  if(mysqli_num_rows($result1)>0){
    echo '<script>alert("Car already rented under the username")</script>';
  }else{
  $sql="INSERT INTO `booking` (`carid`, `carnum`, `userid`, `username`, `email`, `finalamt`,`carname`) 
  VALUES ('$carid','$carnum',' $userid', '$username', '$email', '$finalamt','$carname');";
  $result=mysqli_query($conn,$sql);
  if($result){
    echo "INSERTION SUCESSFULL";
  }
  else{
    echo "error: ".mysqli_error($conn);
  }
  $sql_flag="UPDATE `car` SET `flag` = '0' WHERE `car`.`carnum` = '$carnum';";
  $result_flag=mysqli_query($conn,$sql_flag);
  {
    if($result){
      echo "flag success";
    }else{
      echo "error: ". mysqli_error($conn);
    }
  }
}
}

?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RAM SHETTY CAR RENTALS</title>
    <link rel="stylesheet" href="style_rental_final.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Lexend:wght@402&display=swap"
      rel="stylesheet"
    />
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
          <button class="signout_button" type="submit" name="signout">
            SIGN OUT
          </button>
        </form>
      </div>
    </div>

    <div class="receipt">
      <div class="receipt_title">
        <h1>CAR RENTAL DETAILS</h1>
      </div>
      <div class="receipt_image">
        <img src="<?php echo $car_details['image']?>" />
      </div>
      <div class="receipt_details">
        <p><?php echo $car_details['carname']?></p>
        <p><?php echo $car_details['seating']?></p>
        <p><?php if($rent_details['price_type']=="perhour")
                    { 
                      echo "PER HOUR";
                    } 
                    elseif($rent_details['price_type']=="perday")
                    {
                      echo "PER DAY";
                    } 
                    ?></p>
                    <br>
        <p><?php if($rent_details['price_type']=="perhour")
                    { 
                      echo "For a total of ".$rent_details['hours']." hours";
                    } 
                    elseif($rent_details['price_type']=="perday")
                    {
                      echo "Start Date: ".$rent_details['start']."<br>";
                      echo "End Date: ".$rent_details['end']."<br>";
                      echo "For a total of ".$rent_details['days']." days";
                    } 
                    
                    ?></p>
                    <br>
        <p><?php echo "Rs.".$rent_details['final_amt'];?></p>
      </div><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div ><button class="submitButton" name="confirm_rent" type="submit">CONFIRM RENT</button></div></form>
    </div>
  </body>
</html>
