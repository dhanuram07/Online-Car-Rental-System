<?php
session_start(); // Start the session

$login = false; // Initialize $login as false by default

if (isset($_POST['username'], $_POST['password'])) { // Check if username and password are submitted
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "rental_system";

    // Creating connection
    $conn = mysqli_connect($server, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //checking
        $input_username = $_POST['username']; // Use separate variable to avoid overwriting
        $_SESSION['input_username'] = $input_username; // Debugging: Set session variable
        echo "Debug: input_username = " . $_SESSION['input_username']; // Debugging: Output session variable
        $input_password = $_POST['password']; // Use separate variable to avoid overwriting
        $sql = "SELECT * FROM `user` WHERE username = '$input_username' AND password = '$input_password'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($result->num_rows > 0) {
                $login = true; // Set $login to true if credentials match
                $_SESSION['logged_in'] = true; // Set session variable to indicate user is logged in
                $curr_user=array();
                $curr_user=$result->fetch_assoc();
                $_SESSION['input_username'] = $input_username;
                $_SESSION['input_userid'] = $curr_user['userid'];
                $_SESSION['user_details']=$curr_user;
                // Redirect to home.php upon successful login
                header("Location: home.php");
                exit(); // Ensure script execution stops after redirection
            } else {
                echo '<script>alert("INVALID CREDENTIALS")</script>';
            }
        } else {
            echo "Error executing the query: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style_index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@402&display=swap" rel="stylesheet" />
</head>

<body>
    <h1 class="web_title">RAM-SHETTY CAR RENTALS</h1>
    <div class="container">
        <div class="form_area">
            <p class="title">LOG-IN</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form_group">
                    <label class="sub_title" for="username">Username</label>
                    <input placeholder="Enter your username" id="username" name="username" class="form_style"
                        type="text" required />
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" name="password" class="form_style"
                        type="password" required />
                </div>
                <div>
                    <button class="btn" type="submit">
                        LOGIN
                    </button>
                    <p>
                        Don't have an Account?
                        <a class="link" href="index_signup.php">Sign-Up Here!</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>