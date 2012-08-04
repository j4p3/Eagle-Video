<html>
<head>
  <title>Movie Info</title>
</head>
<body>

<?php
// First, get the title and release year

$dbconn = pg_connect("host=postgres01.bc.edu dbname=movies user=guest password=db")
    or die("Could not connect: " . pg_last_error());

$mid = $_GET["id"];
$query = "SELECT title, releaseyear, rating, runningtime from movie where mid = " . $mid;
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());
$row = pg_fetch_array($result);
$title = $row["title"];
$year  = $row["releaseyear"];
?>

<h2 align=center>
    <?php echo $title; ?> (<?php echo $year; ?>)
</h2>
<?php pg_free_result($result); ?>


<table border=1 align=center>
<tr><th>Actor</th><th>Role</th></tr>

<?php
// Then get the actor information for that movie

$query = "select a.aname, r.rname from actor a, roleplayed r where a.aid = r.actorid and r.movieid = " . $mid;
$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());

while($row = pg_fetch_array($result)) {
	$actor = $row["aname"];
	$role  = $row["rname"];
	echo "<tr><td align=center>" . $actor . "</td><td align=center>" . $role . "</td></tr>";
}
pg_free_result($result);
pg_close($dbconn);
?>

</table>
</body>
</html>
