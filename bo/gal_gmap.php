<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API v3 Example: Markers with infowindows</title>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<style type="text/css">
 html, body { height: 100%; }
</style>

<?php
 include('configi.php');
$q=0;
 $query = "SELECT id, thumb, tekst, fotograf, latitude, longitude FROM gal_images WHERE latitude <> 0 AND posthylla = 1";
  $result = $db->query($query);

 while ($row = $result->fetch_array() ){
 $img_id[$q] = $row[0];
 $img_thumb[$q] = $row[1];
 $img_tekst[$q] = $row[2];
 $img_fotograf[$q] = $row[3];
 $img_lat[$q] = $row[4];
 $img_lon[$q] = $row[5];
 $q=$q+1;
 }
 
?>

<script type="text/javascript">
//<![CDATA[
var map = null;
function initialize() {
  var myOptions = {
    zoom: 6,
    center: new google.maps.LatLng(59.91103,10.753469),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.MAP 
  }

  map = new google.maps.Map(document.getElementById("map_canvas"),
                                myOptions);
  google.maps.event.addListener(map, 'click', function() {
       infowindow.close();
        });

  // Add markers to the map
  // Set up three markers with info windows




<?php
  for ($r = 0 ; $r<$q ; $r++)
  {
?>


      var point = new google.maps.LatLng(<?php echo $img_lat[$r]; ?>,<?php echo $img_lon[$r]; ?>);
      var marker = createMarker(point,'<div style="width:250px; height: 220px; font-family: arial; font-size: 11px;"><a href="https://jernbane.net/bo/subpage.php?s=0&id=<?php echo $img_id[$r]; ?>" target="_parent"><img src="<?php echo $img_thumb[$r]; ?>" style="border: 1px solid #000000; width: 240px; max-height: 170px;" /></a><br /><?php echo addslashes(htmlentities($img_tekst[$r])); ?><br />Fotograf: <?php echo htmlentities($img_fotograf[$r]); ?><\/div>')

<?php
  }
?>

}

var infowindow = new google.maps.InfoWindow(
  {
    size: new google.maps.Size(150,50)
  });

function createMarker(latlng, html) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString);
        infowindow.open(map,marker);
        });
}

</script> 
</head>





<body style="margin:0px; padding:0px;" onload="initialize()">

    <div id="map_canvas" style="width: 100%; height: 100%"></div>
    <noscript><p><b>JavaScript must be enabled in order for you to use Google Maps.</b>
      However, it seems JavaScript is either disabled or not supported by your browser.
      To view Google Maps, enable JavaScript by changing your browser options, and then
      try again.</p>
    </noscript>











</body> 

</html> 

