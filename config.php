<?php
    // This will be the first file of your system. 
    /* This file contains the database configuration considering that 
    we are running mysql using username "root" and password "" */

    // Define some constants 
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'login');

    // Try connecting to the database 
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check the connection 
    if($conn == false) {
        dir('Error: Cannot connect to database');
    }
?>