<?php

session_start();
require_once('connection.php');
require_once('Input_sanitisation.php');


if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

//$myusername=$_POST['myusername']; 
//$mypassword=$_POST['mypassword'];  

$myusername = sanitiseInput($_POST['myusername']);
$mypassword = sanitiseInput($_POST['mypassword']);

$stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where  username='$myusername' and userpassword='$mypassword' ");
oci_execute($stid);

$row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
if($row <= 0){
  die("Wrong username and password entered!");  
}

//$myusername=$_POST['myusername']; 
//$mypassword=$_POST['mypassword'];  
$_SESSION['myusername'] = $myusername;
$_SESSION['mypassword'] = $mypassword;
header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php");
exit();

oci_free_statement($stid);
oci_close($dbh);

?>


