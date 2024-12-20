<?php
$lat=$_GET['lat'];
$lon=$_GET['lon'];
?>
<html>
<head>
</head>
<body style="margin: 0px;">
<div id="Map" style="width: 496px; height: 230px; border: 1px solid black; padding:0px; margin: 0px;"></div>

<script src="openlayers/OpenLayers.js"></script>
<script>
    var lat            = <?php echo $lat; ?>;
    var lon            = <?php echo $lon; ?>;
    var zoom           = 12;

    var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
    var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
    var position       = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);

    map = new OpenLayers.Map("Map");
    var mapnik         = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);

    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
    markers.addMarker(new OpenLayers.Marker(position));

    map.setCenter(position, zoom);
</script>

</body>
</html>