<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
<body>
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
    <form id="page_form" name="addMARelationship" action="" method="GET">
      <div class="movieselect">
        <label for="movies">Movie</label><br />
        <select name="movie_select">
          <?php
            $servername = "localhost";
            $username = "cs143";
            $password = "";
            $dbname = "CS143";
            $conn = mysql_connect($servername, $username, $password);
            mysql_select_db("CS143", $conn);
            $res = mysql_query("SELECT id, title, year FROM Movie;", $conn) or exit(mysql_error());
            while($row = mysql_fetch_assoc($res)) {
              echo "<option value=$row[id]>" . $row['title'] . " (" . $row['year'] . ")" . "</option>";
            }
            mysql_close($conn);
          ?>
        </select>
      </div>
      <div class="actorselect">
        <label for="actors">Actor</label><br />
        <select name="actor_select">
          <?php
            $servername = "localhost";
            $username = "cs143";
            $password = "";
            $dbname = "CS143";
            $conn = mysql_connect($servername, $username, $password);
            mysql_select_db("CS143", $conn);
            $res = mysql_query("SELECT id, last, first, dob FROM Actor;", $conn) or exit(mysql_error());
            while($row = mysql_fetch_assoc($res)) {
              echo "<option value=$row[id]>" . $row['first'] . " " . $row['last'] . " (" . $row['dob'] . ")" . "</option>";
            }
            mysql_close($conn);
          ?>
        </select>
      </div>
      <div>
        Role<br />
        <input type="text" maxlength="50" name="role" placeholder="Enter actor role in movie" />
      </div>
      <input class="submit_btn" type="submit" value="Submit">
    </form>
  </div>
  <?php
    $actor = $_GET["actor_select"];
    $movie = $_GET["movie_select"];
    $role = $_GET["role"];
    if ($actor != null && $movie != null && $role != "" && $role != null) {
      $servername = "localhost";
      $username = "cs143";
      $password = "";
      $dbname = "CS143";
      $conn = mysql_connect($servername, $username, $password);
      mysql_select_db("CS143", $conn);
      $insert = "INSERT INTO MovieActor (mid, aid, role) VALUES ($movie, $actor, '$role');";
      $res = mysql_query($insert, $conn) or exit(mysql_error());
      mysql_close($conn);
    }
  ?>
</body>
</html>
