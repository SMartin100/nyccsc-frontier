
function getGageColors(d) {
            return d == 0 ? '#FFFFFF' :
                   d == 1 ? '#FF0000' :
                   d == 2 ? '#B12121' :
                   d == 3 ? '#B12121' :
                   d == 4 ? '#FFA400' :
                   d == 5 ? '#00FF00' :
                   d == 6 ? '#40DFD0' :
                   d == 7 ? '#0000FF' :
                   d == 8 ? '#000' :
                           '#FFEDA0' ;
        }


// gage
usgs_streamflow = new L.GeoJSON(null, {
    pointToLayer: function (feature, latlng) {
        return L.circleMarker(latlng,  {
            title: feature.properties.name,
            //circleradius
            radius: 4,
            //fill
            fillColor: getGageColors(feature.properties.class),
            fillOpacity: 0.8,
            //border
            color: "black",
            weight: 1,
            opacity: 1
            });
    },
    onEachFeature: function (feature, layer) {
        if (feature.properties) {
            layer.bindPopup("<b>" + feature.properties.name + "</b></br>Updated: " + feature.properties.time + " "+ feature.properties.date + "</br>Stage: " + feature.properties.stage + "</br><a href='" + feature.properties.url + "' target='_blank_'>Link</a>", {
               closeButton: false
            });
        }
/*        gagesearch.push({
            name: layer.feature.properties.NAME,
            source: "place",
            id: L.stamp(layer),
            lat: layer.feature.geometry.coordinates[1],
            lng: layer.feature.geometry.coordinates[0]
        });*/
    }
});