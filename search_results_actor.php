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
<title>EagleVideo: Search Results</title>
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

$rawsearch = $_GET["search"];
$searchstring = pg_escape_string("$rawsearch");

if($searchstring == null) {
	echo "You did not type anything in the Search Box.";
	pg_close($dbconn);
	return;
    }

?>



<p class="emphasis">Search Results</p>

<table border="2" cellpadding="3" Align = Center>
  <tbody>
    <tr Align = Center>
      <th>Actors</th>
      <th>Roles Played</th>
    </tr>

<?php


//ACTOR SEARCH
$query_actor = "select distinct a.aname, a.aid, count(*) from movie m, actor a, roleplayed r where m.mid = r.movieid 
and r.actorid = a.aid and a.aname LIKE '%" . $searchstring . "%' group by a.aname, a.aid order by count desc";


$result = pg_query($dbconn, $query_actor) or die("Query failed: " . pg_last_error());

while($row = pg_fetch_array($result)) {
	$aid   = $row["aid"];
	$actor = $row["aname"];
	$num   = $row["count"];
	echo "<tr><td align=center><a href=showactor2.php?id=" . $aid . ">" . $actor . "</a></td><td align=center>" . 
	$num . "</td></tr>";
}

pg_free_result($result);
pg_close($dbconn);

?>
  </tbody>
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