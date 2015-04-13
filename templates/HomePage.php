<?php
session_start();
//require_once('../scripts/connection.php');

require_once('../scripts/HotPosts.php');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

if($_POST['UpVote']) 
{ 
	$postTitle = $_POST['post_title'];
	$postTime = $_POST['post_time'];
	$postUsername = $_POST['post_username'];

	//check if user has voted before
	$sql = "SELECT Voted FROM VOTE_POST WHERE post_username = '$postUsername' AND post_time = '$postTime' AND post_title = '$postTitle'
		AND voter_username = '".$_SESSION['myusername']."'";
	$stid = oci_parse($dbh, $sql);
  oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_DEFAULT);
  oci_free_statement($stid);
        //Post has not been voted previously
        if ($row[0] == null){
        	//Insert entry into Vote Post
        	$sql = "INSERT INTO VOTE_POST(post_title, post_time, post_username, voter_username, Voted) VALUES ('$postTitle','$postTime', 
        		'$postUsername','".$_SESSION['myusername']."', '1')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$postUsername'";
          }

        //Post has been upvoted/downvoted and unvoted by user previously 
        if($row[0] == 0){
          //Update entry in Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$postUsername'";
          }

        //Post was already upvoted by the user
        //User is unvoting his upvote  
        if($row[0] == 1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = 0 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$postUsername'";                  
        }
        //Post was already downvoted by the user
        //User is changing his downvote to an upvote
        if($row[0] == -1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES + 2 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 2 WHERE username = '$postUsername'";                  
        }    

          //sql changes Vote Post table
        	$stid = oci_parse($dbh, $sql);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql2 updates Post_WritePost table
        	$stid = oci_parse($dbh, $sq2);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql3 updates user's reputation
        	$stid = oci_parse($dbh, $sql3);
          oci_execute($stid);
          oci_free_statement($stid);
        	
	     header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php");
        exit();
}

elseif($_POST['DownVote']) 
{ 
  $postTitle = $_POST['post_title'];
  $postTime = $_POST['post_time'];
  $postUsername = $_POST['post_username'];

  //check if user has voted before
  $sql = "SELECT Voted FROM VOTE_POST WHERE post_username = '$postUsername' AND post_time = '$postTime' AND post_title = '$postTitle'
    AND voter_username = '".$_SESSION['myusername']."'";
  $stid = oci_parse($dbh, $sql);
  oci_execute($stid);
  $row = oci_fetch_array($stid,OCI_DEFAULT);
  oci_free_statement($stid);
        //Post has not been voted previously
        if ($row[0] == null){
          //Insert entry into Vote Post
          $sql = "INSERT INTO VOTE_POST(post_title, post_time, post_username, voter_username, Voted) VALUES ('$postTitle','$postTime', 
            '$postUsername','".$_SESSION['myusername']."', '-1')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$postUsername'";
          }

        //Post has been upvoted/downvoted and unvoted by user previously 
        if($row[0] == 0){
          //Update entry in Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = -1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES - 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post        
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 1 WHERE username = '$postUsername'";
          }

        //Post was already downvoted by the user
        //User is unvoting his downvote  
        if($row[0] == -1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = 0 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES + 1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION + 1 WHERE username = '$postUsername'";                  
        }
        //Post was already upvoted by the user
        //User is changing his upvote to a downvote
        if($row[0] == 1){
          //Update entry into Vote Post
          $sql = "UPDATE VOTE_POST SET Voted = -1 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
          AND post_username = '$postUsername' AND voter_username = '".$_SESSION['myusername']."')";
          //Update total number of votes that the Post has
          $sql2 = "UPDATE POST_WRITEPOST SET PVOTES = PVOTES - 2 WHERE post_title = '$postTitle' AND post_time = '$postTime' 
                  AND post_username = '$postUsername'";
          //Update the reputation of the user who wrote the post
          $sql3= "UPDATE REGISTERED_USER SET REPUTATION = REPUTATION - 2 WHERE username = '$postUsername'";                  
        }    

          //sql changes Vote Post table
          $stid = oci_parse($dbh, $sql);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql2 updates Post_WritePost table
          $stid = oci_parse($dbh, $sq2);
          oci_execute($stid);
          oci_free_statement($stid);
          //sql3 updates user's reputation
          $stid = oci_parse($dbh, $sql3);
          oci_execute($stid);
          oci_free_statement($stid);
          
       header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php");
        exit();
} 

elseif($_POST['Delete']) 
{
	
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
          <li> <a href= "#HotPost"> Hot Posts </a> </li>
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPostsAccToTime.php"> New Posts </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post! </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
    
      </ul>
    </div>


<div class = "HotPosts">
    <h1><font color= 'red'> What's Hot - 20 Top Posts! </font></h1>
<?php
       // assessing one result row at a time 
    foreach($hotPosts as $hotPost){
      // displaying results from the hotPost array
      echo "<ul class =". "HotPostsList>";  
        
        //if user is the post author 
           echo '<li id ="post_title"> '. $hotPost['POST_TITLE']. '';
          //echo "<button id = " . "button class=". "pure-button pure-button-active".">Edit</button> 
          // <button id = " . "button class=". "pure-button pure-button-active".">Delete</button></li>";

        //get user's reputation
		$sql = "SELECT reputation FROM REGISTERED_USER WHERE username = '$postUsername'";
		$stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        $row = oci_fetch_array($stid,OCI_DEFAULT);
        oci_free_statement($stid);

         echo '<li id ="post_content">'.$hotPost['POST_CONTENT']. '</li>';
         echo '<li id ="post_username">'. $hotPost['POST_USERNAME'].' '.$row[0].' Points</li>';
         echo "<li id =". "post_time>". $hotPost['POST_TIME']. "  ". $hotPost['PVOTES']." Vote(s)</li>";         
         

         //Comment button
         echo '<table>';
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Comment.php">
		 <input type="hidden" name="post_title" value= "'.$hotPost['POST_TITLE'].'">
		 <input type="hidden" name="post_time" value="'.$hotPost['POST_TIME'].'">
		 <input type="hidden" name="post_username" value="'.$hotPost['POST_USERNAME'].'">
         <td><input type="submit" value = "Comment"></form></td>';
         
         //upvote or downvote only if you are not the post author 
         if ( $_SESSION['myusername'] != $hotPost['POST_USERNAME']){ 
         //UpVote button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php">
		 <input type="hidden" name="post_title" value= "'.$hotPost['POST_TITLE'].'">
		 <input type="hidden" name="post_time" value="'.$hotPost['POST_TIME'].'">
		 <input type="hidden" name="post_username" value="'.$hotPost['POST_USERNAME'].'">
         <td><input type="submit" name="UpVote" value = "UpVote"></form></td>';
         //DownVote button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php">
		 <input type="hidden" name="post_title" value= "'.$hotPost['POST_TITLE'].'">
		 <input type="hidden" name="post_time" value="'.$hotPost['POST_TIME'].'">
		 <input type="hidden" name="post_username" value="'.$hotPost['POST_USERNAME'].'">
         <td><input type="submit" name ="DownVote" value="DownVote"></form></td>';
         }

         //edit or delete if you are post author or admin
         if ( $_SESSION['myusername'] == $hotPost['POST_USERNAME']){ 
         //Edit button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php">
		 <input type="hidden" name="post_title" value= "'.$hotPost['POST_TITLE'].'">
		 <input type="hidden" name="post_time" value="'.$hotPost['POST_TIME'].'">
		 <input type="hidden" name="post_username" value="'.$hotPost['POST_USERNAME'].'">
         <td><input type="submit" name="Edit" value = "Edit"></form></td>';
         //Delete button
         echo '<form method="post"action="http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php">
		 <input type="hidden" name="post_title" value= "'.$hotPost['POST_TITLE'].'">
		 <input type="hidden" name="post_time" value="'.$hotPost['POST_TIME'].'">
		 <input type="hidden" name="post_username" value="'.$hotPost['POST_USERNAME'].'">
         <td><input type="submit" name ="Delete" value="Delete"></form></td>';
         }
         echo '</table>';
         echo "</ul>";  

      }
       
?>
</div>
</body>
</html>
