<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
<script>
function checkForm() {
  var title = document.forms["addMovie"]["title"].value;
  var company = document.forms["addMovie"]["company"].value;
  var year = document.forms["addMovie"]["year"].value;
  if (title == "" || title == null) {
    alert("Enter movie title.");
    return false;
  }
  if (company == "" || company == null) {
    alert("Enter company movie is associated with.");
    return false;
  }
  if (year == 0 || year == null) {
    alert("Enter movie year.");
    return false;
  }
  alert('Movie added');
}
</script>
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
      Add new Movie
    </div>
    <div class="form_wrapper">
      <form id="page_form" name="addMovie" action="" method="GET" onsubmit="return checkForm()">
        Title:<br>
        <input type="text" name="title" placeholder="Movie Title" maxlength="100">
        <br>
        Year:<br>
        <input type="number" name="year" placeholder="Year Released" value="0">
        <br />
        Rating:<br />
        <input type="radio" name="rating" value="G" checked>G<br/>
        <input type="radio" name="rating" value="PG">PG<br/>
        <input type="radio" name="rating" value="PG-13">PG-13<br/>
        <input type="radio" name="rating" value="R">R<br/>
        <input type="radio" name="rating" value="NC-17">NC-17<br/>
        Company:<br>
        <input type="text" name="company" placeholder="Company Name" maxlength="50">
        <br />
        Genre(s): <br/>
        <input type="checkbox" name="genre[]" value="Action">Action<br>
        <input type="checkbox" name="genre[]" value="Adult">Adult<br>
        <input type="checkbox" name="genre[]" value="Adventure">Adventure<br>
        <input type="checkbox" name="genre[]" value="Animation">Animation<br>
        <input type="checkbox" name="genre[]" value="Comedy">Comedy<br>
        <input type="checkbox" name="genre[]" value="Crime">Crime<br>
        <input type="checkbox" name="genre[]" value="Documentary">Documentary<br>
        <input type="checkbox" name="genre[]" value="Drama">Drama<br>
        <input type="checkbox" name="genre[]" value="Family">Family<br>
        <input type="checkbox" name="genre[]" value="Fantasy">Fantasy<br>
        <input type="checkbox" name="genre[]" value="Horror">Horror<br>
        <input type="checkbox" name="genre[]" value="Musical">Musical<br>
        <input type="checkbox" name="genre[]" value="Mystery">Mystery<br>
        <input type="checkbox" name="genre[]" value="Romance">Romance<br>
        <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi<br>
        <input type="checkbox" name="genre[]" value="Short">Short<br>
        <input type="checkbox" name="genre[]" value="Thriller">Thriller<br>
        <input type="checkbox" name="genre[]" value="War">War<br>
        <input type="checkbox" name="genre[]" value="Western">Western<br>
        <br><br>
        <input class="submit_btn" type="submit" value="Submit">
      </form>
    </div>
    <?php
    $title = $_GET["title"];
    $year = $_GET["year"];
    $rating = $_GET["rating"];
    $company = $_GET["company"];
    if ($title != "" && $year != 0 && $company != "") {
      $servername = "localhost";
      $username = "cs143";
      $password = "";
      $dbname = "CS143";
      $conn = mysql_connect($servername, $username, $password);
      mysql_select_db("CS143", $conn);
      $res = mysql_query("UPDATE MaxMovieID SET id = id + 1;", $conn) or exit(mysql_error());
      $res = mysql_query("SELECT id FROM MaxMovieID;", $conn) or exit(mysql_error());
      $row = mysql_fetch_row($res);
      $new_id = $row[0];
      $insert = "INSERT INTO Movie (id, title, year, rating, company) VALUES
      ($new_id, '$title', $year, '$rating', '$company');";
      $res = mysql_query($insert, $conn) or exit(mysql_error());

      // into genre
      if (!empty($_GET['genre'])) {
        foreach($_GET['genre'] as $check) {
          $addToGenre = "INSERT INTO MovieGenre (mid, genre) VALUES
          ($new_id, '$check');";
          $res = mysql_query($addToGenre, $conn) or exit(mysql_error());
        }
      }
      mysql_close($conn);
    }
    ?>
  </body>
</html>
