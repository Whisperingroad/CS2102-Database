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

<?php
    //Find all post by user
    echo "<div class = "."HotPosts".">";
    $sql1 = "SELECT post_title, post_content, post_time, post_username, pvotes FROM POST_WRITEPOST WHERE post_username = '".$_SESSION['myusername']."'";
    $stid1 = oci_parse($dbh, $sql1);
    oci_execute($stid1);
    while ($row = oci_fetch_array($stid1,OCI_DEFAULT)) {
      echo "<ul class =". "HotPostsList".">";  
      echo "<li id ="."post_title". ">". $row[POST_TITLE]. "</li>";

      //get user's reputation
      $sql = "SELECT reputation FROM REGISTERED_USER WHERE username = '". $row[POST_USERNAME]."'";
      $stid = oci_parse($dbh, $sql);
      oci_execute($stid);
      $row1 = oci_fetch_array($stid,OCI_DEFAULT);
      oci_free_statement($stid);

      echo "<li id =". "post_content".">".$row[POST_CONTENT]. "</li>";
      echo "<li id =". "post_username".">Authored by " .$row[POST_USERNAME].' '.$row1[0].' Points</li>';
      echo "<li id =". "post_time".">".  $row[POST_TIME] ." ". $row[PVOTES]." Vote(s)</li>";     
 
      //comment button
      echo '<table>';
      echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Comment.php">
     <input type="hidden" name="post_title" value= "'.$row[POST_TITLE].'">
     <input type="hidden" name="post_time" value="'.$row[POST_TIME].'">
     <input type="hidden" name="post_username" value="'.$row[POST_USERNAME].'">
         <td><input type="submit" value = "Comment"></form></td>';

      //Edit button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Edit.php">
     <input type="hidden" name="post_title" value= "'.$row[POST_TITLE].'">
     <input type="hidden" name="post_time" value="'.$row[POST_TIME].'">
     <input type="hidden" name="post_username" value="'.$row[POST_USERNAME].'">
         <td><input type="submit" name="Edit" value = "Edit"></form></td>';
         
         //Delete button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php">
     <input type="hidden" name="post_title" value= "'.$row[POST_TITLE].'">
     <input type="hidden" name="post_time" value="'.$row[POST_TIME].'">
     <input type="hidden" name="post_username" value="'.$row[POST_USERNAME].'">
         <td><input type="submit" name ="Delete" value="Delete"></form></td>';
      
         echo '</table>';
         echo "</ul>";          
      
      //Find all comments on particular post
      $sql2 = "SELECT comment_username, comment_content, comment_time, count_votes FROM CONTAINS_COMMENTS WHERE post_title = '$row[POST_TITLE]' AND post_time = '$row[POST_TIME]' AND post_username = '$row[POST_USERNAME]'";
      //Number of comments for a post
      $sql3 = "SELECT COUNT(*) FROM CONTAINS_COMMENTS WHERE post_title = '$row[POST_TITLE]' AND post_time = '$row[POST_TIME]' AND post_username = '$row[POST_USERNAME]'";
      
      //Number of comments
      $stid2 = oci_parse($dbh, $sql3);
      oci_execute($stid2);
      $row2 = oci_fetch_array($stid2,OCI_DEFAULT);
      echo "<u><font color=". "blue". ">" . $row2[0] . " Comment(s)</font></u><hr>";
      oci_free_statement($stid2);
      
      //All comments for a post
        $stid2 = oci_parse($dbh, $sql2);
        oci_execute($stid2);
        while ($row2 = oci_fetch_array($stid2,OCI_DEFAULT)) {       
        echo "<p><font color=". "grey". ">" . $row2['COMMENT_CONTENT'] . "</font></p><br>";
        
        //get user's reputation
        $sql = "SELECT reputation FROM REGISTERED_USER WHERE username = '". $row2['COMMENT_USERNAME']."'";
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        $row1 = oci_fetch_array($stid,OCI_DEFAULT);
        oci_free_statement($stid);

        echo "<i><font color=". "grey". ">" . $row2['COMMENT_USERNAME'] . " ".$row1[0]." Points</font></i><br>";
        echo "<i><font color=". "grey". ">" . $row2['COMMENT_TIME'] . " </font></i><br><hr>";
      }
      oci_free_statement($stid2);
    }
    oci_free_statement($stid1);
    echo "</div>";
?>
</html>