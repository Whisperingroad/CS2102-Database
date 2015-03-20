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

$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];  

$stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where  username='$myusername' and userpassword='$mypassword' ");
oci_execute($stid);



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

	oci_free_statement($stid);
	oci_close($dbh);

?>

