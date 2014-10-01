
 var trout_streams = new L.TileLayer.WMS("http://frontierspatial.com:8080/geoserver/nyccsc/wms", {
  layers: 'nyccsc:trout_streams',
  format: 'image/png',
  transparent: true,
  opacity: 1,
  zIndex: 100
});  

map.addLayer(trout_streams);
