<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
  <body>
	<div>
	  <div id="headtag">Add a Review!</div>
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
	<?php

	$mid = $_GET["mid"];
	$name = $_GET["name"];
	$rating = $_GET["rating"];
	$comment = $_GET["comment"];
	if ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($name))
	{
		$servername = "localhost";
	  	$username = "cs143";
	  	$password = "";
	  	$dbname = "CS143";
	  	$conn = mysql_connect($servername, $username, $password);
	  	mysql_select_db("CS143", $conn);
		$insert = "INSERT INTO Review (name, time, mid, rating, comment) VALUES ('$name', NOW(), $mid, $rating, '$comment')";
		if (!$result = mysql_query($insert))
			die(mysql_error());
		echo "Comment added!!";
		echo "<hr />";
	}
	?>

	<p>Add new review:</p>
	<form action="./add_review.php" method="GET">
		<?php
		$servername = "localhost";
	  	$username = "cs143";
	  	$password = "";
	  	$dbname = "CS143";
	  	$conn = mysql_connect($servername, $username, $password);
	  	mysql_select_db("CS143", $conn);

		$queryM = "SELECT title, year, id FROM Movie ORDER BY title ASC";
		if (!$result = mysql_query($queryM))
			die(mysql_error());
		echo "Movie: <select class=\"form-control\" name=\"mid\">\n";
		while ($row = mysql_fetch_row($result)) {
			$title = $row[0];
			$year = $row[1];
			$mid = $row[2];
			if (!empty($_GET["mid"]) && $mid === $_GET["mid"])
				echo "<option value=\"$mid\" selected>$title ($year)</option>\n";
			else
				echo "<option value=\"$mid\">$title ($year)</option>\n";
		}
		echo "</select><br />\n";
		mysql_free_result($result);
		?>

		<div class="row">
		<div class="col-xs-4">
			Name:<input type="text" class="form-control" name="name" value="Anonymous" maxlength="20"><br/>
		</div>
		</div>
		<label for="rating">Rating(0-5):</label><br />
		<input type="number" name="rating" placeholder="Rating(0-5)" value="0" min = "0" max = "5">
		<br/>
		Comments: <br/>
		<textarea name="comment" cols="50" rows="10" placeholder="Enter Comment (Max Length: 500 characters)"></textarea>
		<br/><br/>
		<input class="submit_btn" type="submit" value="Submit"/>
	</form>
</div>
</body>
</html>
