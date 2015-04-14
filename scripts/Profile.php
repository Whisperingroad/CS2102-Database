<?php
session_start();

include 'connection.php';
if (!$dbh)  {
    echo "An error occurred connecting to the database";
    exit;
  }

if($_POST['UpVote']) 
{ 
  $postTitle = $_POST['post_title'];
  $postTime = $_POST['post_time'];
  $postUsername = $_POST['post_username'];
  $commentUsername = $_POST['comment_username'];
  $commentTime = $_POST['comment_time'];

  //check if user has voted before
  $sql = "SELECT Voted FROM VOTE_COMMENT WHERE post_username = '$postUsername' AND post_time = '$postTime' AND post_title = '$postTitle'
    AND comment_username  = '$commentUsername' AND comment_time = '$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
  $stid = oci_parse($dbh, $sql);
  oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_DEFAULT);
  oci_free_statement($stid);
        //Post has not been voted previously
        if ($row[0] == null){
          //Insert entry into Vote Post
          $sql = "INSERT INTO VOTE_COMMENT(post_title, post_time, post_username, voter_username, Voted, comment_time, comment_username) VALUES ('$postTitle','$postTime', 
            '$postUsername','".$_SESSION['myusername']."', '1', '$commentTime', '$commentUsername')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$commentUsername'";
          }

        //Post has been upvoted/downvoted and unvoted by user previously 
        elseif($row[0] == 0){
          //Update entry in Vote Post
          $sql = "UPDATE VOTE_COMMENT SET Voted = 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
             $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$commentUsername'";
          }

        //Post was already upvoted by the user
        //User is unvoting his upvote  
        elseif($row[0] == 1){
          //Update entry into Vote Post\
             $sql = "UPDATE VOTE_COMMENT SET Voted = 0 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
           $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$commentUsername'";                  
        }
        //Post was already downvoted by the user
        //User is changing his downvote to an upvote
        elseif($row[0] == -1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_COMMENT SET Voted = 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
           $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES + 2 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 2 WHERE username = '$commentUsername'";                  
        }    

          //sql changes Vote Post table
          $stid = oci_parse($dbh, $sql);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql2 updates Post_WritePost table
          $stid = oci_parse($dbh, $sql2);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql3 updates user's reputation
          $stid = oci_parse($dbh, $sql3);
          oci_execute($stid);
          oci_free_statement($stid);
          
       header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php");
        exit();

 } 
elseif($_POST['DownVote']) 
{ 
 $postTitle = $_POST['post_title'];
  $postTime = $_POST['post_time'];
  $postUsername = $_POST['post_username'];
  $commentUsername = $_POST['comment_username'];
  $commentTime = $_POST['comment_time'];

  //check if user has voted before
  $sql = "SELECT Voted FROM VOTE_COMMENT WHERE post_username = '$postUsername' AND post_time = '$postTime' AND post_title = '$postTitle'
    AND comment_username  = '$commentUsername' AND comment_time = '$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
  $stid = oci_parse($dbh, $sql);
  oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_DEFAULT);
  oci_free_statement($stid);
        //Post has not been voted previously
        if ($row[0] == null){
          //Insert entry into Vote Post
          $sql = "INSERT INTO VOTE_COMMENT(post_title, post_time, post_username, voter_username, Voted, comment_time, comment_username) VALUES ('$postTitle','$postTime', 
            '$postUsername','".$_SESSION['myusername']."', '-1', '$commentTime', '$commentUsername')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$commentUsername'";
          }

        //Post has been upvoted/downvoted and unvoted by user previously 
        elseif($row[0] == 0){
          //Update entry in Vote Post
          $sql = "UPDATE VOTE_COMMENT SET Voted = -1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
             $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$commentUsername'";
          }

        //Post was already upvoted by the user
        //User is unvoting his upvote  
        elseif($row[0] == -1){
          //Update entry into Vote Post\
             $sql = "UPDATE VOTE_COMMENT SET Voted = 0 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
           $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$commentUsername'";                  
        }
        //Post was already downvoted by the user
        //User is changing his downvote to an upvote
        elseif($row[0] == 1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_COMMENT SET Voted = -1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time ='$commentTime' AND voter_username = '".$_SESSION['myusername']."'";
          //Update total number of votes that the Post has
           $sql2 = "UPDATE CONTAINS_COMMENTS SET COUNT_VOTES = COUNT_VOTES - 2 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
            AND post_username = '$postUsername' AND comment_username = '$commentUsername' AND comment_time = '$commentTime'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 2 WHERE username = '$commentUsername'";                  
        }    

          //sql changes Vote Post table
          $stid = oci_parse($dbh, $sql);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql2 updates Post_WritePost table
          $stid = oci_parse($dbh, $sql2);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql3 updates user's reputation
          $stid = oci_parse($dbh, $sql3);
          oci_execute($stid);
          oci_free_statement($stid);
          
       header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php");
        exit();

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


        //upvote or downvote only if you are not the comment author 
         if ( $_SESSION['myusername'] != $row2['COMMENT_USERNAME']){ 
         //UpVote button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php">
     <input type="hidden" name="comment_time" value="'.$row2['COMMENT_TIME'].'">
     <input type="hidden" name="comment_username" value="'.$row2['COMMENT_USERNAME'].'">
    <input type="hidden" name="post_title" value= "'.$row[POST_TITLE].'">
     <input type="hidden" name="post_time" value="'.$row[POST_TIME].'">
     <input type="hidden" name="post_username" value="'.$row[POST_USERNAME].'">
         <td><input type="submit" name="UpVote" value = "UpVote"></form></td>';
         //DownVote button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php">
     <input type="hidden" name="comment_time" value="'.$row2['COMMENT_TIME'].'">
     <input type="hidden" name="comment_username" value="'.$row2['COMMENT_USERNAME'].'">
    <input type="hidden" name="post_title" value= "'.$row[POST_TITLE].'">
     <input type="hidden" name="post_time" value="'.$row[POST_TIME].'">
     <input type="hidden" name="post_username" value="'.$row[POST_USERNAME].'">
         <td><input type="submit" name ="DownVote" value="DownVote"></form></td>';
         }

      }
      oci_free_statement($stid2);
    }
    oci_free_statement($stid1);
    echo "</div>";
?>
</html>