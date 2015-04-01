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
<head>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<style>
.center {
    margin-left: auto;
    margin-right: auto;
    width: 70%;
}
</style>
</head>

<div class="center">
<form class="pure-form pure-form-stacked" method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">
    <fieldset>
        <legend>New Post!</legend>
        <font color="red">* Required fields</font>
        <label for="mytitle">Title<font color="red">*</font></label>
        <input name="mytitle" id="mytitle" type="text" placeholder="Title" value="<?PHP if(isset($_POST['mytitle'])) echo htmlspecialchars($_POST['mytitle']); ?>">

        <label for="mytopic">Topic</label>
        <input name="mytopic" id="mytopic" type="text" placeholder="Topic" value="<?PHP if(isset($_POST['mytopic'])) echo htmlspecialchars($_POST['mytopic']); ?>">

        <label for="message">Post<font color="red">*</font></label>
        <textarea class="pure-input-1-2"  rows="30" cols="50" name="message" id="message" placeholder="Start your post here."><?PHP if(isset($_POST['message'])) echo htmlspecialchars($_POST['message']); ?></textarea>

        <button type="submit" class="pure-button pure-button-primary" name="uploadPost" id="uploadPost" value="Post">Post</button>
    </fieldset>
</form>
</div>
</html>
<?php

if($_POST && isset($_POST['uploadPost'], $_POST['mytitle'], $_POST['mytopic'], $_POST['message']))
{
error_reporting(E_ERROR | E_PARSE);
$mytitle = $_POST['mytitle'];
$mytopic = $_POST['mytopic'];
$mytext = $_POST['message'];

if(empty($mytitle) || empty($mytext)) {
   echo '<font color="red">Please enter required fields!</font>';
}
$sql = "INSERT INTO POST_WRITEPOST(post_title, post_content, post_username) VALUES ('$mytitle','$mytext', '".$_SESSION['myusername']."')";
$stid = oci_parse($dbh, $sql);
oci_execute($stid);
oci_free_statement($stid);
}
?>
