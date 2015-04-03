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
?>
