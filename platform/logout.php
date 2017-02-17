<?php session_start();
unset($_SESSION['project_login']);
header('Location: login.php');
