<?php
session_start();
$username = $_SESSION["username"];
if ($username == null) {
header("Location: notloggedinhome.html");
}
?>


<?php
$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone")
    or die("Could not connect: " . pg_last_error());
$username = $_SESSION["username"];

$id = $_GET["id"];

$custidquery = "Select memberid from customer2 where username = '" . $username . "'";
$custidrun = pg_query($dbconn,$custidquery) or die ("CustID Query Failed");
$row5 = pg_fetch_array($custidrun);
$custid = $row5["memberid"];

$delete = "delete from shoppingcart5 where custid = " . $custid . " and movid = " . $id;
pg_query($dbconn, $delete);

header("Location:addtocart2.php");

?>

</body>
</html>