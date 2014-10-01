<?php
require("../../php/nyccsc/dbinfo_nyccsc.php");



// Open a connection to PostgreSQL server
$connection=pg_connect ("dbname=$database user=$user password=$password host=$host port=$port");
if (!$connection) {
  die("Not connected : " . pg_error());
}

// Build SQL SELECT Statement.
$query = "SELECT 1 AS opacity, a.* FROM admin.metadata AS a WHERE a.toc = 'TRUE' ORDER BY a.name;";


$result = pg_exec($connection, $query);
if (!$result) {printf ("ERROR"); exit;}

//fetch result
$resultArray = pg_fetch_all($result);

//create json
echo json_encode($resultArray);

$f = fopen("metadata.json", "w"); 
fwrite($f, json_encode($resultArray)); 
fclose($f);
?>