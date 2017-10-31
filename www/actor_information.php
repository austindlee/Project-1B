<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="navbar.css">
	<link rel="stylesheet" type="text/css" href="global.css">
</head>
<script>
	function checkForm() {
		var searchKey = document.forms["search"]["searchKey"].value;
		if (searchKey == "" || searchKey == null)
		{
			alert("Enter an actor name or a movie title!");
			return false;
		}
	}
</script>
<body>
	<div>
		<div id="headtag">Actor Information</div>
	</div>
	<div id="navbar">
		<a href="index.php" >Search</a>
		<a href="actor_director.php" >Add Actor/Director</a>
		<a href="movie.php" >Add Movie Information</a>
		<a href="add_review.php" class="here">Add Review</a>
		<a href="movie_actor.php" >Add Movie/Actor Relation</a>
		<a href="movie_director.php" >Add Movie/Director Relation</a>
	</div>
	<div class="form_wrapper">
	<form action="./index.php" method="GET">
		<input type="text" name="searchKey", placeholder="Search for actors!" />
		<input class="submit_btn" type="submit" value="Search" />
	</form>

	<?php
	if (!isset($_GET["aid"]) || $_GET["aid"] === "")
		die("You gotta pick an actor!");
	$servername = "localhost";
	$username = "cs143";
	$password = "";
	$dbname = "CS143";
	$conn = mysql_connect($servername, $username, $password);
	if (!$conn)
		die(mysql_error());
	if (!mysql_select_db("CS143", $conn))
		die(mysql_error());
	$aid = (int) $_GET["aid"];

	$queryA = "SELECT id, CONCAT(first, ' ', last), sex, dob, dod FROM Actor WHERE id=".$aid;
	$resultA = mysql_query($queryA);
	if (!$resultA)
		die(mysql_error());
	echo "<br />";
	echo "<h2><b>Actor Information:</b></h2>\n";
	echo "<table class=\"table\">";
	echo "<table border = '1'><tr>";
	echo "<tr align=center>";
	echo "<td><b>Name</b></td>";
	echo "<td><b>Sex</b></td>";
	echo "<td><b>Date of Birth</b></td>";
	echo "<td><b>Date of Death</b></td>";
	echo "</tr>\n";
	while ($rowA = mysql_fetch_row($resultA))
	{
		echo "<td><a href=\"./actor_information.php?aid=$rowA[0]\">$rowA[1]</a></td>";
		echo "<td>$rowA[2]</td>";
		echo "<td>$rowA[3]</td>";
		if (is_null($rowA[4]))
			echo "<td>Still Kicken'</td>";
		else
			echo "<td>$rowA[4]</td>";
		#echo "<td>$rowA[5]</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
	mysql_free_result($resultA);

	$queryMA = "SELECT title, role, mid FROM Movie, MovieActor WHERE mid=id AND aid=".$aid;
	$resultMA = mysql_query($queryMA);
	echo "<h2><b>Movies and Roles:</b></h2>\n";
	echo "<table class=\"table\">";
	echo "<table border = '1'><tr>";
	echo "<tr align=center>";
	echo "<td><b>Role</b></td>";
	echo "<td><b>Movie</b></td>";
	echo "</tr>\n";
	while ($rowMA = mysql_fetch_row($resultMA))
	{
		echo "<td>$rowMA[1]</td>";
		echo "<td><a href=\"./movie_information.php?mid=$rowMA[2]\">$rowMA[0]</a></td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
	mysql_free_result($resultMA);

	?>

</div>
</body>
</html>
