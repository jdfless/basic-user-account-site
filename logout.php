<?php ini_set('display_errors', 'On'); 
session_start();

unset($_SESSION['valid']);
header('Location: login.php');