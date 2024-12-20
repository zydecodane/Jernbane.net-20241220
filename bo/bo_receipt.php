<?php
// include('config.php');

?>
<br>
<div id="bo_heading">
  <span style="font-size: 20px; float: left; margin-top: 3px;">Bildene er opplastet, du må nå velge forum for presentasjon!</span>
  <span class="version_no"><img src="graphics/filler.gif" width="20px" height="1px"><sup>(Bildeopplastning v3.0)</sup></span>
  <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<div class="bo_intro">

<?php

if(isset($_POST['img1'])) {$img1 = $_POST['img1']; } else { $img1=''; }
if(isset($_POST['img2'])) {$img2 = $_POST['img2']; } else { $img2=''; }
if(isset($_POST['img3'])) {$img3 = $_POST['img3']; } else { $img3=''; }
if(isset($_POST['img4'])) {$img4 = $_POST['img4']; } else { $img4=''; }
if(isset($_POST['img5'])) {$img5 = $_POST['img5']; } else { $img5=''; }

if(isset($_POST['filecheck1'])) {$filecheck1 = $_POST['filecheck1']; } else { $filecheck1=''; }
if(isset($_POST['filecheck2'])) {$filecheck2 = $_POST['filecheck2']; } else { $filecheck2=''; }
if(isset($_POST['filecheck3'])) {$filecheck3 = $_POST['filecheck3']; } else { $filecheck3=''; }
if(isset($_POST['filecheck4'])) {$filecheck4 = $_POST['filecheck4']; } else { $filecheck4=''; }
if(isset($_POST['filecheck5'])) {$filecheck5 = $_POST['filecheck5']; } else { $filecheck5=''; }

if(isset($_POST['lastlat'])) {$lastlat = $_POST['lastlat']; } else { $lastlat=''; }
if(isset($_POST['lastlon'])) {$lastlon = $_POST['lastlon']; } else { $lastlon=''; }

// image 1

if ($img1 != '' )
{
	$query = "SELECT * FROM gal_images WHERE navn = '$img1'";
	$result = $db->query($query);
	$imginfo1 = $result->fetch_array();
?>
<br><br>
<table cellspacing="0" cellpadding="1" border="0" class="selecttable">
<tr>
	 <td width="60" valign="top">
	  <b>Bilde 1:</b>
	 </td>
	 <td width="280" valign="top">
	  <?php if ($filecheck1 == 'true') { ?>
	  <img src="<?php echo $imginfo1[2]; ?>" width="250" alt="" class="adm_img" />
	  <?php }
       elseif ($filecheck1 == 'size') {echo 'Avvist: filen er større en 1MB. '; }
       elseif ($filecheck1 == 'false') {echo 'Avvist: filtype ikke tillatt.'; }	
       elseif ($filecheck1 == 'dimension') {echo 'Avvist: Bredden på bildet er større en 1400 piksler.'; }
      ?> 
	 </td>
     <td valign="top">
	  <?php if ($filecheck1 == 'true') { ?>
		<table cellspacing="0" cellpadding="1" border="0" width="700" >
		    <tr>
		      <td width="100" valign="top">
		        Fotograf: 
		      </td>
		      <td valign="top">
		         <?php echo $imginfo1[5]; ?>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      EXIf-data: 
		       </td>
		      <td valign="top">
		         <?php if ($imginfo1[13] != '') {
		         	echo $imginfo1[13]; echo ", "; echo $imginfo1[14]; echo "<br>";
		         	echo $imginfo1[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo1[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $imginfo1[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo1[17]; echo "<br /><br />";
		         	}
		              else {echo "Ingen EXIF-data tilgjengelige."; }
		        ?> 
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">Posisjon:<br></td>
		      <td valign="top">
		      <?php 
	    	      if ($imginfo1[21] == 0)
		       { ?>		       	  
		       	<form name="geo1" method="post" action="subpage.php?s=53">
			       	<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
			       	<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
			       	<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
			       	<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
			       	<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
	       	
			       	<input type="hidden" name="lastlat" value="<?php echo $lastlat; ?>" />
			       	<input type="hidden" name="lastlon" value="<?php echo $lastlon; ?>" />
			       	<input type="hidden" name="is" value="1" />
			       	<input type="submit" name="subgeo4" value="Sett bildet p&aring; verdenskartet" style="width: 250px;" />
		       	</form>
		       	<?php
		       } else { echo 'Bildet innholder geodata';}
		       ?> 
		      <br>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Dato: 
		       </td>
		      <td valign="top">
		       <?php 
		        if ($imginfo1[6]!=0) {
		       echo date('d.m.Y',$imginfo1[6]); }  ?>
		       <br>     
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Tekst: 
		       </td>
		      <td valign="top">
		       <?php echo $imginfo1[4];  ?>
		       <br>     
		      </td>
		    </tr>
		</table>
	<?php } ?>	
   </td>
</tr>
</table>
<br>
 <hr>
 <?php } 
 
// image 2

if ($img2 != '' )
{
	$query = "SELECT * FROM gal_images WHERE navn = '$img2'";
	$result = $db->query($query);
	$imginfo2 = $result->fetch_array();
?>
<br>
<table cellspacing="0" cellpadding="1" border="0" class="selecttable">
<tr>
	 <td width="60" valign="top">
	  <b>Bilde 2:</b>
	 </td>
	 <td width="280" valign="top">
	  <?php if ($filecheck2 == 'true') { ?>
	  <img src="<?php echo $imginfo2[2]; ?>" width="250" alt=""  class="adm_img" />
	  <?php }
       elseif ($filecheck2 == 'size') {echo 'Avvist: fil for stor.'; }
       elseif ($filecheck2 == 'false') {echo 'Avvist: filtype ikke tillatt.'; }
       elseif ($filecheck2 == 'dimension') {echo 'Avvist: bildet dimensjonene er for store.'; }
      ?> 
	 </td>
     <td valign="top">
	  <?php if ($filecheck2 == 'true') { ?>
		<table cellspacing="0" cellpadding="1" border="0" width="700" >
		    <tr>
		      <td width="100" valign="top">
		        Fotograf: 
		      </td>
		      <td valign="top">
		         <?php echo $imginfo2[5]; ?>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      EXIf-data: 
		       </td>
		      <td valign="top">
		         <?php if ($imginfo2[13] != '') {
		         	echo $imginfo2[13]; echo ", "; echo $imginfo2[14]; echo "<br>";
		         	echo $imginfo2[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo2[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $imginfo2[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo2[17]; echo "<br><br>";
		         	}
		              else {echo "Ingen EXIF-data tilgjengelige."; }
		        ?> 
		      </td>
		    </tr>
		     <tr>
		      <td width="100" valign="top">Posisjon:<br></td>
		      <td valign="top">
		      <?php 
	    	      if ($imginfo2[21] == 0)
		       { ?>		       	  
		       	<form name="geo2" method="post" action="subpage.php?s=53">
			       	<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
			       	<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
			       	<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
			       	<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
			       	<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
	       	
			       	<input type="hidden" name="lastlat" value="<?php echo $lastlat; ?>" />
			       	<input type="hidden" name="lastlon" value="<?php echo $lastlon; ?>" />
			       	<input type="hidden" name="is" value="2" />
			       	<input type="submit" name="subgeo4" value="Sett bildet p&aring; verdenskartet" style="width: 250px;" />
		       	</form>
		       	<?php
		       } else { echo 'Bildet innholder geodata';}
		       ?> 
		      <br>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Dato: 
		       </td>
		      <td valign="top">
		       <?php 
		        if ($imginfo2[6]!=0) {
		       echo date('d.m.Y',$imginfo2[6]); }  ?>
		       <br>     
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Tekst: 
		       </td>
		      <td valign="top">
		       <?php echo $imginfo2[4];  ?>
		       <br>     
		      </td>
		    </tr>
		</table>
	<?php } ?>	
   </td>
</tr>
</table>
<br>
 <hr>
 <?php } 
 
// image 3

if ($img3 != '' )
{
	$query = "SELECT * FROM gal_images WHERE navn = '$img3'";
	$result = $db->query($query);
	$imginfo3 = $result->fetch_array();
?>
<br>
<table cellspacing="0" cellpadding="1" border="0" class="selecttable">
<tr>
	 <td width="60" valign="top">
	  <b>Bilde 3:</b>
	 </td>
	 <td width="280" valign="top">
	  <?php if ($filecheck3 == 'true') { ?>
	  <img src="<?php echo $imginfo3[2]; ?>" width="250" alt=""  class="adm_img" />
	  <?php }
       elseif ($filecheck3 == 'size') {echo 'Avvist: fil for stor.'; }
       elseif ($filecheck3 == 'false') {echo 'Avvist: filtype ikke tillatt.'; }	  
       elseif ($filecheck3 == 'dimension') {echo 'Avvist: bildet dimensjonene er for store.'; }
      ?> 
	 </td>
     <td valign="top">
	  <?php if ($filecheck3 == 'true') { ?>
		<table cellspacing="0" cellpadding="1" border="0" width="700" >
		    <tr>
		      <td width="100" valign="top">
		        Fotograf: 
		      </td>
		      <td valign="top">
		         <?php echo $imginfo3[5]; ?>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      EXIf-data: 
		       </td>
		      <td valign="top">
		         <?php if ($imginfo3[13] != '') {
		         	echo $imginfo3[13]; echo ", "; echo $imginfo3[14]; echo "<br>";
		         	echo $imginfo3[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo3[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $imginfo3[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo3[17]; echo "<br><br>";
		         	}
		              else {echo "Ingen EXIF-data tilgjengelige."; }
		        ?> 
		      </td>
		    </tr>
		     <tr>
		      <td width="100" valign="top">Posisjon:<br></td>
		      <td valign="top">
		      <?php 
	    	      if ($imginfo3[21] == 0)
		       { ?>		       	  
		       	<form name="geo3" method="post" action="subpage.php?s=53">
			       	<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
			       	<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
			       	<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
			       	<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
			       	<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
	       	
			       	<input type="hidden" name="lastlat" value="<?php echo $lastlat; ?>" />
			       	<input type="hidden" name="lastlon" value="<?php echo $lastlon; ?>" />
			       	<input type="hidden" name="is" value="3" />
			       	<input type="submit" name="subgeo4" value="Sett bildet p&aring; verdenskartet" style="width: 250px;" />
		       	</form>
		       	<?php
		       } else { echo 'Bildet innholder geodata';}
		       ?> 
		      <br>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Dato: 
		       </td>
		      <td valign="top">
		       <?php 
		        if ($imginfo3[6]!=0) {
		       echo date('d.m.Y',$imginfo3[6]); }  ?>
		       <br>     
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Tekst: 
		       </td>
		      <td valign="top">
		       <?php echo $imginfo3[4];  ?>
		       <br>     
		      </td>
		    </tr>
		</table>
	<?php } ?>	
   </td>
</tr>
</table>
<br>
 <hr>
 <?php } 
 
// image 4

if ($img4 != '' )
{
	$query = "SELECT * FROM gal_images WHERE navn = '$img4'";
	$result = $db->query($query);
	$imginfo4 = $result->fetch_array();
?>
<br>
<table cellspacing="0" cellpadding="1" border="0" class="selecttable">
<tr>
	 <td width="60" valign="top">
	  <b>Bilde 4:</b>
	 </td>
	 <td width="280" valign="top">
	  <?php if ($filecheck4 == 'true') { ?>
	  <img src="<?php echo $imginfo4[2]; ?>" width="250" alt=""  class="adm_img" />
	  <?php }
       elseif ($filecheck4 == 'size') {echo 'Avvist: fil for stor.'; }
       elseif ($filecheck4 == 'false') {echo 'Avvist: filtype ikke tillatt.'; }	  
       elseif ($filecheck4 == 'dimension') {echo 'Avvist: bildet dimensjonene er for store.'; }
      ?> 
	 </td>
     <td valign="top">
	  <?php if ($filecheck4 == 'true') { ?>
		<table cellspacing="0" cellpadding="1" border="0" width="700" >
		    <tr>
		      <td width="100" valign="top">
		        Fotograf: 
		      </td>
		      <td valign="top">
		         <?php echo $imginfo4[5]; ?>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      EXIf-data: 
		       </td>
		      <td valign="top">
		         <?php if ($imginfo4[13] != '') {
		         	echo $imginfo4[13]; echo ", "; echo $imginfo4[14]; echo "<br>";
		         	echo $imginfo4[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo4[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $imginfo4[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo4[17]; echo "<br><br>";
		         	}
		              else {echo "Ingen EXIF-data tilgjengelige."; }
		        ?> 
		      </td>
		    </tr>
		     <tr>
		      <td width="100" valign="top">Posisjon:<br></td>
		      <td valign="top">
		      <?php 
	    	      if ($imginfo4[21] == 0)
		       { ?>		       	  
		       	<form name="geo4" method="post" action="subpage.php?s=53">
			       	<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
			       	<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
			       	<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
			       	<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
			       	<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
	       	
			       	<input type="hidden" name="lastlat" value="<?php echo $lastlat; ?>" />
			       	<input type="hidden" name="lastlon" value="<?php echo $lastlon; ?>" />
			       	<input type="hidden" name="is" value="4" />
			       	<input type="submit" name="subgeo4" value="Sett bildet p&aring; verdenskartet" style="width: 250px;" />
		       	</form>
		       	<?php
		       } else { echo 'Bildet innholder geodata';}
		       ?> 
		      <br>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Dato: 
		       </td>
		      <td valign="top">
		       <?php 
		        if ($imginfo4[6]!=0) {
		       echo date('d.m.Y',$imginfo4[6]); }  ?>
		       <br>     
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Tekst: 
		       </td>
		      <td valign="top">
		       <?php echo $imginfo4[4];  ?>
		       <br>     
		      </td>
		    </tr>
		</table>
	<?php } ?>	
   </td>
</tr>
</table>
<br>
 <hr>
 <?php } 
 
 
// image 5

if ($img5 != '' )
{
	$query = "SELECT * FROM gal_images WHERE navn = '$img5'";
	$result = $db->query($query);
	$imginfo5 = $result->fetch_array();
?>
<br>
<table cellspacing="0" cellpadding="1" border="0" class="selecttable">
<tr>
	 <td width="60" valign="top">
	  <b>Bilde 5:</b>
	 </td>
	 <td width="280" valign="top">
	  <?php if ($filecheck5 == 'true') { ?>
	  <img src="<?php echo $imginfo5[2]; ?>" width="250" alt=""  class="adm_img" />
	  <?php }
       elseif ($filecheck5 == 'size') {echo 'Avvist: fil for stor.'; }
       elseif ($filecheck5 == 'false') {echo 'Avvist: filtype ikke tillatt.'; }	  
       elseif ($filecheck5 == 'dimension') {echo 'Avvist: bildet dimensjonene er for store.'; }
      ?> 
	 </td>
     <td valign="top">
	  <?php if ($filecheck5 == 'true') { ?>
		<table cellspacing="0" cellpadding="1" border="0" width="700" >
		    <tr>
		      <td width="100" valign="top">
		        Fotograf: 
		      </td>
		      <td valign="top">
		         <?php echo $imginfo5[5]; ?>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      EXIf-data: 
		       </td>
		      <td valign="top">
		         <?php if ($imginfo5[13] != '') {
		         	echo $imginfo5[13]; echo ", "; echo $imginfo5[14]; echo "<br>";
		         	echo $imginfo5[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo5[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $imginfo5[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $imginfo5[17]; echo "<br><br>";
		         	}
		              else {echo "Ingen EXIF-data tilgjengelige."; }
		        ?> 
		      </td>
		    </tr>
		     <tr>
		      <td width="100" valign="top">Posisjon:<br></td>
		      <td valign="top">
		      <?php 
	    	      if ($imginfo5[21] == 0)
		       { ?>		       	  
		       	<form name="geo5" method="post" action="subpage.php?s=53">
			       	<input type="hidden" name="img1" value="<?php echo $img1; ?>" />
			       	<input type="hidden" name="img2" value="<?php echo $img2; ?>" />
			       	<input type="hidden" name="img3" value="<?php echo $img3; ?>" />
			       	<input type="hidden" name="img4" value="<?php echo $img4; ?>" />
			       	<input type="hidden" name="img5" value="<?php echo $img5; ?>" />
	       	
			       	<input type="hidden" name="lastlat" value="<?php echo $lastlat; ?>" />
			       	<input type="hidden" name="lastlon" value="<?php echo $lastlon; ?>" />
			       	<input type="hidden" name="is" value="5" />
			       	<input type="submit" name="subgeo5" value="Sett bildet p&aring; verdenskartet" style="width: 250px;" />
		       	</form>
		       	<?php
		       } else { echo 'Bildet innholder geodata';}
		       ?> 
		      <br>
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Dato: 
		       </td>
		      <td valign="top">
		       <?php 
		        if ($imginfo5[6]!=0) {
		       echo date('d.m.Y',$imginfo5[6]); }  ?>
		       <br>     
		      </td>
		    </tr>
		    <tr>
		      <td width="100" valign="top">
		      Tekst: 
		       </td>
		      <td valign="top">
		       <?php echo $imginfo5[4];  ?>
		       <br>     
		      </td>
		    </tr>
		</table>
	<?php } ?>	
   </td>
</tr>
</table>
<br>
 <hr>
 <?php } ?> 
 
  

<table callpadding="0" cellspacing="0" border="0" width="100%">
 <tr>
  <td width="60">
  </td>
  <td width="280">
   <br>
    <form name="more" action="subpage.php?s=61" method="post">
    <br>
		<input type="submit" value="Last opp flere..." style="width: 250px;" />
	</form>
	<br />
	<form name="ny2" action="https://jernbane.net" method="post" target="_blank">
		<input type="submit" value="Velg forum for å vise ditt bilde" style="width: 250px; text-align: center;" />
		<br>
	</form>
	<br />
<button onclick=" window.open('https://jernbane.net/forum/forums/14903/','_blank')" style="width: 250px; text-align: center;">Bistrovogna</button>
<br /><br />
	<button onclick=" window.open('https://jernbane.net/forum/forums/interrailvogna/','_blank')" style="width: 250px; text-align: center;">Interrailvogna</button>
	<br /><br />
<button onclick=" window.open('https://jernbane.net/forum/forums/premium_class/','_blank')" style="width: 250px; text-align: center;">Premium Class Photo</button>
<br /><br />
    <button onclick=" window.open('https://jernbane.net/forum/forums/14912/','_blank')" style="width: 250px; text-align: center;">Sporvei, Metro, Light Rail</button>
<br /><br />
   <button onclick=" window.open('https://jernbane.net/forum/forums/4063/','_blank')" style="width: 250px; text-align: center;">Bus 4 Us</button>
<br /><br />
    <button onclick=" window.open('https://jernbane.net/forum/forums/14919/','_blank')" style="width: 250px; text-align: center;">Det Maritime Hjørnet</button>
<br /><br />
  </td>

<?php
 // preparing phorum-code for clipboard
 $imgtekst1 = $imginfo1[4] ?? '';
 $imgtekst2 = $imginfo2[4] ?? '';
 $imgtekst3 = $imginfo3[4] ?? '';
 $imgtekst4 = $imginfo4[4] ?? '';
 $imgtekst5 = $imginfo5[4] ?? '';

 $urltext = '[URL="https://jernbane.net/bo/subpage.php?s=0&id=';

 $phorumcode = '';

 if (isset($imginfo1[0])) { $phorumcode .= 
	$urltext . $imginfo1[0] .'"][IMG alt="' . htmlspecialchars($imgtekst1)
	. '"] '.$imginfo1[1].'[/IMG][/URL]'."\n\n" ; };

if (isset($imginfo2[0])) { $phorumcode .= 
	$urltext . $imginfo2[0] .'"][IMG alt="' . htmlspecialchars($imgtekst2)
	. '"] '.$imginfo2[1].'[/IMG][/URL]'."\n\n" ; };

if (isset($imginfo3[0])) { $phorumcode .= 
	$urltext . $imginfo3[0] .'"][IMG alt="' . htmlspecialchars($imgtekst3)
	. '"] '.$imginfo3[1].'[/IMG][/URL]'."\n\n" ; };

if (isset($imginfo4[0])) { $phorumcode .= 
	$urltext . $imginfo4[0] .'"][IMG alt="' . htmlspecialchars($imgtekst4)
	. '"] '.$imginfo4[1].'[/IMG][/URL]'."\n\n" ; };

if (isset($imginfo5[0])) { $phorumcode .= 
	$urltext . $imginfo5[0] .'"][IMG alt="' . htmlspecialchars($imgtekst5)
	. '"] '.$imginfo5[1].'[/IMG][/URL]'."" ; };
		
			
//  if (isset($imginfo1[0])) { $phorumcode .= '[img]'.$imginfo1[1].'[/img]'."\n\n" ; }
//  if (isset($imginfo2[0])) { $phorumcode .= '[img]'.$imginfo2[1].'[/img]'."\n\n"; }
//  if (isset($imginfo3[0])) { $phorumcode .= '[img]'.$imginfo3[1].'[/img]'."\n\n"; }
//  if (isset($imginfo4[0])) { $phorumcode .= '[img]'.$imginfo4[1].'[/img]'."\n\n"; }
//  if (isset($imginfo5[0])) { $phorumcode .= '[img]'.$imginfo5[1].'[/img]'."" ; }

 ?>
  <td valign="top">
    Forum-kode til kopiering - <button id="copyButton">Kopier kodene til utklippstavlen</button><br><br>
    <textarea name="forumkode" rows="16" style="width: 700px; font-size: 12px; border: 1px solid #800000;" id="copyTarget"><?php echo $phorumcode  ?></textarea>
  </td>
 <tr>
</table>  
<br>  
</div>


    <script type="text/javascript">
        document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboard(document.getElementById("copyTarget"));
});

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
    </script>


<br /><br />


