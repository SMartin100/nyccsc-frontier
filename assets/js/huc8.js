var huc8 = new L.GeoJSON(null, {
    style: {
                clickable: true,
                weight: 2,
                color: 'orange',
                opacity: 1,
                fill: true,
                fillOpacity: 0

    },

    onEachFeature: function (feature, layer) {
        

        if (feature.properties) {
            
            layer.bindPopup(
                "<strong>" + feature.properties.name + " River Watershed </strong> </br>HUC Code: " + feature.properties.huc8,  {
                closeButton: false
            });
        }
        huc8Search.push({
            name: layer.feature.properties.name,
            source: "huc8",
            id: L.stamp(layer),
            bounds: layer.getBounds()
        });

    }
});

$.getJSON("data/basin.geojson", function (data) {
    huc8.addData(data);
});