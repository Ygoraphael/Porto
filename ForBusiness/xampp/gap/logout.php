<?php 
    require("db2.php"); 
    unset($_SESSION['user']);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>