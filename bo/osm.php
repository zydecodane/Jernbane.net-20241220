<?php
error_reporting(-1);
ini_set('display_errors', 'On');

include ('configi.php');

$query = "select id, latitude, longitude, thumb, tekst, fotograf from gal_images where latitude > 0 limit 50000";
$result = $db->query($query);

$newline="lat	lon	title	description	iconSize	iconOffset	icon\n";
$posfile = fopen("positions.txt", "w");

while ( $image = $result->fetch_array() ) {

$newline .= $image[1]."\t".$image[2]."\t".'<a href="" target="_parent"><img src="'.$image[3].'" />'."</a>\t \t21,25\t-8,-8\timg/marker.png\n";
}


fwrite($posfile, $newline);
fclose($posfile);





/*


<html>
<head>
<title></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<body>
<style type="text/css">
      html, body, #basicMap {
          width: 100%;
          height: 100%;
          margin: 0;
          }
      img {
       border-style: none;
       display: block;
       margin: 0 auto;
      }          
.img_block {
 width: 252px;
 display: block;
 font-family: arial;
 font-size: 11px;		
}
.image {
 border: 1px solid #000000;	
}
</style>
  <div id="mapdiv"></div>
  <script src="openlayers/OpenLayers.js"></script>
  <script>
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
    
    epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
    projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
   
    var lonLat = new OpenLayers.LonLat( 10 ,60 ).transform(epsg4326, projectTo);
           
    var zoom=6;
    map.setCenter (lonLat, zoom);

    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    
    // Define markers as "features" of the vector layer:

<?php
	while ( $image = $result->fetch_array() ) {
?>    
    
    var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( <?php  echo $image[2]; ?>, <?php echo $image[1]; ?> ).transform(epsg4326, projectTo),
            {description:'<div class="img_block"><a href="subpage.php?s=0&id=<?php echo $image[0]; ?>" target="_parent"><img src="<?php echo $image[3]; ?>" class="image" / ></a><br /><?php echo $image[4]; ?><br />Fotograf:  <?php echo $image[5]; ?></div>'} ,
            {externalGraphic: 'img/marker.png', graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
        );    
    vectorLayer.addFeatures(feature);
<?php
	}
?>
    map.addLayer(vectorLayer);
    
    //Add a selector control to the vectorLayer with popup functions
    var controls = {
      selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    };    
    function createPopup(feature) {
      feature.popup = new OpenLayers.Popup.FramedCloud("pop",
          feature.geometry.getBounds().getCenterLonLat(),
          null,
          '<div class="markerContent">'+feature.attributes.description+'</div>',
          null,
          true,
          function() { controls['selector'].unselectAll(); }
      );
      //feature.popup.closeOnMove = true;
      map.addPopup(feature.popup);
    }

    function destroyPopup(feature) {
      feature.popup.destroy();
      feature.popup = null;
    }
    
    map.addControl(controls['selector']);
    controls['selector'].activate();
</script>
</body>
</html>

*/
?>
