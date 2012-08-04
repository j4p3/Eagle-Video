<?php
	session_start();
	$username = $_SESSION["username"];
	if ($username <> 'ADMIN') {
	header("Location:index.php");
	}
	
	$user = $_GET["id"];

	$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone");
	if ($dbconn == null) {
	    echo "Could not connect to the database";
		pg_close($dbconn);
	    return; 
	}

	$query = "select m.mid, m.title, m.releaseyear
	from rentals as r, movie as m 
	where r.movieid = m.mid
	and r.memberid = " . $user;
	$result = pg_query($dbconn, $query);
	$row = pg_fetch_array($result);
	if ($row == null) {
		echo "Error: No Rentals.";
		pg_close($dbconn);
		return;
	}
?>

	<html>
	<head>
	<title>Admin Home</title>
	</head>
	
<body>
<h1 align = center> Admin Center </h1>
<P align = center>
<a href="logout.php">Admin Log Out</a>
<br>
<a href="index.php">Eagle Video Home</a>
</P>
<a href="admin_customer_list.php">Customer List</a>
<br>
<a href="admin_inventory.html">Manage Movie Inventory</a>
<br>
<a href="rentalsrentnumber.php"> Rental Mangagment</a>


<div style="font-size:18pt; align:center; font-family:Helvetica; padding-top:30px;">
	Rentals for User <?php echo $user;?>
	<table style="padding:2px">
	<?php

while ($row = pg_fetch_array($result)) {
		$mid = $row["mid"];
		$title = $row["title"];
		$releaseyear = $row["releaseyear"];
		echo "<tr><td><a href=movie.php?id=" . $mid . ">" . $title . "</a></td></tr>";
}

	pg_free_result($result);
	pg_close($dbconn);
	?>
</table>
</body>
</html>