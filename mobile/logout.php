<?php session_start();
unset($_SESSION['mobile_login']);
header('Location: login.php');
