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
		<div id="headtag">Search</div>
	</div>
	<div id="navbar">
		<a href="actor_director.php">Home</a>
		<a href="actor_director.php">Add Actor/Director</a>
		<a href="movie.php">Add Movie Information</a>
		<a href="movie_actor.php">Add Movie/Actor Relation</a>
		<a href="movie_director.php">Add Movie/Director Relation</a>
		<a href="movie_information.php">Movie Information</a>
		<a href="actor_information.php">Actor Information</a>
		<a href="search.php" class="here">Search</a>
	</div>
	<div id="page_title">
		<!--Search-->
	</div>
	<div class="form_wrapper">
		<form id="page_form" name = "search" action="" method="GET" onsubmit="return checkForm()">
			<label for="search"> Search:</label><br />
			<input type="text" name="searchKey" placeholder="Search!" maxlength="50">
			<input class="submit_btn" type="submit" name="Submit">
		</form>
	</div>

	<?php
	$search = $_GET["searchKey"];
	if ($search != "") {
		$servername = "localhost";
		$username = "cs143";
		$password = "";
		$dbname = "CS143";
		$conn = mysql_connect($servername, $username, $password);
		if (!$conn)
			die(mysql_error());
		if (!mysql_select_db("CS143", $conn))
			die(mysql_error());
		$keys = explode(" ", $search);

		// Movies matching the search
		echo "Matching Movies:";
		$queryM = "SELECT id, title, year FROM Movie WHERE ";
		for ($k = 0; $k < count($keys); $k++)
		{
			$queryM = $queryM."title LIKE '%".$keys[$k]."%'";
			if ($k != count($keys) - 1)
				$queryM = $queryM." AND ";
			else
				$queryM = $queryM."ORDER BY title;";
		}

		$result = mysql_query($queryM);
		echo "<table class=\"table\">\n";
		echo "<table border = '1'><tr>";
		$title = "Title";
		$year = "Year";
		echo "<th>$title</th>";
		echo "<th>$year</th>";
		echo "</tr>\n";
		while ($row = mysql_fetch_row($result))
		{
			$id = $row[0];
			$title = $row[1];
			$year = $row[2];
			echo "<td><a href=\"./movie_information.php?mid=$id\">$title</a></td>";
			echo "<td>$year</td>";
			echo "</tr>\n";
		}	
		echo "</table>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<hr>\n";
		mysql_free_result($result);


		// Actors matching the search
		echo "<br />\nMatching Actors:";
		$queryA = "SELECT id, CONCAT(first, ' ', last), dob FROM Actor WHERE ";
		for ($k = 0; $k < count($keys); $k++)
	{
		$queryA = $queryA."last LIKE '%".$keys[$k]."%' OR first LIKE '%".$keys[$k]."%'";
		if ($k != count($keys) - 1)
			$queryA = $queryA." AND ";
		else
			$queryA = $queryA."ORDER BY last;";
	}
		$resultA = mysql_query($queryA);
		echo "<table class=\"table\">\n";
		echo "<table border = '1'><tr>";
		$name = "Name";
		$birth = "Date of Birth";
		echo "<th>$name</th>";
		echo "<th>$birth</th>";
		echo "</tr>\n";
		while ($rowA = mysql_fetch_row($resultA))
		{
			$id = $rowA[0];
			$name = $rowA[1];
			$dob = $rowA[2];
			echo "<td><a href=\"./actor_information.php?aid=$id\">$name</a></td>";
			echo "<td>$dob</td>";
			echo "</tr>\n";
		}	
		echo "</table>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<hr>\n";
		mysql_free_result($resultA);
	}
	?>

</body>
</html>