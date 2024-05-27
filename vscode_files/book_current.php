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
$user_details=$_SESSION['user_details'];
$userid=$user_details['userid'];
$sql="SELECT * FROM `booking` WHERE `booking`.`userid`='$userid';";
$result=mysqli_query($conn,$sql);
if($result){
  $booking_details=$result->fetch_all(MYSQLI_ASSOC);
  $result->free();
}
else 
{ 
  echo "Error executing the query: " . $conn->error; 
}

if(isset($_POST['return'])){
  $carnum=$_POST['carnum'];
  $temp=mysqli_query($conn,"SELECT * FROM `car` WHERE `car`.`carnum`='$carnum';");
  if($temp){
    $temp_result=$temp->fetch_assoc();
  }else{
    echo "Error executing the query: " . $conn->error; 
  }
  $userid=$user_details['userid'];
  $carname=$temp_result['carname'];
  $rent_details=$_SESSION['rent_details'];
  $finalA=$rent_details['final_amt'];
  $sql_hist="INSERT INTO `rent_history` (`userid`, `carnum`, `carname`, `finalamt`) VALUES ('$userid','$carnum', '$carname','$finalA');";
  $result_hist=mysqli_query($conn,$sql_hist);
  if($result_hist){
    echo "HISTORY SUCCESS";
  }
  else 
  { 
    echo "Error executing the query: " . $conn->error; 
  }
  
  $sql_del="DELETE FROM `booking` WHERE `booking`.`carnum`='$carnum';";
  $result_del=mysqli_query($conn,$sql_del);
  if($result_del)
  {
    echo "SUCCESS";
    $sql_flag="UPDATE `car` SET `flag`='1' WHERE `car`.`carnum`='$carnum';";
    $result_flag=mysqli_query($conn,$sql_flag);
    if($result_flag){
      echo "flag SUCCESS";
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
    }else{
      echo "ERROR: ".mysqli_error($conn);
    }
  }else{
    echo "ERROR: ".mysqli_error($conn);
  }

}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RAM SHETTY CAR RENTALS</title>
    <link rel="stylesheet" href="style_bookings.css" />
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

    <h1 class="heading" >CURRENT RENTALS</h1>

    <div class="gap">
      <?php foreach($booking_details as $row):?>
      <div class="class">
        <div class="car"><?php echo $row['carname'];?></div>
        <div><?php echo $row['carnum'];?></div>
        <div><?php echo $row['finalamt'];?></div>
        <div class="p">
          <form method="post">
          <input type="hidden" name="carnum" value="<?php echo $row['carnum']; ?>">
          <button name="return" type="submit">RETURN</button>
          </form>
        </div>
      </div><?php endforeach?>
    </div>
    
  </body>
</html>

