<?php
session_start();
require_once('connection.php');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }
?>

<!DOCTYPE HTML>
<html>

<head>
  <title> Social News Platform</title>
</head>

<link type="text/css" rel="stylesheet" href="../stylesheets/main.css">

<div id="header">
<h1> Social News Platform </h1>
</div>

<body>
    <!-- navigation bar -->
    <div class = "navbar">
    <!-- ordered list within unordered list -->
      <ul class = "navigation">
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php"> What's Hot!! </a> </li>
          <li> <a href=  "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPostsAccToTime.php"> What's New! </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
    
      </ul>
    </div>

<?php>
    
$sql = "SELECT post_topic, post_title FROM post_writepost ORDER BY post_topic, post_title, post_time ASC" ;
$stid = oci_parse($dbh,$sql);
oci_execute($stid);


echo "<table>";

while ($row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)){
  echo "<tr>".$row[0]."</tr>";
  echo "<tr>".$row[1]."</tr>";
}
echo "</table>";

?>
    
    
    
    </body>
</html>
