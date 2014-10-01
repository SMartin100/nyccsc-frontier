<?php
require("../../php/nyccsc/dbinfo_nyccsc.php");

// Get parameters from URL
$lat1 = $_GET["lat1"];
$lon1 = $_GET["lon1"];
$lat2 = $_GET["lat2"];
$lon2 = $_GET["lon2"];

// Open a connection to PostgreSQL server
$connection=pg_connect ("dbname=$database user=$user password=$password host=$host port=$port");
if (!$connection) {
  die("Not connected : " . pg_error());
}

// Build SQL SELECT Statement.
$query = "SELECT a.tablename, summed.opacity FROM admin.metadata AS a JOIN 


(SELECT
   unnest(array['spdes', 'usgs_streamflow', 'historicdeclarations_ny','nfhl','alsc']) AS tablename,
   unnest(array[(CASE WHEN sum(spdes)> 0 THEN 1 ELSE 0.3 END), 
   (CASE WHEN sum(usgs_streamflow)> 0 THEN 1 ELSE 0.3 END), 
   (CASE WHEN sum(historicdeclarations)> 0 THEN 1 ELSE 0.3 END),
   (CASE WHEN sum(nfhl)> 0 THEN 1 ELSE 0.3 END),
   (CASE WHEN sum(alsc)> 0 THEN 1 ELSE 0.3 END)]) AS opacity
        FROM admin.grid5km_datasetscounts AS a
        WHERE 
        ST_Intersects(
              a.geom, (
                ST_Transform(
                  ST_SetSRID(
                    ST_GeomFromText('POLYGON(($lon2 $lat2,$lon2 $lat1, $lon1 $lat1, $lon1 $lat2,$lon2 $lat2))')
                  ,4326)
                ,26918))
            )) AS summed

         ON a.tablename =summed.tablename
         ORDER BY a.tablename";


$result = pg_exec($connection, $query);
if (!$result) {printf ("ERROR"); exit;}

//fetch result
$resultArray = pg_fetch_all($result);

//create json
echo json_encode($resultArray);

/*$f = fopen("countyREST.json", "w"); 
fwrite($f, json_encode($resultArray)); 
fclose($f);*/
?>