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
			<H1 align=center> New User Sign-Up </H1>
			<P>

			Please take a moment to fill out your information:
			<P>

			<form method=post action="signup.php">

			First Name: <input type=text name="firstname" size=10>
			<P>

			Last Name: <input type=text name="lastname" size=10>
			<P>

			City: <input type=text name="city" size=10>
			<P>

			State: <input type=text name="state" size=10>
			<P>

			Zip Code: <input type=text name="zipcode" size=8>
			<P>

			Phone Number: <input type=text name="phonenumber" size=12>
			<P>

			Email: <input type=text name="email" size=15>
			<P>

			Password: <input type=text name="pwd" size=15>
			<P>

			<input type=submit value = "Create Account!">
			</form>

			<br><br>
			
		</div>
		<div class="right-content">
			With Eagle Video, you can rent a movie for as long as you like.  Eagles in the kiosk: ooh, aah.
		</div>
	</div>
</body>