<div style="width: 520px; height: 300px; border: 1px solid black;"> 
		  <div id="mapdiv"></div>
		  <script src="../openlayers/OpenLayers.js"></script>
		  <script>
		    map = new OpenLayers.Map("mapdiv");
		    map.addLayer(new OpenLayers.Layer.OSM());
		    var lonLat = new OpenLayers.LonLat( 9.409397,55.049677 )
		          .transform(
		            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
		            map.getProjectionObject() // to Spherical Mercator Projection
		          );
		    var zoom=16;
		    var markers = new OpenLayers.Layer.Markers( "Markers" );
		    map.addLayer(markers);
		    markers.addMarker(new OpenLayers.Marker(lonLat));		 
		    map.setCenter (lonLat, zoom);
		  </script>
		</div>
