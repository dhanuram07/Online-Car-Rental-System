<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (
        isset($_POST['fullname']) && !empty($_POST['fullname']) &&
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['phone']) && !empty($_POST['phone']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])
    ) {
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "rental_system";

        // Creating connection
        $conn = mysqli_connect($server, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $fullname = $_POST['fullname'];
            $input_username = $_POST['username'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $input_password = $_POST['password'];

            // Check if username or email already exists
            $check_query = "SELECT * FROM `user` WHERE `username`='$input_username' OR `email`='$email'";
            $result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("Username or email already exists")</script>';
               
                
            } else {
                $sql = "INSERT INTO `user`(`fullname`,`username`,`email`,`phone`,`password`) 
                        VALUES ('$fullname','$input_username','$email','$phone','$input_password')";
                
                if (mysqli_query($conn, $sql)) {
                    echo "New record inserted successfully";
                    $_SESSION['logged_in'] = true;
                    $_SESSION['input_username']=$input_username;
                    header("Location: home.php");
                    exit(); // Stop further execution after redirect
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                $info_query = "SELECT * FROM `user` WHERE `username`='$input_username' OR `email`='$email'";
                $resulti = mysqli_query($conn, $info_query);
                if ($resulti->num_rows > 0) {
                    $curr_user=array();
                    $curr_user=$resulti->fetch_assoc();
                    $_SESSION['user_details']=$curr_user;
                   } else 
                   {
                        echo "Error executing the query: " . $conn->error;
                    }

            }
        }
    } else {
        echo '<script>alert("Please fill in all required fields")</script>';
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@402&display=swap" rel="stylesheet">
</head>

<body>
    <h1 class="web_title">RAM-SHETTY CAR RENTALS</h1>
    <div class="container">
        <div class="form_area">
            <p class="title">SIGN-UP</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form_group">
                    <label class="sub_title" for="name">Full Name</label>
                    <input placeholder="Enter your fullname" name="fullname" class="form_style" type="text" required/>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="usernmae">Username</label>
                    <input placeholder="Enter your username" name="username" class="form_style" type="text" required/>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="Phone">Phone</label>
                    <input placeholder="Enter your phone number" name="phone" class="form_style" type="number" min="10"
                        oninvalid="this.setCustomValidity('Invalid Phone Number')" required/>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" id="email" name="email" class="form_style" type="email" required/>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" name="password" class="form_style"
                        type="password" required/>
                </div>
                <div>
                    <button class="btn" name="signup" type="submit">SIGN UP</button>

                    <p><a class="link" href="index.php">Back to Login</a></p><a class="link" href="">
                    </a>
                </div><a class="link" href="">

                </a>
            </form>
        </div><a class="link" href="">
        </a>
    </div>

</body>

</html>