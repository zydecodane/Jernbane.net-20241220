<?php
$lat=$_GET['lat'];
$lon=$_GET['lon'];
?>
<body style="margin: 0px;">
<div id="mapdiv"></div>
		  <script src="openlayers/OpenLayers.js"></script>
		  <script>
		    map = new OpenLayers.Map("mapdiv");
		    map.addLayer(new OpenLayers.Layer.OSM());
		    var lonLat = new OpenLayers.LonLat( <?php echo $lon; ?>,<?php echo $lat; ?> )
		          .transform(
		            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
		            map.getProjectionObject() // to Spherical Mercator Projection
		          );
		    var zoom=12;
		    var markers = new OpenLayers.Layer.Markers( "Markers" );
		    map.addLayer(markers);
		    markers.addMarker(new OpenLayers.Marker(lonLat));		 
		    map.setCenter (lonLat, zoom);
		  </script>

</body>