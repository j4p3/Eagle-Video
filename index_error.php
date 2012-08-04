<html>
<head>
<?php
	session_start();
	$username = $_SESSION["username"];
	if ($username == null) {
		$header = "<form method=post action=\"login.php\">
			<input type=text value=Username name = \"nm\" size=10>
			<input type=text value=Password name = \"pwd\" size=10>
			<input type=submit value=LOGIN id=\"submit_btn\" class=\"btn green\"></form>";
	} else {
		$header = $username . "<br><div class=\"navbar\"><a href=\"accountinfoview.php\" class=\"a navlink\">Account</a></div><div class=\"navbar\"><a href=\"logout.php\" class=\"a navlink\">Logout</a></div>";
	}
?>
<LINK REL=StyleSheet href="style.css" TYPE="text/css" MEDIA=screen>
<script language="javascript" src="button.js"></script>
</head>
<body class="background">
	<div class="container">
		<div id="header" class="logos">
			<!	PHP here should sequentially change logo>
			<a id="logo" href="http://sheeta.bc.edu/~cs257e/loggedinhome.php" title="Eagle Video">
				<img src="http://sheeta.bc.edu/~cs257e/img/EV_logo.png" alt="Ooh, Aah."><img src="http://sheeta.bc.edu/~cs257e/img/EagleVideo_logo.png">
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
			<p class="emphasis">User info not recognized. Try again?</p><br><br>
			Through this kiosk, you can access over 24,000 movies in less than 30 seconds.  Enter a search term or create an account to get started!<br><br>
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
			<?php
			$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
			    or die("Could not connect: " . pg_last_error());
			$username = $_SESSION["username"];

			$id = $_GET["id"];

			if ($id <> null) {
			// Insert the Movie into the Cart table with an identifying element (Username)
			$add = "Insert into shoppingcart5 (custid, movid, title)
			Values((Select memberid From customer2 Where username = '". $username . "' ), '" .$id. "' ,
			(Select title From Movie m Where mid = '" . $id . "'))";
			pg_query($dbconn, $add) or die ("You already have that movie in your shopping cart.");
			}
			?>

			<table border="2" cellpadding="3">
			    <tr style="padding-left:3px;">
			      <strong>Shopping Cart</strong>
			    </tr>
			<?php
			// Run Query on Shopping Cart Table for everything associated with the Username
			$query = "Select * From shoppingcart5 Where custid = (select memberid from customer2 where username = '" .$username . "')";
			$result = pg_query($dbconn, $query) or die("Query3 Failed: " . pg_last_error());

			// As you fetch array, query the movie table for that ID to get title so you can spit it out on the table
			while ($row = pg_fetch_array($result)){
				$movieid = $row["movid"];
				$title2 = $row["title"];
				echo "<tr Align = Center> <td><a href=movie.php?id=" . $movieid . ">" . $title2 .
				"</a> </td></tr>" ;
				}

			?>
			</table>
			<div class="checkout">
				<form method=get action="checkout.php">
					<input type=submit value="CHECKOUT" id="submit_btn" class="btn blue"></form>
			</div>
		</div>
	</div>
</body>