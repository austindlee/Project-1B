<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<body bgcolor=white>
<div id="nav-placeholder"></div>
<script>
$(function(){
  $("#nav-placeholder").load("navbar.html");
});
</script>
<p>
  Type an SQL query in the following box:
</p>
  <form action="" method="POST">
    <textarea name="query" cols="60" rows="8"><?php if(isset($_POST['query'])) {echo htmlentities ($_POST['query']); }?></textarea>
    <br />
    <input type="submit" value="Submit" />
  </form>
  <?php
  $request = "";
  if (isset($_POST['query']))
  {
    $servername = "localhost";
    $username = "cs143";
    $password = "";
    $dbname = "CS143";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $request = $_POST['query'];
    $result = $conn->query($request);
    $data = array();
    if ($result) {
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
        $colNames = array_keys(reset($data));
        echo "<table border='1'><tr>";
        foreach($colNames as $colName)
        {
          echo "<th>$colName</th>";
        }
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
      } else {
          echo "0 results";
      }
    }
    $conn->close();
  }
  ?>
</body>
</html>
