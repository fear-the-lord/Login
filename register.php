<?php
    // Import the configurations
    require_once "config.php";

    $username = $password = $confirm_password = $email = "";
    $username_err = $password_err = $confirm_password_err = $email_err = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // Check if the username is empty 
        if(empty(trim($_POST['username']))) {
            $username_err = "Username cannot be kept blank!";
            echo "<script>alert('$username_err');</script>"; 
        } else {
            $sql = "SELECT id from users WHERE username = ?"; 
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt) {
                // Bind the parameter for the markers 
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                // Set the value of param_username 
                $param_username = trim($_POST['username']);

                // Try to execute this statement 
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        // Username already exists
                        $username_err = "This username is already taken!";
                        echo "<script>alert(' $username_err ')</script>";
                        
                    } else {
                        $username = trim($_POST['username']);
                    }
                } else {
                     echo '<script>alert(" Something went wrong! ")</script>';
                }
            }
        }
        mysqli_stmt_close($stmt);
      
        
        // Check if the password is empty 
        if(empty(trim($_POST['password']))) {
            echo "Password cannot be kept blank!";
            $password_err = "Password cannot be kept blank!";
        } else if(strlen(trim($_POST['password'])) < 6) {
            $password_err = "Password should have atleast 6 characters!";
            echo "<script>alert(' $password_err ')</script>";
        } else {
            $password = trim($_POST['password']);
        }

        // Check for confirm password
        if(trim($_POST['confirm_password']) != trim($_POST['password'])) {
            $confirm_password_err = "Passwords should match!";
            echo "<script>alert(' $confirm_password_err ')</script>";
        } else {
            $confirm_password = trim($_POST['confirm_password']);
        }

        // Check if email is empty 
        if(empty(trim($_POST['email']))) {
            $email_err = "Email cannot be left blank";
        } else {
            $email = trim($_POST['email']);
        }

        // If there are no errors 
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
            // Insert values into the database 
            $vkey = md5(time().$username);
            $sql = "INSERT INTO users(username, password1, email, vkey) VALUES (?, ?, ?, ?)";
            // Prepare the query 
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt) {
                // Bind the parameter for the markers 
                mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_email, $param_vkey);

                // Set the parameters
                $param_username = $username; 
                // Encrypt and store the password
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_email = $email;
                $param_vkey = $vkey;

                // Try to execute the query
                if(mysqli_stmt_execute($stmt)) {
                    // Send Email 
                    $to = $email;
                    $subject = "Verification Email";
                    $message = "<a href = 'http://localhost/Login/verify.php?vkey=$vkey'>Register Account</a>";
                    $headers = "From: souvikghosh199831@yahoo.com" . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    mail($to, $subject, $message, $headers);

                    header("location: mailconfirm.html");
                    header( "refresh:5;url=login.php" );
                } else {
                    echo '<script>alert("Something went wrong...cannot redirect!")</script>';
                }
            }  
            mysqli_stmt_close($stmt);
        }
        //Close the connection
        mysqli_close($conn);
    }

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Registration Page</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
  </head>
  <body>

    <!-- Creating the Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <i class="fa fa-train" style= "color: white;"></i>&nbsp;&nbsp;<a class="navbar-brand" href="#">Railway Reservation System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            <a class="nav-link" href="#">About</a>
            <a class="nav-link" href="https://fear-the-lord.github.io/Souvik-Portfolio-Website/">Contact Us</a>
            <!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            </div>
        </div>
    </nav>

    <!-- Creating the form -->
    <div class="login">
        <h1>Register</h1>
            <form method="post" action = "">
                <input type="text" name="username" placeholder="Username" required="required" />
                <input type="password" name="password" placeholder="Password" required="required" />
                <input type="password" name="confirm_password" placeholder="Confirm Password" required="required" />
                <input type = "email" name = "email" placeholder = "Enter Email" required = "required" />
                <button type="submit" class="btn btn-primary btn-block btn-large">Add me.</button>
                <h3 style = "color: white;">Already an user? <a href = "login.php">Login</a></h3>
            </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>