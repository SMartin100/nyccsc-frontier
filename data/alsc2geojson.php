<?php
/**
 * Title:   PostGIS to GeoJSON
 * Notes:   Query a PostGIS table or view and return the results in GeoJSON format, suitable for use in OpenLayers, Leaflet, etc.
 * Author:  Bryan R. McBride, GISP
 * Contact: bryanmcbride.com
 * GitHub:  https://github.com/bmcbride/PHP-Database-GeoJSON
 */
session_start();

require("../../php/nyccsc/dbinfo_fest.php");


$conn = new PDO("pgsql:host=$host;dbname=$database","$user","$password");

# Build SQL SELECT statement and return the geometry as a GeoJSON element
$sql = "SELECT a.pond,a.pondname AS name, public.ST_AsGeoJSON(public.ST_Transform(a.geom,4326),6) as geojson, array_to_string(array_agg(b.species), ', '::text) AS specieslist,
    MAX(SUBSTR(b.monthyear,4,7)::integer) AS fishsurveydate, c.avgph
   FROM alsc.pond_locations AS a JOIN alsc.fish AS b ON a.pond=b.id
    JOIN (SELECT pond,AVG(labph)::numeric(2,1) as avgph FROM alsc.pondchemistry_2 GROUP BY pond)
    AS c ON a.pond=c.pond
  GROUP BY a.pond,a.pondname,a.geom,c.avgph";

# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}

# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $properties = $row;
    # Remove geojson and geometry fields from properties
    unset($properties['geojson']);
    unset($properties['the_geom']);
    $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode($row['geojson'], true),
         'properties' => $properties
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}

header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$f = fopen("alsc.geojson", "w"); 
fwrite($f, json_encode($geojson)); 
fclose($f);

$conn = NULL;
?>