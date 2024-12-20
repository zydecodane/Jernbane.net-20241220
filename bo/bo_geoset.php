<?php
 if(isset($_POST['lastlat'])) {$lastlat = $_POST['lastlat']; } else {$lastlat='';}
 if(isset($_POST['lastlon'])) {$lastlon = $_POST['lastlon']; } else {$lastlon='';}
 if(isset($_POST['retur'])) {$retur = $_POST['retur']; } else {$retur='';}
 if(isset($_POST['page'])) {$page = $_POST['page']; } else {$page='';}
 if(isset($_GET['adm'])) {$adm = $_GET['adm']; } else {$adm=0;}
 if(isset($_GET['id'])) {$id = $_GET['id']; } else {$id=0;}
?>
 <script src="datepicker/geoset.js"></script>
<?php
if ($lastlat !=0) {
?>
<script type="text/javascript">
  var def_zoomval = 10;
  var def_longval = <?php echo $lastlon; ?>;
  var def_latval = <?php echo $lastlat; ?>;
</script>
<?php } ?>


<?php
$back="yes";
?>
<br />
<div id="bo_heading">
   <span style="font-size: 16px;"><b>Set posisjon</b></span>
   <span class="version_no"><img src="graphics/filler.gif" width="20px" height="1px"></span>
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>

<div class="bo_intro">
<?php
if(isset($_POST['img1'])) {$img1 = $_POST['img1']; } else {$img1='';}
if(isset($_POST['img2'])) {$img2 = $_POST['img2']; } else {$img2='';}
if(isset($_POST['img3'])) {$img3 = $_POST['img3']; } else {$img3='';}
if(isset($_POST['img4'])) {$img4 = $_POST['img4']; } else {$img4='';}
if(isset($_POST['img5'])) {$img5 = $_POST['img5']; } else {$img5='';}

if(isset($_POST['lastlat'])) {$lastlat = $_POST['lastlat']; } else {$lastlat='';}
if(isset($_POST['lastlon'])) {$lastlon = $_POST['lastlon']; } else {$lastlon='';}
if(isset($_POST['is'])) {$is = $_POST['is']; }

if (@$is == 1) { $imgx = $img1; }
if (@$is == 2) { $imgx = $img2; }
if (@$is == 3) { $imgx = $img3; }
if (@$is == 4) { $imgx = $img4; }
if (@$is == 5) { $imgx = $img5; }

?>
<br />
<div style="padding-left: 15px;">
Zoom inn, klikk p&aring posisjonen i kartet og deretter klikk 'Sett posisjon'<br />
<br />
</div>
<form action="bo_setposition.php" method="post" name="geosetform">
<input type="hidden" value="" name="longval" id="longval" />
<input type="hidden" value="" name="latval" id="latval" />

<input type="hidden" name="imgx" value="<?php echo $imgx; ?>" />
<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />

<input type="hidden" name="retur" value="<?php echo $retur; ?>" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

<div id="mapid" style="width: 1065px; height: 550px; padding-left: 15px; z-index: 5;"></div>
<script>
	<?php
	if ($lastlat=='') {
	?>
	var mymap = L.map('mapid').setView([57.98481, 11.16211], 5);
	<?php
		} else {
	?>	
	var mymap = L.map('mapid').setView([<?php echo $lastlat; ?>, <?php echo $lastlon; ?>], 10);
  
	var marker = L.marker([<?php echo $lastlat; ?>, <?php echo $lastlon; ?>]).addTo(mymap);
	<?php
		}
	?>
/*
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
tileSize: 512,
maxZoom: 18,
zoomOffset: -1,
id: 'mapbox/outdoors-v11',
accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
}).addTo(mymap);
*/
  
//L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
L.tileLayer('https://tile.openstreetmap.de/{z}/{x}/{y}.png', {  
maxZoom: 19,
attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(mymap);
  
	var popup = L.popup();

	function onMapClick(e) {
		document.getElementById('lat-lng').value = e.latlng.toString();
		popup
			.setLatLng(e.latlng)
			.setContent("Fotografens plassering")
			.openOn(mymap);
	}
	mymap.on('click', onMapClick);
	
</script>
<br />

<?php
if ($lastlat!='') {
$latlong = "LatLng(".$lastlat.", ".$lastlon.")";
} else { $lastlong=''; }
	
?>


	<input type="hidden" name="adm" value="<?php echo $adm ?>" />
	<input type="hidden" name="latval" value="<?php echo $lastlat ?>" />
	<input type="hidden" name="lonval" value="<?php echo $lastlon ?>" />
    <input type="hidden" name="latlng" id="lat-lng" value="<?php echo $latlong; ?>" />
	<input type="submit" value="Sett posisjon" style="width: 200px;" />
	
</form>
      
<br />       
<br />

</div>
<br />
<br /><br />