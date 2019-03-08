<?php
date_default_timezone_set('Europe/Lisbon'); 
$servername = "localhost";
$username = "acadprof_nc";
$password = "28^e6u_m*P0%";
$dbname = "acadprof_inqdemo";
$conn = new mysqli($servername, $username, $password, $dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

