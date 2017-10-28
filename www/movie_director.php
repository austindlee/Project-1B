<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
<script>
function checkForm() {
  alert("Created movie director relationship!");
}
</script>
<body>
  <?php
  $servername = "localhost";
  $username = "cs143";
  $password = "";
  $dbname = "CS143";
  $conn = mysql_connect($servername, $username, $password);
  mysql_select_db("CS143", $conn);
  $movies = mysql_query("SELECT id, title, year FROM Movie;", $conn) or exit(mysql_error());
  $directors = mysql_query("SELECT id, last, first, dob FROM Director;", $conn) or exit(mysql_error());
  $director = $_GET["director_select"];
  $movie = $_GET["movie_select"];
  if ($director != null && $movie != null) {
    $insert = "INSERT INTO MovieDirector (mid, did) VALUES ($movie, $director);";
    $res = mysql_query($insert, $conn) or exit(mysql_error());
    mysql_close($conn);
  }
   ?>
  <div>
    <div id="headtag">Movie Database</div>
  </div>
  <div id="navbar">
    <a href="actor_director.php" class="here">Home</a>
    <a href="actor_director.php" >Add Actor/Director</a>
    <a href="movie.php" >Add Movie Information</a>
    <a href="movie_actor.php" >Add Movie/Actor Relation</a>
    <a href="movie_director.php" >Add Movie/Director Relation</a>
  </div>
  <div id="page_title">
    Add Movie Director Relationship
  </div>
  <div class="form_wrapper">
    <form id="page_form" name="addMDRelationship" action="" method="GET" onsubmit="return checkForm()">
      <div class="movieselect">
        <label for="movies">Movie</label><br />
        <select class="selects" name="movie_select">
          <?php
            while($row = mysql_fetch_assoc($movies)) {
              echo "<option value=$row[id]>" . $row['title'] . " (" . $row['year'] . ")" . "</option>";
            }
          ?>
        </select>
      </div>
      <div class="directorselect">
        <label for="directors">Director</label><br />
        <select class="selects" name="director_select">
          <?php
            while($row = mysql_fetch_assoc($directors)) {
              echo "<option value=$row[id]>" . $row['first'] . " " . $row['last'] . " (" . $row['dob'] . ")" . "</option>";
            }
          ?>
        </select>
      </div>
      <input class="submit_btn" type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
