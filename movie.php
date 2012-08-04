
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
<title>EagleVideo: Movie Details</title>
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

$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone");
if ($dbconn == null) {
    echo "Could not connect to the database";
	pg_close($dbconn);
    return;
    }

$mid = $_GET["id"];
if ($mid == null) {
	echo "You need to supply a movie id.";
	pg_close($dbconn);
	return;
}


//get title & release year
$query = "SELECT title, releaseyear, rating, runningtime from movie m where mid = " . $mid;
$result = pg_query($dbconn, $query);
$row = pg_fetch_array($result);
if ($row == null) {
	echo "Error: Unknown movie id.";
	pg_close($dbconn);
	return;
}
$title = $row["title"];
$year  = $row["releaseyear"];
?>

<?php pg_free_result($result); ?>

<p class="emphasis"> <?php echo $title?>, <?php echo $year ?> </p>


<?php
//get director name
$query = "Select dname from director d, moviedirector b, movie m where d.did = b.directorid and b.movieid = m.mid and m.mid = " . $mid;
$result = pg_query($dbconn, $query);
$row = pg_fetch_array($result);
if ($row == null) {
	echo "";
	return;
}

$director = $row["dname"];
?>
<?php pg_free_result($result); ?>

<p class="emphasis" style="font-size:18px"> <?php echo $director ?> </p>

<h4 align = center>
<?php
	echo "<a href=addtocart2.php?id=" . $mid . ">" . "Add to Cart</a> </td> </tr>";
?>
 </h4>


<table border=2 align=center cellpadding=3>
<tr><th><b>Genre</b></th></tr>

<?php
//get genre
$query = "select genre from genre where movieid = " . $mid . "order by genre";
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());

while($row = pg_fetch_array($result)) {
	$genre   = $row["genre"];
	echo "<tr><td align=center>" . $genre . "</td></tr>";
}
pg_free_result($result);
?>
</table>


<br>

<table border=2 align=center cellpadding=3>
<tr><th style=><b>Actor</b></th><th><b>Role</b></th></tr>
<?php
//get actors and roles played
$query = "select a.aid, a.aname, r.rname from actor a, roleplayed r where a.aid = r.actorid and r.movieid = " .
$mid . "order by a.aname";
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());

while($row = pg_fetch_array($result)) {
	$aid   = $row["aid"];
	$actor = $row["aname"];
	$role  = $row["rname"];
	echo "<tr><td style=\"padding:2px\"><a href=showactor2.php?id=" . $aid . ">" . $actor . "</a></td><td align=center>" . $role . "</td></tr>";
}
pg_free_result($result);
pg_close($dbconn);
?>
</table>









</div>
<div class="right-content">
	<?php echo $create; ?>
	<br><br>
	<div class="rightbar">
  		<a href="addtocart2.php" class="a navlink">Shopping Cart</a></div>
	<table border="2" cellpadding="3" style="background:#a2bce6;">
	<br>
	<?php
	$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
	    or die("Could not connect: " . pg_last_error());
	// Run Query on Shopping Cart Table for everything associated with the Username
	$query = "Select * From shoppingcart5 Where custid = (select memberid from customer2 where username = '" .$username . "')";
	$result = pg_query($dbconn, $query) or die("Query3 Failed: " . pg_last_error());

	// As you fetch array, query the movie table for that ID to get title so you can spit it out on the table
	while ($row = pg_fetch_array($result)){
		$movieid = $row["movid"];
		$title2 = $row["title"];
		echo "<tr> <td><a href=movie.php?id=" . $movieid . ">- " . $title2 .
		"</a></td></tr>";
		}

	?>
	</table>
	
	<br><br>
	
	<div class="rightbar">
  		<a href="rentals.php" class="a navlink">Your Rentals</a></div>
	<table style="background:#a2bce6;">
	<?php
	$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
	    or die("Could not connect: " . pg_last_error());

	    //get custid
	    $custidquery = "Select memberid from customer2 where username = '" . $username . "'";
	$custidrun = pg_query($dbconn,$custidquery) or die ("CustID Query Failed");
	$row5 = pg_fetch_array($custidrun);
	$custid = $row5["memberid"];

		$query5 = "Select m.title From rentals r, movie m Where r.movieid = m.mid and r.memberid =" .$custid . "and r.datein is null";
	$finalresult = pg_query($dbconn, $query5) or die("Query5 Failed: " . pg_last_error());
	
	while ($row = pg_fetch_array($finalresult)){
		$title = $row["title"];
		echo "<tr><td><a href=movie.php?id=" . $movieid . ">- " . $title .
		"</a></td></tr>";
		}
	?>
	</table>

</div>
</div>
</body>