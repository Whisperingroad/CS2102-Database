<?php
session_start();

include 'connection.php';
if (!$dbh)  {
    echo "An error occurred connecting to the database";
    exit;
  }
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="/combo/1.18.13?/css/layouts/blog.css">
<link type="text/css" rel="stylesheet" href="../stylesheets/main.css">
<div id="header">
<h1> Social News Platform </h1>
</div>
<body>
    <!-- navigation bar -->
    <div class = "navbar">
    <!-- ordered list within unordered list -->
      <ul class = "navigation">
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php"> Hot Posts </a> </li>
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPostsAccToTime.php"> New Posts </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post! </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
      </ul>
    </div>
</body>
<legend>Your post has been uploaded!</legend>
<?php
    //Display newly uploaded post
    $sql = "SELECT post_title, post_content , post_time, post_username, pvotes  FROM POST_WRITEPOST WHERE ((post_title = '".$_SESSION['post_title']."'  AND post_username = '".$_SESSION['myusername']."' )
        AND post_time in(SELECT max(post_time) FROM POST_WRITEPOST))";
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid, OCI_DEFAULT);
        $row = oci_fetch_array($stid);
        oci_free_statement($stid);

        $sql = "SELECT reputation FROM REGISTERED_USER WHERE username = '".$_SESSION['myusername']."'"; 
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        $row1 = oci_fetch_array($stid,OCI_DEFAULT);
        oci_free_statement($stid);

        echo "<div class = "."HotPosts".">";
        echo "<ul class =". "HotPostsList".">";  
      	echo "<li id ="."post_title". ">". $row[POST_TITLE]. "</li>";
      	echo "<li id =". "post_content".">".$row[POST_CONTENT]. "</li>";
      	echo "<li id =". "post_username"."> Authored by " .$row[POST_USERNAME]. " ".$row1[0]." Points</li>";  
      	echo "<li id =". "post_time".">".  $row[POST_TIME] . " ". $row[PVOTES]." Vote(s)</li>";      
      	echo "</ul>";  
	
	    echo "</div>";
?>
</html>

