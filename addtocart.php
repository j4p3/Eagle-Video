<html>
<head>
  <title>Add to Cart</title>
</head>
<body>

<table border="2" cellpadding="3" Align = Center>
  <tbody>
    <tr Align = Center>
      <th>Movie Name</th>
      <th>Rental Time</th>
    </tr>


    <?php
$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone");
if ($dbconn == null) {
    echo "Could not connect to the database";
	pg_close($dbconn);
    return; 
    }
   

$create = "Create Table Cart1 (movieid int, title varchar (50), Rtime int, Contraint movieid_key Primary Key (movieid),
Constraint movieid_fkey Foreign Key (movieid) References movie (mid) On update cascade On delete cascade, 
Constraint title_fkey Foreign Key (title) References movie (title) On update cascade On delete cascade;";
pg_query($dbconn, $create) or die("Create failed: " . pg_last_error());

$id = $_GET["id"];

$query = "Select mid, title From Movie, Where mid = " . $id ;
pg_query($dbconn, $query) or die("Query Failed: " . pg_last_error());

$add = "Insert into Cart1 (Mid, title) Select mid, title From Movie, Where mid = " . $id;
pg_query($dbconn, $add) or die("Query Failed: " . pg_last_error());

$query = "Select * From Cart1";
$result = pg_query($dbconn, $query) or die("Query Failed: " . pg_last_error());

while ($row = pg_fetch_array($result)){
	$title = $row["title"];
	$RTime  = $row["Rtime"];
	echo "<tr Align = Center> <td><a href=movie.php?id=" . $mid . ">" . $title . 
	"</a> </td><td>" . $RTime . "</td>" ;
	
}
?>

</tbody>
</table>

<p>
This is the mid of the movie that the user selected from their search <?php echo $id; ?> 

</body>
</html>