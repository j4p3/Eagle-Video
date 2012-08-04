<?php
	session_start();
	$username = $_SESSION["username"];
	if ($username == null) {
		$header = "<form method=post action=\"login.php\">
			<input type=text value=Username name = \"nm\" size=10>
			<input type=text value=Password name = \"pwd\" size=10>
			<br>
			<input type=submit value=LOGIN id=\"submit_btn\" class=\"btn green\"></form>";
		$create = "Not a member yet?  Create an account today! <br><div class=\"navbar\"><a href=\"sign-up.php\" class=\"a navlink\">Create Account</a></div><br>";
	} else {
		$header = $username . "<br><div class=\"navbar\"><a href=\"accountinfoview.php\" class=\"a navlink\">Account</a></div><div class=\"navbar\"><a href=\"logout.php\" class=\"a navlink\">Logout</a></div>";
	}
	
	$int=rand(1,6);
	if ($int<5) {
		$logo="id=\"logo\" href=\"http://sheeta.bc.edu/~cs257e/\" title=\"Eagle Video\"><img src=\"http://sheeta.bc.edu/~cs257e/img/EV_0.png\" alt=\"Ooh, Aah.\">";
	} else if ($int==5) {
		$logo="id=\"logo\" href=\"http://sheeta.bc.edu/~cs257e/\" title=\"Eagle Video\"><img src=\"http://sheeta.bc.edu/~cs257e/img/EV_1.png\" alt=\"Ooh, Aah.\">";
	} else {
		$logo="id=\"logo\" href=\"http://sheeta.bc.edu/~cs257e/\" title=\"Eagle Video\"><img src=\"http://sheeta.bc.edu/~cs257e/img/EV_2.png\" alt=\"Ooh, Aah.\">";
	}

	$status=$_GET["status"];
	if ($status == "logerr") {
		$message = "<p class=\"emphasis\" style=\"color:#a30008;\">User Info not recognized. Try again?</p><br>";
	}
?>

<html>
<head>
<title>Account Info</title>
<LINK rel=stylesheet href="style.css" type="text/css" media=screen>
<script language="javascript" src="button.js"></script>
</head>
<body class="background">

	<div class="container">
		<div id="header" class="logos">
			<a <?php echo $logo; ?>
			<img src="http://sheeta.bc.edu/~cs257e/img/EagleVideo_logo.png">
			</a>
		</div>
		<div id="toptext" class="user">
			<?php echo $header;?>
		</div>
		<div id="searchbar" class="search">
			<form method=get action="search_results.php">
			<input type=text name="search" style="padding:4px;">
			<select name="searchtype" style="padding:4px;"> 
			   <option value="genre">Genre</option> 
			   <option value="actor">Actor</option> 
			   <option value="title">Movie</option> 
			</select>
			<input type=submit value="SEARCH" id="submit_btn" class="btn blue" > 
			</form>
		</div>
	</div>
	<div class="content">
		<div class="left-content">












<?php
$rawlastname = $_POST["lastname"];
$rawfirstname = $_POST["firstname"];
$rawcity = $_POST["city"];
$rawstate = $_POST["state"];
$rawzipcode = $_POST["zipcode"];
$rawphonenumber = $_POST["phonenumber"];
$rawemail = $_POST["email"];
$rawusername = $_POST["username"];
$rawpwd = $_POST["pwd"];

$lastname = pg_escape_string("$rawlastname");
$firstname = pg_escape_string("$rawfirstname");
$city = pg_escape_string("$rawcity");
$state = pg_escape_string("$rawstate");
$zipcode = pg_escape_string("$rawzipcode");
$phonenumber = pg_escape_string("$rawphonenumber");
$email = pg_escape_string("$rawemail");
$username = pg_escape_string("$rawusername");
$pwd = pg_escape_string("$rawpwd");

$_SESSION["username"] = $username;


if ($lastname == null or $firstname == null or $state == null or $city == null or $zipcode == null or $phonenumber == null or 
$email == null or $username==null or $pwd == null) {
header("Location:accountinfoedit.php");
}

$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone");
if ($dbconn == null) {
    echo "Could not connect to the database";
	pg_close($dbconn);
    return; 
    }

$query = "DELETE from customer2 where username = '" . $pusername . "'";
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());
pg_free_result($result);

$query = "INSERT INTO customer2 (memberid, lastname, firstname, city, state, zipcode, 
phonenumber, email, username, pwd)
VALUES (nextval('SIDsequence'), '" . $lastname . "', '" . $firstname . "', '" . 
$city . "', '" . $state . "', " . $zipcode . ", " . $phonenumber . ", '" . 
$email . "', '" . $username . "', '" . $pwd . "')";
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());

pg_free_result($result);
pg_close($dbconn);

?>

<html>
<head>  <title>Account Information Update</title>  </head>

<body>

Thank you, <?php echo $firstname; ?>! Your account information has been updated.

<P>

Head on back to our <a href="http://sheeta.bc.edu/~cs257e/"> Home Screen</a>  
and check out our movie selection!












		</div>
		<div class="right-content">
			<?php echo $create; ?>
			<br><br>
			Eagle Video will never reveal your private user information for any reason.  If you have any concerns, check our Privacy Policy or call a Service Representative.

		</div>
	</div>
</body>

