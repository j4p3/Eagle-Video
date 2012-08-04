<?php
	session_start();
	$rawuser = $_POST["nm"];
	$rawpwd  = $_POST["pwd"];
	$user = pg_escape_string($rawuser);
	$pwd  = pg_escape_string($rawpwd);

	$dbconn = pg_connect("host=postgres09.bc.edu dbname=Movies user=postgres password=swagzone");
	if ($dbconn == null) {
	    echo "Could not connect to the database";
		pg_close($dbconn);
	    return;
}

	$query = "select username, pwd from customer2 where username = '" . $user . "' and pwd = '" . $pwd . "'";
	$result = pg_query($dbconn, $query) or die("Query failed: " . pg_last_error());
	$row = pg_fetch_array($result);
	pg_free_result($result);
	pg_close($dbconn);

	if ($row == null) {
		header("Location:index.php?status=logerr");
	} else {
		$_SESSION["username"] = $user;
		header("Location:index.php");
	}
?>