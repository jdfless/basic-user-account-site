<?php ini_set('display_errors', 'On');
session_start();

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","flessnej-db","R096iQvGYroJUKhJ","flessnej-db");
if (!$mysqli || $mysqli->connect_errno){
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$logCheck = $mysqli->prepare("SELECT username, password FROM login WHERE username=? AND password=?");
$logCheck->bind_param("ss", $_POST['username'], $_POST['password']);
$logCheck->execute();

if($logCheck->fetch()){
	$_SESSION['valid'] = 'true';
	$_SESSION['username'] = $_POST['username'];
	unset($_SESSION['invalid']);
	echo 'validCred';
	die();
}

else{
	$_SESSION['invalid'] = 'true';
	echo 'Invalid credentials';
	die();
}


$mysqli->close();

?>

