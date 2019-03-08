<?php
include '../userauth.class.php';
$auth = new UserAuthentication();

$auth->logOut();

header("Location:index.php");
?>
