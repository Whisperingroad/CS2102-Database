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
<link type="text/css" rel="stylesheet" href="stylesheets/main.css">
<div id="header">
<h1> Social News Platform </h1>
</div>
<legend>Your post has been uploaded!</legend>
<?php
    $sql = "SELECT post_title, post_content , post_time, post_username, pvotes  FROM POST_WRITEPOST WHERE ((post_title = '".$_SESSION['post_title']."'  AND post_username = '".$_SESSION['myusername']."' )
        AND post_time in(SELECT max(post_time) FROM POST_WRITEPOST))";
        
        $stid = oci_parse($dbh, $sql);
        oci_execute($stid, OCI_DEFAULT);
        while($row = oci_fetch_array($stid)) {
	echo "<h2>" . $row[0] . "</h2>";
        echo "<p>" . $row[1] . "</p>";
	echo "<font color=". "grey". ">" . $row[2] . " Authored by " . $row[3]. "</font><br>";
	
	if (empty($row[4])){
	echo "<u><font color=". "blue". ">0 Votes</font></u>";
	}
	else{
	echo "<u><font color=". "blue". ">" . $row[4] . "</font></u>";
	}	
	}
oci_free_statement($stid);
?>
</html>

