<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
<script>
function checkForm() {
  var role = document.forms["addMARelationship"]["role"].value;
  if (role == null || role == "") {
    alert("Please enter in an actor role");
    return false;
  }
  alert("Added Relationship");
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
    $actors = mysql_query("SELECT id, last, first, dob FROM Actor;", $conn) or exit(mysql_error());
    $actor = $_GET["actor_select"];
    $movie = $_GET["movie_select"];
    $role = $_GET["role"];
    if ($actor != null && $movie != null && $role != "" && $role != null) {
      $insert = "INSERT INTO MovieActor (mid, aid, role) VALUES ($movie, $actor, '$role');";
      $res = mysql_query($insert, $conn) or exit(mysql_error());
      mysql_close($conn);
    }
    mysql_close($conn);
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
    Add Movie Actor Relationship
  </div>
  <div class="form_wrapper">
    <form id="page_form" name="addMARelationship" action="" method="GET" onsubmit="return checkForm()">
      <label for="movies">Movie</label><br />
      <select class="selects" name="movie_select">
        <?php
          while($row = mysql_fetch_assoc($movies)) {
            echo "<option value=$row[id]>" . $row['title'] . " (" . $row['year'] . ")" . "</option>";
          }
        ?>
      </select><br />
      <label for="actors">Actor</label><br />
      <select class="selects" name="actor_select">
        <?php
          while($row = mysql_fetch_assoc($actors)) {
            echo "<option value=$row[id]>" . $row['first'] . " " . $row['last'] . " (" . $row['dob'] . ")" . "</option>";
          }
        ?>
      </select>
      <div>
        Role<br />
        <input type="text" maxlength="50" name="role" placeholder="Enter actor role in movie" />
      </div>
      <input class="submit_btn" type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
