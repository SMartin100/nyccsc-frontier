
 var railroad = new L.TileLayer.WMS("http://frontierspatial.com:8080/geoserver/nyccsc/wms", {
  layers: 'nyccsc:railroad',
  format: 'image/png',
  transparent: true,
  opacity: 1,
  zIndex: 100
});  

map.addLayer(railroad);
