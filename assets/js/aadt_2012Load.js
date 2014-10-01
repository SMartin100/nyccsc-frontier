
 var aadt_2012 = new L.TileLayer.WMS("http://frontierspatial.com:8080/geoserver/nyccsc/wms", {
  layers: 'nyccsc:aadt_2012',
  format: 'image/png',
  transparent: true,
  opacity: 1,
  zIndex: 100
});  

map.addLayer(aadt_2012);
