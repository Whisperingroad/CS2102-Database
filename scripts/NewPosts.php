<?php

session_start();
require_once('connection.php');

if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }
$newPosts = array(); 
$stid = oci_parse($dbh,"SELECT * FROM (SELECT pvotes, post_title, post_content, post_username, post_time from post_writepost p ORDER BY p.post_time DESC) where rownum <= 20");
oci_execute($stid);
//associative and numeric
while (($row = oci_fetch_array($stid, OCI_DEFAULT)))
{
  $newPosts[] = array('PVOTES' => $row['PVOTES'], 'POST_TITLE' => $row['POST_TITLE'], 'POST_CONTENT' => $row['POST_CONTENT'], 'POST_USERNAME' => $row['POST_USERNAME'], 'POST_TIME' => $row['POST_TIME']);
 
}

    oci_free_statement($stid);
?>   
