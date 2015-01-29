<?php
ini_set('display_errors', 1);

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","flessnej-db","R096iQvGYroJUKhJ","flessnej-db");
if (!$mysqli || $mysqli->connect_errno){
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$dupCheck = $mysqli->prepare("SELECT username FROM login WHERE username=?");
if(!$dupCheck->bind_param("s", $_POST['username']))
	echo 'Couldnt Bind';
if(!$dupCheck->execute())
	echo 'Couldnt execute';

if($dupCheck->fetch()){
	echo "Sorry. Username '" . $_POST['username'] . "' already exists.";
	die();
}

else{
	$dupCheck->close();
	$create = $mysqli->prepare("INSERT INTO login(username, password) VALUES (?,?)");
	$create->bind_param("ss", $_POST['username'], $_POST['password']);
	$create->execute();
	$create->close();
	echo "Account created! Click above to go log-in.";
	die();
}

$mysqli->close();
