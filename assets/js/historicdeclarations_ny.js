
function getColor(d) {
    return d > 100 ? '#800026' :
           d > 20  ? '#BD0026' :
           d > 15  ? '#E31A1C' :
           d > 10  ? '#FC4E2A' :
           d > 5   ? '#FD8D3C' :
           d > 2   ? '#FEB24C' :
           d > 1   ? '#FED976' :
                      '#FFEDA0';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.total1964_2013),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}



var historicdeclarations_ny = new L.GeoJSON(null, {
    style: function (feature) {
      return {
        fillColor: getColor(feature.properties.total1964_2013),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
      };
    },
    onEachFeature: function (feature, layer) {
        if (feature.properties) {
            var content =  "<b>FEMA Declared Emergencies <br>"+ feature.properties.name + " County</b></br><table class='table table-striped table-bordered table-condensed'>"+
                                "<tr><th>Type</th><th>1964-2000</th><th>2000-2013</th><th>Total</th></tr>"+
                                "<tr><td>Flood</td><td>" + feature.properties.flood1964_2000 + "</td><td>" + feature.properties.flood2000_2013 + "</td><td>" + feature.properties.flood1964_2013 + "</td></tr>"+
                                "<tr><td>Storm</td><td>" + feature.properties.storm1964_2000 + "</td><td>" + feature.properties.storm2000_2013 + "</td><td>" + feature.properties.storm1964_2013 + "</td></tr>"+
                                "<tr><td>Snow</td><td>" + feature.properties.snow1964_2000 + "</td><td>" + feature.properties.snow2000_2013 + "</td><td>" + feature.properties.snow1964_2013 + "</td></tr>"+
                                "<tr><td>All</td><td>" + feature.properties.total1964_2000 + "</td><td>" + feature.properties.total2000_2013 + "</td><td>" + feature.properties.total1964_2013 + "</td></tr>"+
                            "<table>";

            if (document.body.clientWidth <= 767) {
                layer.on({
                    click: function(e) {
                        $("#feature-title").html(feature.properties.NAME);
                        $("#feature-info").html(content);
                        $("#featureModal").modal("show");
                    }
                });

            } else {
                layer.bindPopup(content, {
                    maxWidth: "auto",
                    closeButton: false
                });
            };
            /*            layer.bindPopup("<b>" + feature.properties.name + " County</br>Declared Emergencies <br></b><table class='table table-striped table-bordered table-condensed'>
                                    <tr><th>Type</th><th>1964-2000</th><th>2000-2013</th><th>Total 1964-2013</th></tr></table>" + feature.properties.total1964_2013, {
               closeButton: false
            });*/
        }
    }
});

/*$.getJSON("data/historicdeclarations_ny.geojson", function (data) {
    historicdeclarations_ny.addData(data);
});*/