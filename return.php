<html>
<head>
  <title>Return</title>
</head>
<body>

<?php
session_start();
$username = $_SESSION["username"];
if ($username == null) {
header("Location: notloggedinhome.html");
}

$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
    or die("Could not connect: " . pg_last_error());
// Find Customer ID
$custidquery = "Select memberid from customer2 where username = '" . $username . "'";
$custidrun = pg_query($dbconn,$custidquery) or die ("CustID Query Failed");
$row5 = pg_fetch_array($custidrun);
$custid = $row5["memberid"];

$movieid = $_GET["id"];

$updaterental = "Update rentals Set datein = current_date Where movieid = " .$movieid . " and memberid =" .$custid;
$updaterentalrun = pg_query($dbconn, $updaterental) or die("Rental Update Failed: " . pg_last_error());

$updateinventory = "Update movie Set inventory = (inventory + 1) Where mid = " . $movieid;
pg_query($dbconn, $updateinventory) or die ("Inventory Update Failed");

header("Location: rentals.php");

?>

</body>
</html>
