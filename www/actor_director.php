<html>
<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <link rel="stylesheet" type="text/css" href="global.css">
</head>
<script>
function checkForm() {
  var firstName = document.forms["addPerson"]["firstname"].value;
  var lastName = document.forms["addPerson"]["lastname"].value;
  firstName = firstName.trim();
  lastName = lastName.trim();

  var role = document.getElementsByName('role');
  var dob = document.forms["addPerson"]["dateofbirth"].value;
  var dod = document.forms["addPerson"]["dateofdeath"].value;

  if (firstName == "" || firstName == null || firstName.match(/[^-\'A-Za-z]/g) != null) {
    alert("Enter valid first name.");
    return false;
  }
  if (lastName == ""  || lastName == null || lastName.match(/[^-\'A-Za-z]/g) != null) {
    alert("Enter valid last name.");
    return false;
  }
  if (dob.length != 10 || dob.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/g) == null) {
    alert("Enter a valid date of birth.");
    return false;
  }
  if (dod != "") {
    if (dod.length != 10 || dod.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/g) == null || dob > dod) {
      alert("Enter a valid date of death.");
      return false;
    }
  }
  if (role[0].checked)
    alert("Actor added");
  else
    alert("Director added");
}
</script>
  <body>
    <div>
      <div id="headtag">Movie Database</div>
    </div>
    <div id="navbar">
      <a href="index.php" >Search</a>
      <a href="actor_director.php" >Add Actor/Director</a>
      <a href="movie.php" >Add Movie Information</a>
      <a href="add_review.php" class="here">Add Review</a>
      <a href="movie_actor.php" >Add Movie/Actor Relation</a>
      <a href="movie_director.php" >Add Movie/Director Relation</a>
    </div>
    <div id="page_title">
      Add new Actor/Director
    </div>
    <div class="form_wrapper">
      <form id="page_form" name="addPerson" action="" method="GET" onsubmit="return checkForm()">
        <label for="role">Role:</label><br />
        <input type="radio" name="role" value="Actor" checked>Actor <input type="radio" name="role" value="Director">Director<br/>
        <label for="firstname">First Name:</label><br />
        <input type="text" name="firstname" placeholder="Input First Name" maxlength="20"><br>
        <label for="lastname">Last Name:</label><br />
        <input type="text" name="lastname" placeholder="Input Last Name" maxlength="20"><br />
        <label for="sex">Sex:</label><br />
        <input type="radio" name="sex" value="Male" checked>Male <input type="radio" name="sex" value="Female">Female<br/>
        <label for="dateofbirth">Date of Birth:</label><br />
        <input type="text" name="dateofbirth" placeholder="Input Date of Birth">
        <br />
        ie: 1997-05-05
        <label for="dateofdeath">Date of Death (Optional)</label><br />
        <input type="text" name="dateofdeath" placeholder="Input Date of Death">
        <br />
        ie: 1997-10-05
        <br><br>
        <input class="submit_btn" type="submit" value="Submit">
      </form>
    </div>
    <?php
    $first_name = $_GET["firstname"];
    $last_name = $_GET["lastname"];
    $dateofbirth = $_GET["dateofbirth"];
    $dateofdeath = $_GET["dateofdeath"];
    $sex = $_GET["sex"];
    $type = $_GET["person_type"];
    if ($first_name != "" && $last_name != "" && $dateofbirth != "") {
      $servername = "localhost";
      $username = "cs143";
      $password = "";
      $dbname = "CS143";
      $conn = mysql_connect($servername, $username, $password);
      mysql_select_db("CS143", $conn);
      $res = mysql_query("UPDATE MaxPersonID SET id = id + 1;", $conn) or exit(mysql_error());
      $res = mysql_query("SELECT id FROM MaxPersonID;", $conn) or exit(mysql_error());
      $row = mysql_fetch_row($res);
      $new_id = $row[0];

      // Check connection
      if ($type = "Actor") {
        if ($dateofdeath == "") {
          $insert = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES
          ($new_id, '$last_name', '$first_name', '$sex', '$dateofbirth', NULL);";
        } else {
          $insert = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES
          ($new_id, '$last_name', '$first_name', '$sex', '$dateofbirth', '$dateofdeath');";
        }
      } else  {
        if ($dateofdeath == "") {
          $insert = "INSERT INTO Director (id, last, first, sex, dob, dod) VALUES
          ($new_id, '$last_name', '$first_name', '$sex', '$dateofbirth', NULL);";
        } else {
          $insert = "INSERT INTO Director (id, last, first, sex, dob, dod) VALUES
          ($new_id, '$last_name', '$first_name', '$sex', '$dateofbirth', '$dateofdeath');";
        }
      }
      $res = mysql_query($insert, $conn) or exit(mysql_error());
      mysql_close($conn);
    }
    ?>
  </body>
</html>
