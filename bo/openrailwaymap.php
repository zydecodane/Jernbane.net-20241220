<?php
$lat=$_GET['lat'];
$lon=$_GET['lon'];
?>
<html>
<head>
	<title></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin="">
    </script>	
</head>
<body>
<div id="mapid" style="width: 100%; height: 98%;"></div>
<script>
	var mymap = L.map('mapid').setView([<?php echo $lat; ?>, <?php echo $lon; ?>], 12);
	
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		tileSize: 512,
		maxZoom: 22,
		zoomOffset: -1,
		id: 'mapbox/outdoors-v11',
		accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
		}).addTo(mymap);		
   
    var openrailwaymap = new L.TileLayer('http://{s}.tiles.openrailwaymap.org/maxspeed/{z}/{x}/{y}.png',
{
	minZoom: 2,
	maxZoom: 22,
	tileSize: 256
}).addTo(mymap);
    
 
	L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(mymap)

	var popup = L.popup();
</script>
</body>
</html>
