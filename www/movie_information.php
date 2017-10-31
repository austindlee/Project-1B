<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="navbar.css">
	<link rel="stylesheet" type="text/css" href="gloabl.css">
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
		<div id="headtag">Movie Information</div>
	</div>
	<div id="navbar">
		<a href="actor_director.php">Home</a>
		<a href="actor_director.php">Add Actor/Director</a>
		<a href="movie.php">Add Movie Information</a>
		<a href="movie_actor.php">Add Movie/Actor Relation</a>
		<a href="movie_director.php">Add Movie/Director Relation</a>
		<a href="movie_information.php" class="here">Movie Information</a>
		<a href="actor_information.php">Actor Information</a>
		<a href="search.php">Search</a>
	</div>
	<div class="container">
	<form action="./search.php" method="GET">
		<input type="text" name="searchKey", placeholder="Search for movies!" />
		<input class="submit_btn" type="submit" value="Search" />
	</form>

	<?php
	if (!isset($_GET["mid"]) || $_GET["mid"] === "")
		die("You gotta pick a movie!");
	$servername = "localhost";
	$username = "cs143";
	$password = "";
	$dbname = "CS143";
	$conn = mysql_connect($servername, $username, $password);
	if (!$conn)
		die(mysql_error());
	if (!mysql_select_db("CS143", $conn))
		die(mysql_error());
	$mid = (int) $_GET["mid"];
	## Movie ##
	$queryM = "SELECT * FROM Movie WHERE id=" . $mid;
	$resultM = mysql_query($queryM);
	if (!$resultM)
		die(mysql_error());
	$row = mysql_fetch_assoc($resultM);
	echo "<h3>$row[title] ($row[year])</h3>\n";
	echo "MPAA Rating: $row[rating]<br />\n";
	echo "Producer: $row[company]<br />\n";
	mysql_free_result($resultM);
	## Director ##
	$queryD = "SELECT DISTINCT CONCAT(first, ' ', last), dob FROM MovieDirector, Director WHERE did=id AND mid=".$mid.";";
	$resultD = mysql_query($queryD);
	if (!$resultD)
		die(mysql_error());
	echo "Director: ";
	for ($k = 0; $k < mysql_num_rows($resultD); $k++)
	{
		$rowD = mysql_fetch_row($resultD);
		echo $rowD[0]." ";
	}
	echo "<br />";
	mysql_free_result($resultD);
	## MovieGenre ##
	$queryMG = "SELECT genre FROM MovieGenre WHERE mid=" . $mid;	$resultMG = mysql_query($queryMG);
	if (!$resultMG)
		die(mysql_error());	echo "Genre: ";
	 for ($k = 0; $k < mysql_num_rows($resultMG); $k++)
	{
		$rowMG = mysql_fetch_row($resultMG);
		echo $rowMG[0]." ";
	}
	echo "<br />";
	mysql_free_result($resultMG);
	## Movie Rating ##
	$queryR = "SELECT imdb,rot FROM MovieRating WHERE mid=" . $mid;
	$resultR = mysql_query($queryR);
	if (!$resultR)
		die(mysql_error());
	$rowR = mysql_fetch_row($resultR);
	echo "IMDB Rating: $rowR[0]<br />\n";
	echo "Rotten Tomatoes Rating: $rowR[1]<br />\n";
	mysql_free_result($resultR);
	## SALES ##
	$queryS = "SELECT ticketsSold, totalIncome FROM Sales WHERE mid=" . $mid;
	$resultS = mysql_query($queryS);
	if(!$resultS)
		die(mysql_error());
	$rowS = mysql_fetch_row($resultS);
	echo "Tickets Sold: $rowS[0]<br />\n";
	echo "Total Income: $rowS[1]<br />\n";
	mysql_free_result($resultS);
	## Actors in the Movie ##
	$queryMA = "SELECT id, CONCAT(first, ' ', last), role FROM Actor, MovieActor WHERE aid = id AND mid=".$mid;
	$resultMA = mysql_query($queryMA);
	if (!$resultMA)
		die(mysql_error());
	echo "<br />";
	echo "<h2><b>Actors in the Movie:</b></h2>\n";
	echo "<table class=\"table\">";
	echo "<table border = '1'><tr>";
	echo "<tr align=center>";
	echo "<td><b>Actor </b></td>";
	echo "<td><b>Role</b></td>";
	echo "</tr>\n";
	while ($row = mysql_fetch_row($resultMA))
	{
		echo "<td><a href=\"./actor_information.php?aid=$row[0]\">$row[1]</a></td>";
		echo "<td>$row[2]</td>";
		echo "</tr>\n";
	}	
	echo "</table>\n";
	mysql_free_result($resultMA);
	## Reviews ##
	$queryR = "SELECT AVG(rating), COUNT(rating) FROM Review WHERE mid=" . $mid;
	$resultR = mysql_query($queryR);
	if(!$resultR)
		die(mysql_error());
	$rowR = mysql_fetch_row($resultR);
	 if (count($row[0]) == 0)
		echo "No Reviews yet :( Be the first to Review! ";
	else
		echo "Average Score of $$row[0]/5 based on $row[1] people Give your input! . \n";
	mysql_free_result($resultR);
	$query = "SELECT name, time, rating, comment FROM Review WHERE mid=" . $mid . " ORDER BY time DESC";
	if(!$result = mysql_query($query))
		die("Error executing query: " . mysql_error());
	echo "<br />";
	echo "<a href=\"./review.php?mid=$mid\">Give your input too!</a><br/>\n";
	while ($row = mysql_fetch_row($resultR))
	{
		echo "<br/><br/>\n";
		echo "$row[0] rated this movie a $row[3] at $row[1]. <br/> comment: <br/>\n $row[3]\n";
	}
	mysql_free_result($result);
	mysql_close($conn);
	?>
</div>
</body>
</html>