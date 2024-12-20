<script type="Text/JavaScript">
		       function check() {
		       	if ((document.getElementById('vote').value > '3')) { 	
		       	
		       	if(document.getElementById('tekst').value == ''){ alert("vennligst skriv en kommentar"); return false;}
		       	if(document.getElementById('tekst').value.length < 15) { alert("Din kommentar m\u00e5 v\346re minst 15 tegn "); return false;}
		       	if(document.getElementById('tekst').value.match(/^\s*$/)){ alert("vennligst skriv en kommentar !!"); return false;}
		       	if(document.getElementById('tekst').value.match("   ")){ alert("vennligst skriv en kommentar, minst 15 tegn."); return false;}
		       	}
}
</script>
<script type="text/javascript" src="../bo/tinybox.js">
</script>
<?php   

// FP testfusk --------------------------------------------------------------
// $userid = 14;
// $ispremiumclass = 1;
// testfusk slut ============================================================

include('func/functions.php');

$back="yes";
 //include ('configi.php');

$id = $_GET['id'];  
if (isset($id)) {

    $query = "select * from `gal_images` where id = '$id'";
    $result = $db->query($query);
    $img = $result->fetch_array();

// Test ==============================================
// var_dump($img);
// Test ===========================================
	if (is_string($img[5])) {
    	$fotograf = html_escape($img[5]);
	} else {
		$fotograf = '';
	}
} else {
    $fotograf = '';
    $url = $_GET['url'];
    $img[1] = "../" . $url;
}

// check if picture of the week

$query = "select uke, aar from gal_ukens where imgid = '$id'";
$result = $db->query($query);
$ukens = $result->fetch_array();

// update counter  
if(!isset($img[19])) {$count=0;} else {$count=$img[19];}  
$count=$count+1;
$query = "update gal_images set visning='$count' where id='$id'";
$result = mysqli_query($db, $query);
?>
<br />
<div id="show_main">
	<div id="show_header">
	    <div style="display: inline_block; width: 5px;">
	    </div>
	    <?php
	      if($img[12]>0) { $stars=round(($img[11]/$img[12])); } else { $stars=0;}
	    ?>
	    <div id="show_top_starcontainer"><img src="graphics/<?php echo $stars; ?>stars.gif" alt="" /></div> 
	    <?php if (@$ukens[0] !='')
	    {
	    	 ?>
	    <div id="show_top_ukenstext"><b>Ukens bilde / picture of the week <?php echo $ukens[0].', ',$ukens[1]; ?></b></div>
	    <?php
	    } 
		else
		{ ?>
		<div id="show_top_ukenstext"><?php echo $img[4]; ?></div>
		<?php
		}
	    ?>
	  <img src="graphics/jernbanenet_h28.gif" alt="" class="logo_align" />
	</div>
	<div class="mobile">
 	 <br />
 	</div> 

      <div id="show_imgcontainer">
      <?php  
      	if ($ispremiumclass > 0) { ?>
 	   <img src="<?php echo $img[1]; ?>" alt="copyright <?php echo $fotograf; ?>" title="copyright <?php echo $fotograf; ?>" class="m_img" />
      <?php }
      else { ?>
       <img src="<?php echo $img[26]; ?>" style="border: 1px solid #800000;" alt="copyright <?php echo $fotograf; ?>" title="copyright <?php echo $fotograf; ?>" />
      <?php } ?>
      </div>
      <div class="mobile">
      	<br />
      </div>	
<div class="show_starbar">

<table width="1220" callpadding="0" cellspacing="0" border="0">
	<tr style="height: 24px;">
<?php
if ($ispremiumclass > 0) {
?>
		<td style="width: 200px; background-color: #800000; text-align: center;">
 			 <span style="font-size: 12px; color: #ffffff; ">Klikk på stjernene for &aring; gi poeng</span>
 		</td>
 		<td style="background-color: #800000; text-align: center;">
  			<img src="graphics/1stars.gif" alt="" border="0" onclick="TINY.box.show({url:'votecontainer.php?id=<?php echo $img[0]; ?>&p=1',width:600,height:410,opacity:50})" style="cursor: pointer;"/>
		</td>
 		<td style="background-color: #800000; text-align: center;">
   			<img src="../bo/graphics/2stars.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer.php?id=<?php echo $img[0]; ?>&p=2',width:600,height:410,opacity:50})" style="cursor: pointer;" /> 
 		</td>
 		<td style="background-color: #800000; text-align: center;">
   			<img src="../bo/graphics/3stars.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer.php?id=<?php echo $img[0]; ?>&p=3',width:600,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; text-align: center;">
   			<img src="../bo/graphics/4stars.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer.php?id=<?php echo $img[0]; ?>&p=4',width:600,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; text-align: center;">
   			<img src="../bo/graphics/5stars.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer.php?id=<?php echo $img[0]; ?>&p=5',width:600,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; text-align: center;">
   			<img src="../bo/graphics/6stars.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer.php?id=<?php echo $img[0]; ?>&p=6',width:600,height:410,opacity:50})" style="cursor: pointer;" />
 		</td>
<?php 
} 
      elseif ($userid > 0) {        
?>
		<td style="width: 1190px; background-color: #800000; text-align: left; padding-left:10px;">
			<span style="font-size: 12px; color: #ffffff;line-height: 17px;"><b>For å få mest glede av Jernbane.Net, lønner det seg å være Premium Class medlem !
Gjør en kontooppgradering under <a class="gal" href="https://jernbane.net/forum/account/upgrades">Din Profil</a>, og du vil få tilgang til alle ressurser på nettstedet.</b></span>
		</td>
<?php         
      }
      
      else {
?>
		<td style="width: 1190px; background-color: #800000; text-align: left; padding-left:10px;">
			<span style="font-size: 12px; color: #ffffff;line-height: 17px;"><b>Det ser ut til at du ikke er registrert hos oss.
              Gå til <a class="gal" href="https://jernbane.net/forum/register/">registeringssiden</a>, fyll ut alle opplysninger som vi ønsker av deg. Send inn skjemaet. En administrator godkjenner innmeldingen. Husk at du må aktivere ditt medlemskap !</b></span>
		</td>
<?php } ?>		
	</tr>
</table>
</div>

<?php
if ($ispremiumclass > 0) {
?>
<div class="mobile_show">
<table width="100%" callpadding="0" cellspacing="0" border="0">
	<tr style="height: 24px;">
		<td style="background-color: #800000; color: #ffffff; text-align: center;">
  			1&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=1',width:300,height:410,opacity:50})" style="cursor: pointer;"/>
		</td>
 		<td style="background-color: #800000; color: #ffffff; text-align: center;">
   			2&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=2',width:300,height:410,opacity:50})" style="cursor: pointer;" /> 
 		</td>
 		<td style="background-color: #800000; color: #ffffff; text-align: center;">
   			3&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=3',width:300,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; color: #ffffff; text-align: center;">
   			4&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=4',width:300,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; color: #ffffff; text-align: center;">
   			5&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=5',width:300,height:410,opacity:50})" style="cursor: pointer;" />
  		</td>
 		<td style="background-color: #800000; color: #ffffff; text-align: center;">
   			6&nbsp;<img src="../bo/graphics/star.gif" alt="" border="0" onclick="TINY.box.show({url:'../bo/votecontainer_mini.php?id=<?php echo $img[0]; ?>&p=6',width:300,height:410,opacity:50})" style="cursor: pointer;" />
 		</td>
 	</tr>
</table>
</div>
<?php } 
if (is_string($img[4])) {
	$pictureText = html_escape($img[4]);
} else {
	$pictureText = '';
}

?>


<script>
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2)-200;
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
<br />
<div style="display: table; vertical-align: top; width: 100%;">

	<div id="show_textcontainer">
			<b><?php echo $pictureText; if ($img[6]!='') { echo", "; echo date('j.n.Y', $img[6]); } ?></b>
			<br /><br />
			<b>Fotograf:</b><br /><?php echo $fotograf; ?>
			<br /><br />
			<b>EXIF-data:</b>
			<br />
		<?php
				if ($img[13] != '') {
				echo $img[13]; echo ", "; echo $img[14]; echo '<br />';
				if (substr($img[15],0,1)!=' ') {
				echo $img[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
				echo $img[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[17];
				echo '<br />'; }
							}
							  else { echo "Ingen EXIF-data tilgjengelige.<br />"; }
		   if ($img[20]==1) {   // bildet er sorteret på plass i gallerierne 
		?>
		<br />
		<div class="mobile_show">
			<?php if ($img[21]!=0) { ?>
			<b>Fotografens plassering:</b><br />
						
			<a href="https://www.openrailwaymap.org/mobile.php?lang=&lat=<?php echo $img[21]; ?>&lon=<?php echo $img[22]; ?>&zoom=12&style=standard" target="_blank" class="galsearch">OpenRailwayMap</a> - <a href="           
            https://www.openstreetmap.org/?mlat=<?php echo $img[21]; ?>&mlon=<?php echo $img[22]; ?>#map=12/<?php echo $img[21]; ?>/<?php echo $img[22]; ?>" class="galsearch" target="_blank">OpenStreetMap</a> - <a href="https://www.google.dk/maps/place/<?php echo $img[21]; ?>,<?php echo $img[22]; ?>" target="_blank" class="galsearch">Google</a> - 
				<a href="https://www.bing.com/maps/default.aspx?rtp=pos.<?php echo $img[21]; ?>_<?php echo $img[22]; ?>&lvl=12" target="_blank" class="galsearch">Bing</a>
		<br /><br />
		<?php } ?>
		</div>
		
		<b>Plassering i gallerierne:</b><br /> 
		<?php
		$ng = 0;
		$query = "select type, nummer, detailID from gal_images where url='$img[1]' and posthylla = 1";
		$result = $db->query($query);
		while ( $gal = $result->fetch_array() ) {
			$typeid[$ng] = $gal[0];
			$nummer[$ng] = $gal[1];
			$detailid[$ng] = $gal[2];
			$ng++;
		}

		for ($mg = 0 ; $mg<$ng ; $mg++) {
			$query2 = "select typename, katid from gal_type where typeid = '$typeid[$mg]'";
			@$tyname[$mg] = $db->query($query2)->fetch_object()->typename;
			@$kid[$mg] = $db->query($query2)->fetch_object()->katid;

			$query3 = "select katname, natid, natnavn from gal_kategori where katid = '$kid[$mg]'";
			@$kname[$mg] = $db->query($query3)->fetch_object()->katname;
			@$nid[$mg] = $db->query($query3)->fetch_object()->natid;
			@$nname[$mg] = $db->query($query3)->fetch_object()->natnavn;
			
			$query4 = "select enhet, info from gal_unit where numid = '$nummer[$mg]'";
			@$enhet[$mg] = $db->query($query4)->fetch_object()->enhet;
			@$info[$mg] = $db->query($query4)->fetch_object()->info;

			$query5 = "select navn, info from gal_unitdetail where detailID = '$detailid[$mg]'";
			@$detail[$mg] = $db->query($query5)->fetch_object()->navn;
			@$detailinfo[$mg] = $db->query($query5)->fetch_object()->info;
		?>
		 <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $nid[$mg]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $nname[$mg]; ?></a> > 
		 <a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $kid[$mg]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kname[$mg]; ?></a> >
		 <a href="<?php echo $path; ?>subpage.php?s=3&t=<?php echo $typeid[$mg]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $tyname[$mg]; ?></a> >
		 <a href="<?php echo $path; ?>subpage.php?s=4&u=<?php echo $nummer[$mg]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $enhet[$mg]; ?></a>
		 <?php if(!empty($detail[$mg])) { ?>
		 > <a href="<?php echo $path; ?>subpage.php?s=8&d=<?php echo $detailid[$mg]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $detail[$mg]; ?></a> 
		 <!-- > <?php echo $detail[$mg]; ?> -->
		 <?php } ?>
		 <br />
		<?php
		}
		  } 
		
		// Vis antal visninger i galleriet
		?>	
		<br /><b>Antall visninger:</b> <?php echo $count; ?>
			<br /><br />	
		<?php	

		if (isset($img[0])) {		
		//$query3 = "select message_id from phorum_search where search_text like '%$img[3]%'";
		//@$msid = $db->query($query3)->fetch_object()->message_id;
		/*
		if ($msid!='') {	
		?>	
		<br /><b>Bildepresentasjon i Postvogna:</b><br />	
		<?php	
		$query = "select message_id, forum_id, thread, subject from phorum_messages where body like '%$img[3]%' limit 3";
		$result4 = $db->query($query);
		while ($forum = $result4->fetch_array()) { ?>
		<a href="<?php echo $path; ?>../phorum/read.php?<?php echo $forum[1]; ?>,<?php echo $forum[2]; ?>,<?php echo $forum[0]; ?>#msg-<?php echo $forum[0]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $forum[3]; ?></a><br />
		<?php  }
		}
		 */
		$slutp = strrpos($img[3],'.',$offset = 0 ); // filtrerer .jpg fr strengen
		?>
		<br />
		<a href="https://jernbane.net/forum/search/?q=<?php echo substr($img[3],0,$slutp); ?>"><b>Søk etter bildet i Forumene</b></a>
		<br /> 
		 
 	   <?php
		if ($img[20]==1) { // hvis bildet er sortert på plass
		if ($info[0]!='' || $detailinfo[0]!='') {
		?>
		   <br /><b>Ytterligere info:</b><br />
		<?php
		}
		if ($info[0]!='') {
			for ($lg = 0 ; $lg<$ng ; $lg++) {
				echo $info[$lg]; echo "<br />";
				if ($lg > 0) { if ($info[$lg] !='') {echo "<br />"; }}
			}
			}

		if ($detailinfo[0]!='') {
			for ($lg = 0 ; $lg<$ng ; $lg++) {
				echo $detailinfo[$lg]; echo "<br />";
				if ($lg > 0) { if ($detailinfo[$lg] !='') {echo "<br />"; }}
			}
			}
		}  

		}
		?>  
		<br />
	</div>
	<div id="show_admincontainer">
		<?php if($isadmin==1) { ?>
			<a href="admin/index.php?s=6&id=<?php echo $img[0]; ?>&page=show"><img src="graphics/edit.png" border="0" alt="endre kategorisering" title="endre kategorisering" style="padding-top:5px;" /></a>
			<a href="admin/index.php?s=7&id=<?php echo $img[0]; ?>&page=show"><img src="graphics/copy.png" border="0" alt="kopiere til ytterligere plassering" title="kopiere til ytterligere plassering" style="padding-top:2px;" /></a><br />
			<a href="../bo/admin/index.php?s=4&id=<?php echo $img[0]; ?>&u=<?php echo $img[10]; ?>&page=gal"><img src="graphics/dele.png" border="0" alt="slett bildet" title="slett bildet" style="padding-top:2px;" /></a>
			<a href="../bo/admin/adm_img_park.php?id=<?php echo $img[0]; ?>&page=show"><img src="graphics/park.png" border="0" alt="parker bildet - vises ikke lengere i gallerierne" title="parker bildet - vises ikke lengere i gallerierne" style="padding-top:2px;" onclick="return confirm('Er du helt sikker p\u00E5 at du vil parkere dette bildet?');" /></a>
			<a href="../bo/admin/index.php?s=15&id=<?php echo $img[0]; ?>&page=show"><img src="graphics/retext.png" border="0" alt="endre tekst på bildet" title="endre tekst på bildet" style="padding-top:2px;" /></a>
			<a href="../bo/admin/index.php?s=5&id=<?php echo $img[0]; ?>&page=show"><img src="graphics/comm.png" border="0" alt="endre eller slette kommentar" title="endre eller slette kommentar" style="padding-top:2px;" /></a>
            <a href="../bo/subpage.php?s=53&id=<?php echo $img[0]; ?>&adm=1"><img src="graphics/geo.png" border="0" alt="endre geodata" title="endre geodata" style="padding-top:2px;" /></a>
		<?php } ?>
	</div>
<?php
	if ($ispremiumclass > 0) { ?>
	<div id="show_mapcontainer">
			<?php if ($img[21]!=0) { ?>
			<b>Fotografens plassering:</b><br />
			<iframe src="bbcode_map.php?lon=<?php echo $img[22]; ?>&lat=<?php echo $img[21]; ?>" style="width: 498px; height: 242px;" scrolling="no" frameborder="0"></iframe>
        Vis større kart: <a href="https://www.openrailwaymap.org/?lang=&lat=<?php echo $img[21]; ?>&lon=<?php echo $img[22]; ?>&zoom=12&style=standard" target="_blank" class="galsearch">OpenRailwayMap</a> - <a href="openrailwaymap.php?s=56&lat=<?php echo $img[21]; ?>&lon=<?php echo $img[22]; ?>" target="_blank">OpenRailwaymap (pointer)</a> - <a href="           
            https://www.openstreetmap.org/?mlat=<?php echo $img[21]; ?>&mlon=<?php echo $img[22]; ?>#map=12/<?php echo $img[21]; ?>/<?php echo $img[22]; ?>" class="galsearch" target="_blank">OpenStreetMap</a> - <a href="https://www.google.dk/maps/place/<?php echo $img[21]; ?>,<?php echo $img[22]; ?>" target="_blank" class="galsearch">Google</a> 
			
			<?php } ?>  
			<br />
	</div>
	<?php } ?>

</div>

<br />
	


<?php 
$z=0;      
$query = "select id, tekst, poeng, bruker from gal_comments where clean_url='$img[25]'";
$result = $db->query($query);
while ( $comment = $result->fetch_array() ) {   
  $comid[$z] = $comment[0];
  $tekst[$z] = $comment[1];	
  $poeng[$z] = $comment[2];	
  $bruker[$z] = $comment[3];
  $z=$z+1;
}

if (isset($img[0])) {
?>

		<div class="img_commentcontainer">
<?php	
if ($z!=0) {
?>

<?php
@$image = ImageCreateFromJpeg($img[1]);
@$imgwidth=imagesx($image);  
@imagedestroy($image);
if ($imgwidth<800) {$imgwidth=800;}  
?>
		<?php
		 for ($y = 0 ; $y<$z ; $y++)
		 { 
		?>	
		<img src="../bo/graphics/dot.gif" style="width: 100%; height: 1px;" />
		  
            <div class="inner_commentcontainer">
                <div class="img_comment_left">
                      <?php echo $bruker[$y]; ?>
                 </div>
                 <div class="img_comment_mid">
                      <img src="graphics/<?php echo $poeng[$y]; ?>stars.gif" alt="" border="0" />
                 </div>
                 <div class="img_comment_right">
                      <?php echo $tekst[$y]; ?>
                 </div>
            </div>
                

		<?php
		  if ($y == $z-1) { ?><img src="../bo/graphics/dot.gif" style="width: 100%; height: 1px;" /><?php }
		 }
		?>

	
<?php } else { echo "<br />"; }?>

		</div>

<?php
if ($img[9] > 0) {
		$n=0;
		$query = "select id from gal_images where type ='$img[9]'";
		$result = $db->query($query);
		while ( $row = $result->fetch_object() ) {
			$rndimg[$n] = $row->id;
			$n=$n+1;
			 }
		if ($n<4) {$ma = $n;} else {$ma = 5;}
		@$rand_keys = array_rand($rndimg, $ma);
		for ($m = 0 ; $m<$ma ; $m++) {
		@$rndid[$m] = $rndimg[$rand_keys[$m]];
		}
}

if(@$n > 0) { ?>

	<div class="mobile">
<br />		
		<b>&nbsp;&nbsp;Likte du dette bildet, liker du sikkert noen av disse:</b><br /><br />
		<div id="show_rndcontainer">
			<?php
			@$query = "select id, url, thumb, poeng, stemmer, tekst, clean_thumb, clean_url, fotograf from gal_images where id in('$rndid[0]','$rndid[1]','$rndid[2]','$rndid[3]','$rndid[4]')";
			$result = $db->query($query);
				while ( $rndliste = $result->fetch_array() ) { 
					?>
						<div class="rnd_imgcontainer">
							<div class="rnd_starbox">
							<?php if($rndliste[3]>0) {$ustars = round($rndliste[3]/$rndliste[4]);} else {$ustars=0;} ?>
									<img src="<?php echo $path; ?>graphics/<?php echo $ustars; ?>stars.gif" alt="" />
							</div>	
							<div class="rnd_imgbox">
								<a href="posthylla_redir.php?img=<?php echo $rndliste[7]; ?>&id=<?php echo $rndliste[0]; ?>"><img src="<?php echo $rndliste[6] ?>" width="200" alt="" border="0"></a>
							</div>	
							
							<?php echo $rndliste[5]; ?><br />Fotograf: <?php echo $rndliste[8]; ?>
							
						</div>							
					<?php  }  ?> 
				<br /><br />
			<?php }
			?>
		</div>
		<?php
		}
		?>
      </div>
</div>