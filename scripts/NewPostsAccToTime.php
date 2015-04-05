<?php

include 'connection.php';
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }

$sql = "SELECT * FROM (SELECT p.post_title, p.post_time FROM post_writepost p ORDER BY p.post_time desc) WHERE ROWNUM <=5";




$stid = oci_parse($dbh,$sql);
oci_execute($stid,OCI_DEFAULT);

//echo"<b>SQL:</b>".$sql."<br><br>";

echo"<b><h1> 30 NEW POSTS OF THE DAY </h1></b>";

echo "<table>";
while($row = oci_fetch_array($stid)){
    echo "<tr>";
    //echo"$row[0]"."<br>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    //echo "<tr>";
    //echo"$row[1]"."<br>";
    echo "</tr>";
}

echo "</table>"
?>




<?php
oci_free_statement($stid);
oci_close($dbh);
?>