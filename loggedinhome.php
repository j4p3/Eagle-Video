<?php
session_start();
$username = $_SESSION["username"];
if ($username == null) {
	header("Location: notloggedinhome.html");
}
?>

<html>
<head>
  <title>Welcome to Eagle Video of New England</title>
</head>
<body>
<h1 align="center">Eagle Video of New England</h1>
<br>

<DIV align="right">
<FONT COLOR="green">Welcome, <?php echo $username; ?>!</FONT>
<br>
<a href="accountinfoview.php">My Account Page</a>
<br>
<a href="addtocart2.php">Shopping Cart</a>
<br>
<a href="logout.php">Logout</a>
</DIV>

<br>
<form method=get action="search_results.php">
Select an option to search by and then type in your search:
<select name="searchtype">
   <option value="genre">Genre</option>
   <option value="actor">Actor Name</option>
   <option value="title">Movie Title</option>
</select> <br>

<input type=text name = "search" size=10>
<br>
<input type=submit>
</form>
<P>
*Please be sure to enter in your search with proper capitalization
<br>
(Capitalize actor's names, movie titles, and genres.)
<P>


</html>