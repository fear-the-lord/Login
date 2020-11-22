<?php 
    // Start the PHP session
    session_start(); 

    // Check if the user is already logged in 
    if(isset($_SESSION['username'])) {
        header("location: welcome.php");
        exit;
    }

    // Establish a connection with the database 
    require_once "config.php";

    $username = $password = "";
    $username_err = $password_err = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty(trim($_POST['username']))) {
            $username_err = "Please enter username";
        } else {
            $username = trim($_POST['username']);
        }
        if(empty(trim($_POST['password']))) {
            $password_err = "Please enter password";
        } else {
            $password = trim($_POST['password']);
        }
        if(empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, password1 FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt) {
                // Bind the parameter for the markers 
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                // Set the value of param_username 
                $param_username = $username;

                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)) {
                            if(password_verify($password, $hashed_password)) {
                                // Allow user to login
                                session_start(); 
                                $_SESSION['username'] = $username; 
                                $_SESSION['id'] = $id; 
                                $_SESSION['loggedin'] = true; 

                                // Redirect user to welcome page
                                header("location: welcome.php");
                            } else {
                                // User has entered wrong password
                                $password_err = "Invalid Username or Password!";
                                echo "<script>alert(' $password_err ')</script>";
                            }
                        }
                    }
                }
            }
        }
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
    <title>Login Page</title>
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
            <a class="nav-link" href="register.php">Register</a>
            <a class="nav-link" href="https://fear-the-lord.github.io/Souvik-Portfolio-Website/">Contact Us</a>
            <!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            </div>
        </div>
    </nav>

    <div class="login">
        <h1>Login</h1>
            <form method="post" action = "">
            <input type="text" name="username" placeholder="Username" required="required" />
                <input type="password" name="password" placeholder="Password" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
            </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>