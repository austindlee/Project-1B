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
				$queryM = $queryM.";";
		}

		$result = mysql_query($queryM);
		while ($row = mysql_fetch_assoc($result))
		{
			echo $row["id"];
			$data[] = $row;
		}
		$colNames = array_keys(reset($data));
		echo "<table border = '1'><tr>";
		/*
		foreach($colNames as $colName)
		{
			echo $colNames[0];
			echo sizeof($colName);
			$title = "Title";
			$year = "Year";
			echo "<th>$title</th>";
			echo "<th>$year</th>";

		}
		*/
		$title = "Title";
		$year = "Year";
		echo "<th>$title</th>";
		echo "<th>$year</th>";

		echo "</tr>";
		foreach($data as $row)
		{
			echo "<tr>";
			foreach($colNames as $colName)
			{
				echo "<td>".$row[$colName]."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	
	#reset($data);
	#reset($row);
	mysql_free_result($result);

	// Actors matching the search
	echo "Matching Actors:";
	$queryA = "SELECT CONCAT(first, ' ', last), dob FROM Actor WHERE ";
	for ($k = 0; $k < count($keys); $k++)
	{
		$queryA = $queryA."last LIKE '%".$keys[$k]."%' OR first LIKE '%".$keys[$k]."%'";
		if ($k != count($keys) - 1)
			$queryA = $queryA." AND ";
		else
			$queryA = $queryA.";";
	}

	$resultA = mysql_query($queryA);
	while ($rowA = mysql_fetch_assoc($resultA))
	{
		$dataA[] = $rowA;
	}
	$colNamesA = array_keys(reset($dataA));
	echo "<table border = '1'><tr>";
	/*
	foreach($colNamesA as $colNameA)
	{
		echo "<th>$colNameA</th>";
	}
	*/
	$name = "Name";
	$dob = "Date of Birth";
	echo "<th>$name</th>";
	echo "<th>$dob</th>";
	echo "</tr>";
	foreach ($dataA as $rowA)
	{
		echo "<tr>";
		foreach ($colNamesA as $colNameA)
			echo "<td>".$rowA[$colNameA]."</td>";
		echo "</tr>";
	}
	echo "</table>";
	mysql_free_result($resultA);
}
	?>

</body>
</html>