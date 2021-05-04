<?php
session_start();
session_destroy();
if (isset($_COOKIE['user']) and isset($_COOKIE['parola'])) {
    $email = $_COOKIE['user'];
    $parola = $_COOKIE['parola'];
    setcookie('user', $_POST["user"], time() - 1);
    setcookie('parola', $_POST["parola"], time() - 1);
}
header("location:index.php");
