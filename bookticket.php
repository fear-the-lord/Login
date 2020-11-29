<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true){
    echo '<script>alert("Please login to continue!")</script>';
    header("location: login.php");
}
?>

<?php 
  // Import the configuration
  require_once "config.php";

  $name = $email = $to = $from = $phone = $date = $train_number = $gender = $age = ""; 
  $name_err = $email_err = $to_err = $from_err = $phone_err = $date_err = $train_number_err = $gender_err = $age_err = ""; 

  // When the send button is hit, this condition will execute
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    // Check if the name is empty
    if(empty(trim(isset($_POST['name'])))) {
      $name_err = "Name cannot be kept blank!";
      // echo "<script>alert('$name_err');</script>";
    } else {
      $name = trim($_POST['name']);
    }

    // Check if the email is empty 
    if(empty(trim(isset($_POST['email'])))) {
      $email_err = "Email cannot be kept blank!"; 
      // echo "<script>alert('$email_err');</script>";
    } else {
      $email = trim($_POST['email']);
    }

    // Check if to_station is empty
    if(empty(trim(isset($_POST['to'])))) {
      $to_err = "Starting station cannot be kept blank!"; 
      // echo "<script>alert('$to_err');</script>";
    } else {
      $to = trim($_POST['to']);
    }

     // Check if from_station is empty
     if(empty(trim(isset($_POST['from'])))) {
      $from_err = "Destination station cannot be kept blank!"; 
      // echo "<script>alert('$from_err');</script>";
    } else {
      $from = trim($_POST['from']);
    }

    // Check if phone number is empty and valid
    if(empty(trim(isset($_POST['phone'])))) {
      $phone_err = "Phone Number cannot be kept blank!"; 
      // echo "<script>alert('$phone_err');</script>";
    } else if((is_numeric(trim($_POST['phone']))) != 1) {
      $phone_err = "Phone Number must be digits!"; 
      echo "<script>alert('$phone_err');</script>";
    } else if(strlen(trim($_POST['phone'])) != 10) {
      $phone_err = "Phone Number should have 10 digits!"; 
      echo "<script>alert('$phone_err');</script>";
    } else {
      $phone = trim($_POST['phone']);
    }

    // Check if date is empty
    if(empty(isset($_POST['journey_date']))) {
      $date_err = "Date is not set!";
    } else {
      $date = $_POST['journey_date'];
    }

    // Check if train number is valid
    if(empty(trim(isset($_POST['train_number'])))) {
      $train_number_err = "Train Number must not be empty!";
    } else if((is_numeric(trim($_POST['train_number']))) != 1) {
      $train_number_err = "Train Number should contain only digits!";
      echo "<script>alert('$train_number_err');</script>";
    } else if(strlen(trim($_POST['train_number'])) != 5) {
      $train_number_err = "Train number should havr 5 digis";
      echo "<script>alert('$train_number_err');</script>";
    } else {
      $train_number = trim($_POST['train_number']);
    }

    // Check if train name is empty 
    if(empty(trim(isset($_POST['train_name'])))) {
      $train_name_err = "Train name cannot be kept blank!"; 
      // echo "<script>alert('$from_err');</script>";
    } else {
      $train_name = trim($_POST['train_name']);
    }

    // Check if the gender is valid 
    if(empty(trim(isset($_POST['gender'])))) {
      $gender_err = "Gender should not be kept blank!"; }
    // } else if(trim($_POST['gender']) != 'male' || trim($_POST['gender']) != "female" || trim($_POST['gender']) != "other") {
    //   $gender_err = "Please enter a correct value!";
    //   $echo "<script>alert('$gender_err');</script>";
    // } 
    else {
      $gender = trim($_POST['gender']);
    }

    // Check if the age is valid
    if(empty(trim(isset($_POST['age'])))) {
      $age_err = "Age should not be kept blank!";
    } else if(is_numeric(trim($_POST['age'])) != 1) {
      $age_err = "Age should be a number!";
      echo "<script>alert('$age_er');</script>";
    } else {
      $age = trim($_POST['age']);
    }


    // If the inputs are valid
    if(empty($name_err) && empty($email_err)  && empty($to_err) && empty($from_err) && empty($phone_err) && empty($date_err) && empty($train_number_err) && empty($train_name_err) && empty($gender_err) && empty($age_err)) {
      $pnr = rand(1000000, 9999999);
      $pnr_err = "Please note this PNR number for future purpose: $pnr";
      echo "<script>alert('$pnr_err');</script>";
      $sql = "INSERT INTO tickets(name, email, to_station, from_station, phone, journey_date, train_number, train_name, gender, age, pnr_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      // Prepare the query 
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt) {
        // Bind the parameter for the markers
        mysqli_stmt_bind_param($stmt, "sssssssssss", $param_name, $param_email, $param_to, $param_from, $param_phone, $param_date, $param_train_number, $param_train_name, $param_gender, $param_age, $param_pnr);
        // Set the parameters
        $param_name = $name; 
        $param_email = $email;
        $param_to = $to;
        $param_from = $from;
        $param_phone = $phone;
        $param_date = $date;
        $param_train_number = $train_number;
        $param_train_name = $train_name;
        $param_gender = $gender;
        $param_age = $age;
        $param_pnr = $pnr;
        // Try to execute the query 
        mysqli_stmt_execute($stmt);   
      }
      mysqli_stmt_close($stmt);
    }
    // Close the connection
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
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Booking Page</title>
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
            <a class="nav-link active" href="index.html">Home <span class="sr-only">(current)</span></a>
            <a class="nav-link" href="register.php">Register</a>
            <a class="nav-link" href="https://fear-the-lord.github.io/Souvik-Portfolio-Website/">Contact Us</a>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php"><img src="https://img.icons8.com/android/24/000000/user.png"/><?php echo "Welcome ". $_SESSION['username']?></a>
                    </li>
                </ul>
            </div>
            <!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            </div>
        </div>
    </nav>

    <main role="main">
  <button class="popup-trigger btn" id="popup-trigger"><span>Book Now<i class="fa fa-plus-square-o"></i></span></button> <br> <br>
  <button><a href = "" style = "text-decoration: none; top: 50%; right: 50%;"></button>
</main>
<div class="overlay" id="overlay">
  <div class="overlay-background" id="overlay-background"></div>
  <div class="overlay-content" id="overlay-content">
    <div class="fa fa-times fa-lg overlay-close" id="overlay-close"></div>
    <h1 class="main-heading">Enter Details</h1>
    <h3 class="blurb">Booking a ticket is now hassle free &mdash;</h3><span class="blurb-tagline">and won't take longer than a couple of seconds.</span>
    <form class="signup-form" method="post" action="">
      <label for="signup-name">Full Name</label>
      <input id="signup-name" type="text" name="name" autocomplete="off" required = "required"/>
      <label for="signup-email">Email Address</label>
      <input id="signup-email" type="email" name="email" autocomplete="off" required = "required"/>
      <label for="signup-pw">To</label>
      <input id="signup-pw" type="text" name="to" autocomplete="off" required = "required"/>
      <label for="signup-cpw">From</label>
      <input id="signup-cpw" type="text" name="from" autocomplete="off" required = "required"/>
      <label for="signup-cpw">Phone Number</label>
      <input id="signup-cpw" type="text" name="phone" autocomplete="off" required = "required"/> 
      <div style = "float: left;">
        <label for="signup-cpw">Gender</label>
        <input id="signup-cpw" type="text" name="gender" autocomplete="off" style = "width: 200px;" required = "required"/>
        <label for="signup-cpw">Age</label>
        <input id="signup-cpw" type="text" name="age" autocomplete="off" style = "width: 200px;" required = "required"/>
      </div>
      
      <div style = "float: right;">
        <label for="signup-cpw">Train Number</label>
        <input id="signup-cpw" type="text" name="train_number" autocomplete="off" style = "width: 200px;" required = "required"/>
        <label for="signup-cpw">Train Name</label>
        <input id="signup-cpw" type="text" name="train_name" autocomplete="off" required = "required"/>
        <label for="Date of Journey">Date of Journey</label>
        <input type="date" id="birthday" name="journey_date" required = "required"> 
      </div>
      <button class="btn btn-outline submit-btn" style = "color: blue;"><span>Book</span></button>
    </form>
  </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="js/script1.js"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>