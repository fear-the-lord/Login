<?php 
  require_once "config.php";
  $name = $email = $phone = $to = $from = $gender = $age = $journey_date = $pnr = "";

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $pnr = trim($_POST['pnr']);
    $sql = "SELECT * FROM tickets WHERE pnr_number = $pnr";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    $email = $row["email"];
    $to = $row["to_station"];
    $from = $row["from_station"];
    $phone = $row["phone"];
    $gender = $row["gender"];
    $age = $row["age"];
    $journey_date = $row["journey_date"];
    $pnr = $row["pnr_number"];
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
    <title>View Ticket</title>
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
            <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            <a class="nav-link" href="register.php">Register</a>
            <a class="nav-link" href="https://fear-the-lord.github.io/Souvik-Portfolio-Website/">Contact Us</a>
            <!-- <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->
            </div>
        </div>
    </nav>

   
    <div class="login" id = "pnr_enter">
        <h1>View Ticket</h1>
            <form method="post" action = "">
                <input type="text" name="pnr" placeholder="Enter 6 digit PNR" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large" onclick = "myFunction()">View Ticket</button>
            </form>
    </div>

    <div class = "login" style = "top: 25%; display: none;" id = "ticket_display">

        <label for = "name" style = "color: white;">Name</label>
        <input type="text" name="name" placeholder="" value = "<?php echo $name;?>"/>
        <label for = "name" style = "color: white;">Email</label>
        <input type="text" name="email" placeholder="" value = "<?php echo $email;?>"/>
        <label for = "name" style = "color: white;">Phone Number</label>
        <input type="text" name="phone" placeholder="" value = "<?php echo $phone;?>"/>
        <label for = "name" style = "color: white;">To</label>
        <input type="text" name="to" placeholder="" value = "<?php echo $to;?>"/>
        <label for = "name" style = "color: white;">From</label>
        <input type="text" name="from" placeholder="" value = "<?php echo $from;?>"/>
        <label for = "name" style = "color: white;">Gender</label>
        <input type="text" name="gender" placeholder="" value = "<?php echo $gender;?>"/>
        <label for = "name" style = "color: white;">Age</label>
        <input type="text" name="age" placeholder="" value = "<?php echo $age;?>"/>
        <label for = "name" style = "color: white;">Date of Journey</label>
        <input type="text" name="journey_date" placeholder="" value = "<?php echo $journey_date;?>"/>
        <label for = "name" style = "color: white;">PNR Number</label>
        <input type="text" name="pnr" placeholder="" value = "<?php echo $pnr;?>"/>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
      function myFunction() {
        var x = document.getElementById("ticket_display");
        var y = document.getElementById("pnr_enter");
        if (x.style.display === "none") {
          x.style.display = "block";
          y.style.display = "none";
        } else {
          x.style.display = "none";
          y.style.display = "block";
        }
      }
    </script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>