<?php
	session_start();
	$username = $_SESSION["username"];
	if ($username <> 'ADMIN') {
	header("Location:index.php");
	}
	?>

<html>
<head>
<title>Admin Home</title>
</head>
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

</html>