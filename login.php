<?php ini_set('display_errors', 'On');
session_start();
?>

<!DOCTYPE html>
<html><head><title>Login</title>
<link rel="stylesheet" type="text/css" href="login.css">
<meta charset="UTF-8">
<script src="jQuery/jQuery2.1.0.js"></script>
<script src="jQuery/form-validator/jquery.form-validator.js"></script>
</head><body>

<div class="loginForm">
<form id="logID" method="POST">
<h4><u>login</u></h4>
<p>username:<input name="username" data-validation="length alphanumeric"
	data-validation-length="4-20" data-validation-error-msg="Invalid Username"></p>
<p>password:<input type="password" name="password" data-validation="length"
	data-validation-length="min4" data-validation-error-msg="Incorrect password"></p>
<p class="subButton"><input type="submit" name="loginSubmit" value= "login"></p>
<a href="createAcct.html" id="link">create account.</a>
</form>

<script>
$.validate({
	modules: 'security'
});
</script>

<div class="output" id="output"></div>
</div>

<script>
$("#logID").submit(function(event){
	event.preventDefault();
	$.post(
		"loginServer.php",
		$("#logID").serialize(),
		function(data){
			if(data === 'validCred')
				window.location.href = 'finalSite.php';
			else {
				document.getElementById('output').innerHTML = data;
				document.getElementById('logID').reset();
			}
		}
	);
});
</script>

</body>
</html>