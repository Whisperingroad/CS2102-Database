<?php
session_start();

require_once('connection.php');
require_once('Input_sanitisation.php');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

$firstNameErr=$lastNameErr="";
if($_POST && isset($_POST['uploadPost'], $_POST['mytitle'], $_POST['mytopic'], $_POST['message']))
{
//error_reporting(E_ERROR | E_PARSE);
$mytitle = $_POST['mytitle'];
$mytopic = $_POST['mytopic'];
$mytext = $_POST['message'];

$mytitle = sanitiseInput($mytitle);
$mytopic = sanitiseInput($mytopic);
$mytext = sanitiseInput($mytext);


if(empty($mytext) || empty($mytitle)) {
    if (empty($mytext)){
	$messageErr = "* Post content is required";
	}

    if (empty($mytitle)){
	$titleErr = "* Title is required";
	}
}
else{

  if (empty($mytopic)){
	$sql = "INSERT INTO POST_WRITEPOST(post_title, post_content, post_username) VALUES ('$mytitle','$mytext','".$_SESSION['myusername']."')";
	}
  else{
  $sql = "INSERT INTO POST_WRITEPOST(post_title, post_content, post_topic, post_username) VALUES ('$mytitle','$mytext', '$mytopic','".$_SESSION['myusername']."')";
  }

  $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        oci_free_statement($stid);          
        $_SESSION['post_title'] = $mytitle;

  /*$sql = "INSERT INTO TOPIC(topic_title) VALUES ('$mytopic')";
  $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        oci_free_statement($stid);         
  */
        header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPost.php");
        exit();
}
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
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php"> Hot Posts </a> </li>
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPostsAccToTime.php"> New Posts </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post! </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
      </ul>
    </div>
</body>
<div class="center">
<form class="pure-form pure-form-stacked" method="POST" action="Post.php" accept-charset="UTF-8">
    <fieldset>
	<div class="heading1">
        <legend>Share your thoughts with our community!</legend>
	</div>
	<font color="red">* Required fields</font>
        <label for="mytitle">Title<font color="red">*</font></label>
        <input name="mytitle" id="mytitle" type="text" placeholder="Title" ><span class="error"><font color="red"><?php echo $titleErr; ?></font></span><br>

        <label for="mytopic">Topic</label>
        <input name="mytopic" id="mytopic" type="text" placeholder="Topic"><br>

        <label for="message">Post<font color="red">*</font></label>
	<textarea class="pure-input-1-2"  rows="30" cols="50" name="message" id="message" placeholder="Start your post here."></textarea><span class="error"><font color="red"><?php echo $messageErr; ?></font></span><br><br>

        <button type="submit" class="pure-button pure-button-primary" name="uploadPost" id="uploadPost" value="Post">Post</button>
    </fieldset>
</form>
</div>
</html>


