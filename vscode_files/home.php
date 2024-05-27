<?php
session_start(); // Start the session

$server = "localhost";
$username = "root";
$password = "";
$database = "rental_system";

// Creating connection
$conn = mysqli_connect($server, $username, $password, $database);
if ($conn->connect_error) 
{ 
  die("Connection failed: " . $conn->connect_error); 
}
// Check if the user is logged in 
if (!isset($_SESSION['logged_in']) ||$_SESSION['logged_in'] !== true) 
{ 
  // If not logged in, redirect to the loginpage 
  header("Location: index.php"); 
  exit(); 
} 
// If sign-out is clicked 
if(isset($_POST['signout'])) 
{ 
  // Unset all session variables 
  session_unset(); 
  //Destroy the session 
  session_destroy(); 
  // Redirect to the login page
header("Location: index.php"); 
exit(); 
} 
$sql = "SELECT * FROM `car` WHERE `car`.`flag`=1;"; 
$result= $conn->query($sql); 

if ($result) 
{ 
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $result->free(); 
} 
else 
{ 
  echo "Error executing the query: " . $conn->error; 
}
echo $curr_user['username']; // Close connection 
$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RAM SHETTY CAR RENTALS</title>
    <link rel="stylesheet" href="style_home.css" />
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

    <div class="shopping">
      <?php foreach ($rows as $row): ?>
      <div class="box">
        <a
          class="flex_box_link"
          href="rental.php?car_id=<?php echo $row['carid']; ?>">
          <div class="box-cont">
            <img class="car_image" src="<?php echo $row['image']; ?>" /><br />
            <?php echo $row['carname']; ?><br />
            <?php echo $row['seating'] . " seats"; ?><br />
            Per Hour: Rs.
            <?php echo $row['hourprice']; ?><br />
            Per Day: Rs.
            <?php echo $row['dayprice']; ?>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </body>
</html>
