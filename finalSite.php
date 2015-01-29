<?php ini_set('display_errors', 'On'); 
session_start();
if(!isset($_SESSION['valid']) || empty($_SESSION['valid']))
	header('Location: login.php');
else
	unset($_SESSION['invalid']);

$mysqli = new mysqli("oniddb.cws.oregonstate.edu","flessnej-db","R096iQvGYroJUKhJ","flessnej-db");
if (!$mysqli || $mysqli->connect_errno){
	echo "Connection error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if(isset($_POST['teamSubmit'])){
	$setFav = $mysqli->prepare("UPDATE login SET fav=? WHERE username=?");
	$setFav->bind_param("is", $_POST['favCountry'], $_SESSION['username']);
	$setFav->execute();
	$setFav->close();
}

$getFav = $mysqli->prepare("SELECT fav FROM login WHERE username=?");
$getFav->bind_param("s", $_SESSION['username']);
$getFav->execute();
$getFav->bind_result($userFav);
$getFav->fetch();
$getFav->close();

$output = 'Select a country to see all of their Group Stage matches. Your country will be saved in your account.';

//here we output an iframe of all the group stage matches of the selected favorite country.  matches are shown for the whole group, not just the country.
if($userFav == 6 || $userFav == 7 || $userFav == 12 || $userFav == 23)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_A#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 3 || $userFav == 8 || $userFav == 24 || $userFav == 29)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_B#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 9 || $userFav == 11 || $userFav == 18 || $userFav == 22)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_C#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 10 || $userFav == 14 || $userFav == 21 || $userFav == 32)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_D#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 13 || $userFav == 15 || $userFav == 19 || $userFav == 30)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_E#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 2 || $userFav == 5 || $userFav == 20 || $userFav == 25)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_F#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 16 || $userFav == 17 || $userFav == 26 || $userFav == 31)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_G#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";
elseif($userFav == 1 || $userFav == 4 || $userFav == 27 || $userFav == 28)
	$output = "<iframe src='http://en.wikipedia.org/wiki/2014_FIFA_World_Cup_Group_H#Matches' style='border-style: none; width: 100%; height: 550px;'></iframe>";

$loginInfo = "Signed in as: " . $_SESSION['username'];
?>
<!DOCTYPE html>
<html><head><title>Final Site</title>
<link rel="stylesheet" type="text/css" href="finalSite.css">
<meta charset="UTF-8">
<script src="jQuery/jQuery2.1.0.js"></script>
<script src="jQuery/form-validator/jquery.form-validator.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
</head><body>
<h1>World Cup 2014 - Brazil!</h1>

<div class="logout">
	<a href="logout.php">Sign Out</a>
</div>

<div class="formDiv">
<form method="POST">
<select id="teamSelect" name="favCountry">
	<option value="0">Select country...</option>
	<option value="1">Algeria</option>
	<option value="2">Argentina</option>
	<option value="3">Australia</option>
	<option value="4">Belgium</option>
	<option value="5">Bosnia and Herzegovina</option>
	<option value="6">Brazil</option>
	<option value="7">Cameroon</option>
	<option value="8">Chile</option>
	<option value="9">Colombia</option>
	<option value="10">Costa Rica</option>
	<option value="11">Côte d'Ivoire</option>
	<option value="12">Croatia</option>
	<option value="13">Ecuador</option>
	<option value="14">England</option>
	<option value="15">France</option>
	<option value="16">Germany</option>
	<option value="17">Ghana</option>
	<option value="18">Greece</option>
	<option value="19">Honduras</option>
	<option value="20">Iran</option>
	<option value="21">Italy</option>
	<option value="22">Japan</option>
	<option value="23">Mexico</option>
	<option value="24">Netherlands</option>
	<option value="25">Nigeria</option>
	<option value="26">Portugal</option>
	<option value="27">Russia</option>
	<option value="28">South Korea</option>
	<option value="29">Spain</option>
	<option value="30">Switzerland</option>
	<option value="31">United States</option>
	<option value="32">Uruguay</option>
</select>
<input type="submit" name="teamSubmit" value="Select">
</form>
<p>Below, view all the matches in your countries' group stage.</p>
</div>

<div class="output"><?php echo $output ?></div>

<div id="myCountry">
	<button onclick="get_location()">Is the country I'm in now in the World Cup?</button>
	<script>
	//here we get the location of the user using geolocator then use
	//the google api to reverse geolocate their country
	//this can then be compared to the world cup countries to let the user
	//know if their country is in the world cup.
	function get_location() 
	{
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(output, handle_error);
		}
		else{
			document.getElementById("locInfo").innerHTML = "Geolocation is not available on this browser";
		}
	}

	function output(position) 
	{
	  	var lat = position.coords.latitude;
	  	var lng = position.coords.longitude;
	  	api(lat, lng);
	}

	function handle_error(err) {
	  document.getElementById("locInfo").innerHTML = "Error code = " + err.code;
	}

	function api(lat, lng){
		$apiURL = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lng
			+ "&sensor=false&key=AIzaSyBoVfooUwEuRkdIo7VuSfaE0bBzjQD9mjo";
		$.getJSON($apiURL, function(data){
			var yourLoc = data.results[11].formatted_address; //finds the country
			if(yourLoc == "United States") //note: for the sake of clarity I have not included the 32 way if conditional here to test all WC countries.
				document.getElementById("locInfo").innerHTML = "You are located in: <b>" + yourLoc + "</b> - a World Cup country!";
			else
				document.getElementById("locInfo").innerHTML = "Sorry, " + yourLoc + " didn't qualify for the 2014 World Cup.";
		});
	}
	</script>
	<p id="locInfo"></p> 
</div>

<div id="loginInfo">
	<?php echo $loginInfo ?>
</div>


</body>
</html>