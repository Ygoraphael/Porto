<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$curso = $_POST['curso'];
unset($_SESSION['caret'][$curso]);
