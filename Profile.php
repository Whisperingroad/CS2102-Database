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
<link type="text/css" rel="stylesheet" href="stylesheets/main.css">


<div id="header">
<h1> Social News Platform </h1>
</div>
<?php
    //Find all post by user
    $sql1 = "SELECT post_title, post_content, post_time, post_username, pvotes FROM POST_WRITEPOST WHERE post_username = '".$_SESSION['myusername']."'";
    $stid1 = oci_parse($dbh, $sql1);
    oci_execute($stid1);
    while ($row = oci_fetch_array($stid1,OCI_DEFAULT)) {
      echo "<h2>" . $row[0] . "</h2>"; //post title
      echo "<p>" . $row[1] . "</p>";   //post content
      echo "<font color=". "grey". ">" . $row[2] . " Authored by " . $row[3]. "</font><br>"; //time and author
      if (empty($row[4])){ //votes
        echo "<u><font color=". "blue". ">0 Votes</font></u>";
        }
        else{
        echo "<u><font color=". "blue". ">" . $row[4] . " Votes</font></u>";
      }
      //Find all comments on particular post
      $sql2 = "SELECT comment_username, comment_content, comment_time, count_votes FROM CONTAINS_COMMENTS WHERE post_title = '$row[0]' AND post_time = '$row[2]' AND post_username = '$row[3]'";
      //Number of comments for a post
      $sql3 = "SELECT COUNT(*) FROM CONTAINS_COMMENTS WHERE post_title = '$row[0]' AND post_time = '$row[2]' AND post_username = '$row[3]'";
      
      $stid2 = oci_parse($dbh, $sql3);
      oci_execute($stid2);
      $row2 = oci_fetch_array($stid2,OCI_DEFAULT);
      if (empty($row2[0])){ //Number of comments
        echo "<u><font color=". "blue". ">0 Comments</font></u>";
        }
        else{
        echo "<u><font color=". "blue". ">" . $row2[0] . " Comment(s)</font></u><hr>";
        }
       oci_free_statement($stid2);
      $stid2 = oci_parse($dbh, $sql2);
      oci_execute($stid2);
      while ($row2 = oci_fetch_array($stid2,OCI_DEFAULT)) {       
        echo "<p><font color=". "grey". ">" . $row2[1] . "</p><br>";
        echo "<font color=". "grey". ">" . $row2[2] . " Authored by " . $row2[0]. "</font><br>";
        if (empty($row2[3])){
          echo "<u><font color=". "blue". "> 0 Votes</font></u><br><hr>";
        }
        else{
        echo "<u><font color=". "blue". ">" . $row2[3] . " Votes</font></u><br><hr>";
        }
       
      }
      oci_free_statement($stid2);
    }
    oci_free_statement($stid1);

?>
</html>