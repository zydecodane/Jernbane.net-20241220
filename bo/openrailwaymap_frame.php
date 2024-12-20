<?php
$lat=$_GET['lat'];
$lon=$_GET['lon'];
?>
<br />
<div id="posthylla_heading">
   <img src="graphics/filler.gif" width="10px" height="23px" />
   Sett fotografens plassering !

   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
  </div>
<div class="posthylla_frame">
<br />
<iframe src="openrailwaymap.php?lat=<?php echo $lat; ?>&lon=<?php echo $lon; ?>" width="1260" height="700" scrolling="no" frameborder="0"></iframe>
<br />
<br />
      
</div>
<br />