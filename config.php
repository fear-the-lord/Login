<?php
    // This will be the first file of your system. 
    /* This file contains the database configuration considering that 
    we are running mysql using username "root" and password "" */

    // Define some constants 
    // For system testing
    // define('DB_SERVER', 'localhost');
    // define('DB_USERNAME', 'root');
    // define('DB_PASSWORD', '');
    // define('DB_NAME', 'login');

    // For remote server
    define('DB_SERVER', 'db4free.net');
    define('DB_USERNAME', 'trainreservation');
    define('DB_PASSWORD', 'trainreservation');
    define('DB_NAME', 'train_reserve');

    // Try connecting to the database 
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check the connection 
    if($conn == false) {
        dir('Error: Cannot connect to database');
    }
?>