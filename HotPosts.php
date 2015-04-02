<?php

include 'connection.php';
if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }


//alternatively we can also change the number of rows that will appear to be chosen based on user's reference, here we fix it at 30 posts with the most number of votes

$sql = "SELECT * FROM (SELECT p.post_title FROM post_writepost p ORDER BY p.pvotes desc) WHERE ROWNUM <=5"; 

/** $sql = "SELECT p.post_title 
        FROM post_writepost p 
        WHERE ROWNUM <=5 
        ORDER BY p.pvotes desc"; **/ 
      


$stid = oci_parse($dbh,$sql);
oci_execute($stid,OCI_DEFAULT);

//echo"<b>SQL:</b>".$sql."<br><br>";

//echo "<table>";
while($row = oci_fetch_array($stid)){
   // echo"$row[0]"."<br>";
    //echo "<tr>";
    echo"$row[0]"."<br>";
    //echo "<tr>";
    
}

//echo "</table>"
?>

<?php
oci_free_statement($stid);
oci_close($dbh);
?>