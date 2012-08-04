<html>
<head>
<?php
	session_start();
	$username = $_SESSION["username"];
	if ($username == null) {
		$header = "<form method=post action=\"login.php\">
			<input type=text value=Username name = \"nm\" size=10>
			<input type=text value=Password name = \"pwd\" size=10>
			<br>
			<input type=submit value=LOGIN id=\"submit_btn\" class=\"btn green\"></form>";
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
?>
<LINK REL=StyleSheet href="style.css" TYPE="text/css" MEDIA=screen>
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
			<input type=text name="search">
			<select name="searchtype"> 
			   <option value="genre">Genre</option> 
			   <option value="actor">Actor</option> 
			   <option value="title">Movie</option> 
			</select>
			<input type=submit value="SEARCH" id="submit_btn" class="btn blue"> 
			</form>
		</div>
	</div>
	<div class="content">
		<div class="left-content">
		
			<?php
			session_start();
			$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
				    or die("Could not connect: " . pg_last_error());

			$rawlastname = $_POST["lastname"];
			$rawfirstname = $_POST["firstname"];
			$rawcity = $_POST["city"];
			$rawstate = $_POST["state"];
			$rawzipcode = $_POST["zipcode"];
			$rawphonenumber = $_POST["phonenumber"];
			$rawemail = $_POST["email"];
			$rawusername = $_POST["email"];
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


			//check to make sure all the fields are filled in
			//PROBLEM HERE--
			if ($lastname == null or $firstname == null or $state == null or $city == null or $zipcode == null 
			or $phonenumber == null or 
			$email == null or $username==null or $pwd == null) {
			echo "Error: Please press the back button on your browser and make sure all fields are filled in.";
				return;
			} else {
			$_SESSION["username"] = $username;
			}

			//check to make sure that username isn't already signed up
			$query = "select * from customer2 where username = '" . $username . "'" ;
			$result = pg_query($dbconn, $query);
			$row = pg_fetch_array($result);
			if ($row <> null) {
				echo "Error: We already have a user with this username. Please press the back button on your 
				browser and retry with another username.";
				pg_close($dbconn);
				return;
			}
				pg_free_result($result);

			//check to make sure zip code is only 5 digits
			$num_char=strlen($zipcode);
			if($num_char > 5 or $num_char < 5) {die("Please press the back button on your browser and make sure the zip code you entered
			is only 5 digits.");
			}


			//check to make sure password is at least 8 characters
			$num_char=0;
			$num_char=strlen($pwd);
			if($num_char < 8) {die("Please press the back button on your browser and make sure that 
			your password is at least 8 characters in length.");
			}


			//make insertion into customer2 table if the username doesn't already exist
			$query = "INSERT INTO customer2 (memberid, lastname, firstname, city, state, zipcode, 
			phonenumber, email, username, pwd)
			VALUES (nextval('SIDsequence'), '" . $lastname . "', '" . $firstname . "', '" . 
			$city . "', '" . $state . "', " . $zipcode . ", " . $phonenumber . ", '" . 
			$email . "', '" . $email . "', '" . $pwd . "')";
			$result = pg_query($dbconn, $query) or die("Error: Please press the back button on your 
			browser and make sure that your input for State is only two charcters, and that your telephone number/ zip code
			are also in all numbers.");

			pg_free_result($result);
			pg_close($dbconn);
			?>


			<p>Thank you for signing up, <?php echo $firstname; ?>! A conformation email has been sent to you 
			at: <?php echo $email; ?>.
			</p>
			<p>
			*For now, your username is your email address.  If you would like to change it to 
			something else, feel free to head on over to your 
			<a href="http://sheeta.bc.edu/~cs257e/accountinfoview.php"> Account Page</a> 
			and change it-or any of your information- at any time.
			</p>


			<br><br>
			<form method=get action="search_results.php" style="padding-top:8px;">
			Search for movies, genres or actors<br>
			<select name="searchtype">
			   <option value="genre">Genre</option>
			   <option value="actor">Actor Name</option>
			   <option value="title">Movie Title</option>
			</select>
			<input left-padding="3px" type=text name="search" size=10>
			<br><br>
			<input type=submit value="SEARCH" id="submit_btn" class="btn blue" style="padding-left:8px;"></form>
			</form>
		</div>
		<div class="right-content">
			Eagle Video has been servicing New Englanders since 1986 - long before Flutie even threw The Pass.  Eagles, first down.
		</div>
	</div>
</body>