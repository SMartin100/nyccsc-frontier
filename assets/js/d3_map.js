  var ny_countySearch=[];

  var ny_county = new L.TopoJSON(null, {
      style: {
              clickable: true,
              weight: 2,
              color: 'black',
              opacity: 1,
              fill: true,
              fillOpacity: 0
      },
              

      onEachFeature: function (feature, layer) {
          ny_countySearch.push({
              name: layer.feature.id + " County",
              source: "ny_county",
              id: L.stamp(layer),
              bounds: layer.getBounds(),
              lat: layer.getBounds().getSouthWest().lat,
              lng: layer.getBounds().getSouthWest().lng,
              bounds: layer.getBounds()
          });

          if (feature.properties) {
          
              layer.bindPopup(
                  "<strong>" + feature.id + " County</strong>" ,  {
                  closeButton: false
              });
          }
  /*        layer.on({
              mouseover: function(e) {
                  var layer = e.target;
                  layer.setStyle({
                      weight: 3,
                      color: "#00FFFF",
                      opacity: 1
                  });
                  if (!L.Browser.ie && !L.Browser.opera) {
                      layer.bringToFront();
                  }
              },
              mouseout: function(e) {
                  ny_county.resetStyle(e.target);
              }
          });*/

      }
  });

  $.getJSON("data/ny_county.topojson", function (data) {
      ny_county.addData(data);
  });
  var map = L.map('map').setView([43,-74.5], 6);
  var stamen = L.tileLayer('http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png', {attribution: 'Add some attributes here!'}).addTo(map);
  var baseLayers = {"stamen": stamen};
    var overlays = {
      "Counties": ny_county/*,
      "DOT Regions": ny_dot,
      "DEC Regions": ny_dec,
      "Climate Divisions": ny_clim_div*/
    };
  L.control.layers(baseLayers,overlays).addTo(map);
  var centerPoint = L.circle([map.getCenter().lat, map.getCenter().lng], 200).addTo(map);

  map.on("viewreset", showCenterInfo);
  map.on("drag", showCenterInfo);
  map.on("mousemove", setCurrentPosition);

  var container = d3.select("body").append("div").attr("id","#container");
  var svgContainer = container.append("svg").attr("width", 760).attr("height", 300);

  var size = 15;
  var fontsize = 15;

  var zoomIn = svgContainer.append("rect")
   .attr("x", 0)
   .attr("y", size)
   .attr("width", size)
   .attr("height", size)
   .style("fill","#0f0")
   .on("mouseup",zoomInAction);

 var zoomOut = svgContainer.append("rect")
    .attr("x", size+10)
    .attr("y", size)
    .attr("width", size)
    .attr("height", size)
    .style("fill","#f00")
    .on("mouseup",zoomOutAction);

  var zoomText = svgContainer.append("text")
    .text("Zoomlevel: "+map.getZoom())
    .attr("x", (size * 2)+20)
    .attr("y", size * 2)
    .style("fill","#444")
    .style("font-size",fontsize);

function zoomOutAction(){
    zoomFunction(-1);
  }
function zoomInAction(){
    zoomFunction(1);
  }
function zoomFunction(value){
    var newZoomlevel = map.getZoom() + value
    map.setZoom(newZoomlevel)
    zoomText.text("Zoomlevel: "+newZoomlevel)
  }

  var centerText = svgContainer.append("text")
    .attr("x", 0)
    .attr("y", size * 3)
    .style("fill","#444")
    .style("font-size",fontsize);

  //console.log(map.getBounds()._northEast, map.getBounds()._southWest)
  var group = svgContainer.append('g');
  var scaleLat = d3.scale.linear();
  var scaleLng = d3.scale.linear();

  var currentPos = svgContainer.append('text')
      .style("fill","#444")
      .style("font-size",fontsize)

  showCenterInfo();

  function showCenterInfo(){
      centerText.text("Center Lat: "+map.getCenter().lat.toFixed(4)+" Lng: "+map.getCenter().lng.toFixed(4))
      centerPoint.setLatLng([map.getCenter().lat, map.getCenter().lng])

      defineExtentVisualisation();
           
  }

  function defineExtentVisualisation(){
    var rectangle = [];
    rectangle.push([map.getBounds()._northEast.lat, map.getBounds()._northEast.lng])
    rectangle.push([map.getBounds()._northEast.lat, map.getBounds()._southWest.lng])
    rectangle.push([map.getBounds()._southWest.lat, map.getBounds()._southWest.lng])
    rectangle.push([map.getBounds()._southWest.lat, map.getBounds()._northEast.lng])
    //console.log(rectangle)
     
    scaleLat.domain([map.getBounds()._northEast.lat,map.getBounds()._southWest.lat])
            .range([size*4,size*12]);

    scaleLng.domain([map.getBounds()._southWest.lng, map.getBounds()._northEast.lng])
            .range([0,550]); 

    //console.log(scaleLat.invert(100))
    //console.log(scaleLat(52.30))
    
    group.selectAll('text').remove();
    var coordText = group.selectAll('text').data(rectangle).enter().append("text").text("Hello")
    coordText.attr("x", function(data,i){return scaleLng(data[1])})
      .attr("y", function(data,i){return scaleLat(data[0])})
      .style("fill","#444")
      .style("font-size",fontsize)
      .text(function(data){return "Lat: "+data[0].toFixed(2) +" : Lng: "+ data [1].toFixed(2)});
  }

  function setCurrentPosition(e){ 
    //console.log(e)
    var coordinates = e.latlng; 
    //console.log(coordinates.lat,coordinates.lng);
    currentPos.transition().duration(2000).ease('bounce').attr("x", scaleLng(coordinates.lng))
      .attr("y", scaleLat(coordinates.lat))      
      .text("Lat: "+coordinates.lat.toFixed(2) +" : Lng: "+ coordinates.lng.toFixed(2));
  }