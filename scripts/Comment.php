<?php
session_start();

require_once('connection.php');
require_once('Input_sanitisation.php');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }
if (isset($_POST['post_title'], $_POST['post_time'], $_POST['post_username'])){ 
  $_SESSION['post_title'] = sanitiseInput($_POST['post_title']);
  $_SESSION['post_time'] = sanitiseInput($_POST['post_time']);
  $_SESSION['post_username'] = sanitiseInput($_POST['post_username']);
}

$commentErr="";
if($_POST && isset($_POST['message']))
{
//error_reporting(E_ERROR | E_PARSE);
$mytext = $_POST['message'];
$mytext = sanitiseInput($mytext);
}

if (empty($mytext)){
	$messageErr = "* Comment is required";
	}

else{
	$sql = "INSERT INTO CONTAINS_COMMENTS(post_title, post_time, post_username,comment_username,comment_content) 
  VALUES ('".$_SESSION['post_title']."','".$_SESSION['post_time']."','".$_SESSION['post_username']."', '".$_SESSION['myusername']."', '$mytext')";
	$stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        oci_free_statement($stid);   
       
        header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewComment.php");
        exit();
}


?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link type="text/css" rel="stylesheet" href="../stylesheets/main.css">
<link type="text/css" rel="stylesheet" href="../stylesheets/form.css">

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
</body>
<div class="center">
<form class="pure-form pure-form-stacked" method="POST" action="Comment.php" accept-charset="UTF-8">
    <fieldset>
	<div class="heading1">
        <legend>Share your thoughts with our community!</legend>
	</div>
	<font color="red">* Required fields</font>
        <label for="message">Comments<font color="red">*</font></label>
	<textarea class="pure-input-1-2"  rows="10" cols="20" name="message" id="message" placeholder="Comments..."></textarea><span class="error"><font color="red"><?php echo $commentErr; ?></font></span><br><br>

        <button type="submit" class="pure-button pure-button-primary" name="uploadPost" id="uploadPost" value="Submit">Submit</button>
    </fieldset>
</form>
</div>
</html>
