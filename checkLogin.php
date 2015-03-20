<?php
/* Set oracle user login and password info */

$host="sid3.comp.nus.edu.sg"; // Host name 
$username="a0101856"; // Mysql username 
$password="crse1420"; // Mysql password 
$db_name="sid3.comp.nus.edu.sg"; // Database name 
$tbl_name="REGISTERED_USER"; // Table name 

// Connect to server and select databse.
//$connect = @ocilogon($username, $password, $db_name);
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('a0101856', 'crse1420', ' (DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
)
(CONNECT_DATA =
(SERVICE_NAME = sid3.comp.nus.edu.sg)
)
)');
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM REGISTERED_USER WHERE username='$myusername' and userpassword='$mypassword'";
//$result=mysql_query($sql);

// check the sql statement for errors and if errors report them
$statement = oci_parse($connect, $sql);
if(!$statement) {
  echo "An error occurred in parsing the sql string.\n";
  exit;
}

oci_execute($statement);
$ID =0;

if(OCIFetch($statement)) {
  $ID= OCIResult($statement,1); //return the data from column 1
}else {
  echo "An error occurred. \n";
  exit;
}
$ID++;

// Mysql_num_row is counting table row
//$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($ID==1){

// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("myusername");
session_register("mypassword"); 
header("location:login_success.php");
}
else {
echo "Wrong Username or Password";
}
?>
