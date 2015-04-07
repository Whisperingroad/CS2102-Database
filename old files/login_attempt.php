<?php

session_start();
include 'connection.php';
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];  
$_SESSION['myusername'] = $myusername;

$stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where  username='$myusername' and userpassword='$mypassword' ");
oci_execute($stid);


$row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
if($row <= 0){
  die("Wrong username and password entered!");  
}

/**
// Fetch each row in an associative array
print '<table border="1">';
while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
   print '<tr>';
   foreach ($row as $item) {
       print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
   }
   print '</tr>';
}
print '</table>';

**/
?>

<?php
oci_free_statement($stid);
oci_close($dbh);
?>

<!--<a href="Profile.php">Profile</a>
<a href="Post.php">Post</a> -->

