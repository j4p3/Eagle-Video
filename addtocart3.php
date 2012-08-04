<?php
session_start();
$username = $_SESSION["username"];
if ($username == null) {
header("Location: notloggedinhome.html");
}
?>

<html>
<head>
  <title>Add to Cart</title>
</head>
<body>

<a href = "http://sheeta.bc.edu/~cs257e/loggedinhome.php">  Back to Home </a>
<br>
<a href = "http://sheeta.bc.edu/~cs257e/checkout.php"> Checkout </a>
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

<table border="2" cellpadding="3" Align = Center>
  <tbody>
    <tr Align = Center>
      <th>Movie Name</th>
      <th>Remove from Cart</th>
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
	"</a> </td> <td><a href=cart_delete.php?id=" . $movieid . ">Remove</a></td></tr>" ;
	}

?>

</body>
</html>