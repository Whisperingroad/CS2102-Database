<?php
session_start();

require_once('connection.php');
require_once('Input_sanitisation.php');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

if (isset($_POST['post_title'], $_POST['post_time'], $_POST['post_username'])){ 
  $_SESSION['post_title'] = $_POST['post_title'];
  $_SESSION['post_time'] = $_POST['post_time'];
  $_SESSION['post_username'] = $_POST['post_username'];
}

$messageErr="";
if($_POST && isset($_POST['message']))
{
//error_reporting(E_ERROR | E_PARSE);
$mytext = $_POST['message'];

$mytext = sanitiseInput($mytext);

if (empty($mytext)){
	$messageErr = "* Post content is required";
	}
else{
  $sql = "UPDATE POST_WRITEPOST SET post_content = '$mytext' 
  WHERE post_title = '".$_SESSION['post_title']."' AND post_time = '".$_SESSION['post_time']."' AND post_username = '".$_SESSION['post_username']."'" ;
  $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        oci_free_statement($stid);    
        header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewEdit.php");
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
<div class = "HotPosts"> 
<?php
      echo "<ul class =". "HotPostsList>";  
      //retrieve post
      $sql = "SELECT post_title, post_content , post_time, post_username, pvotes FROM POST_WRITEPOST 
      WHERE post_title = '".$_SESSION['post_title']."'  AND post_username = '".$_SESSION['post_username']."' 
        AND post_time = '".$_SESSION['post_time']."'";
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid, OCI_DEFAULT);
        $row = oci_fetch_array($stid); 
        oci_free_statement($stid);

      //get reputation of user
        $sql = "SELECT reputation FROM REGISTERED_USER WHERE username = '".$_SESSION['post_username']."'"; 
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid);
        $row1 = oci_fetch_array($stid,OCI_DEFAULT);
        oci_free_statement($stid);

        echo '<li id ="post_title"> '. $row['POST_TITLE']. '';
        echo '<li id ="post_content">'.$row['POST_CONTENT']. '</li>';
        echo '<li id ="post_username">'. $row['POST_USERNAME'].' '.$row1[0].' Points</li>';
        echo "<li id =". "post_time>". $row['POST_TIME']. "  ". $row['PVOTES']." Vote(s)</li>";
        echo "</ul>";     
?>
</div>
<div class="center">
<form class="pure-form pure-form-stacked" method="POST" action="Edit.php" accept-charset="UTF-8">
    <fieldset>
	<div class="heading1">
        <legend>Share your thoughts with our community!</legend>
	</div>
	<font color="red">* Required fields</font>
        <label for="message">Post<font color="red">*</font></label>
	<textarea class="pure-input-1-2"  rows="30" cols="50" name="message" id="message" placeholder="Modify your post here."></textarea><span class="error"><font color="red"><?php echo $messageErr; ?></font></span><br><br>

        <button type="submit" class="pure-button pure-button-primary" name="uploadPost" id="uploadPost" value="Modify">Modify</button>
    </fieldset>
</form>
</div>
</html>


