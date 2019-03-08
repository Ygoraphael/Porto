<?php
include '../userauth.class.php';
$auth = new UserAuthentication();

if(isset($_POST['login']) && isset($_POST['pass'])) {
    if(!$auth->logIn($_POST['login'], $_POST['pass'])) {
        header("Location:index.php?login=error");
    }
    else {
        header("Location:index.php");
    }
}
else {
    header("Location:index.php?login=error");
}
?>
