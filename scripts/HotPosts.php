<?php

session_start();
require_once('connection.php');

if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

// creating an array
$hotPosts = array();

// oci_parse prepares an oracle statement for execution
// The SQL text in oci parse is a nested query.
// The inner query selects relevant post information from the post_writepost table and orders the result according to the number of votes the post has, in a descending order.
// The outer query will then select the top 20 rows from the result of the inner query.
// The results of this nested query will be the top 20 posts in the post_writepost table.
$stid = oci_parse($dbh,"SELECT * FROM (SELECT pvotes, post_title, post_content, post_username, post_time from post_writepost  ORDER BY pvotes DESC) where rownum <= 20");
oci_execute($stid);

// oci_fetch_array returns the next row from a query as an associative or numeric array
// By invoking the SQL text above, oci_fetch_array will return an array containing the next result set row of a query.
// The function is called in a while loop until it returns false, indicating that no more result rows exist.
while (($row = oci_fetch_array($stid, OCI_DEFAULT)))
{
	// result rows are arrays
	// store result rows into the hotPosts array
  $hotPosts[] = array('PVOTES' => $row['PVOTES'], 'POST_TITLE' => $row['POST_TITLE'], 'POST_CONTENT' => $row['POST_CONTENT'], 'POST_USERNAME' => $row['POST_USERNAME'], 'POST_TIME' => $row['POST_TIME']);
 
}

    oci_free_statement($stid);
?>   
