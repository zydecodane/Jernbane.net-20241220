<?php
if (isset($_GET['idx'])) { $idx = $_GET['idx']; }
if (isset($_GET['urlx'])) { $urlx = $_GET['urlx']; }
if (isset($_GET['postingx'])) { $postingx = $_GET['postingx']; }

include('../bo/configi.php');


// bilderepresentasjon i postvogna

$postvogna_rep = '';
$query4 ="select message_id from phorum_search where search_text like '%$urlx%' limit 5";
$result4 = $db->query($query4);
while ($forum = $result4->fetch_array()) { 
	$query5 = "select forum_id, thread, subject from phorum_messages where message_id = '$forum[0]' ";
	$result5 = $db->query($query5);
	$inlegg = $result5->fetch_array();

$postvogna_rep .= '<a href="read.php?'.$inlegg[0].','.$inlegg[1].','.$forum[0].'#msg-'.$forum[0].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$inlegg[2].'</a><br />';
}


// admin-menu

@$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
@$userid = substr ($cookie,0,$colon);
// check if user is admin

$isadmin = 0;
if ($userid!='') {
$query5 = "select admin from phorum_users where user_id='$userid'";
$isadmin = $db->query($query5)->fetch_object()->admin;
}

$admin_menu = '';
if($isadmin == 1) {
	//$k_posting = array_shift(array_keys($_GET));
	$admin_menu .= '<a href="../bo/admin/index.php?s=6&id='.$idx.'&fi='.$postingx.'"><img src="../bo/graphics/edit.png" border="0" alt="endre kategorisering" title="endre kategorisering" style="padding-top:5px;"></a><br />
	<a href="../bo/admin/index.php?s=7&id='.$idx.'&fi='.$postingx.'"><img src="../bo/graphics/copy.png" border="0" alt="kopiere til ytterligere plassering" title="kopiere til ytterligere plassering" style="padding-top:2px;"></a><br />
	<a href="../bo/admin/index.php?s=5&id='.$idx.'&fi='.$postingx.'"><img src="../bo/graphics/comm.png" border="0" alt="endre eller slette kommentar" title="endre eller slette kommentar" style="padding-top:2px;"></a>';
}

// EXIF-data

$query1 ="select * from gal_images where id = '$idx'";
$result1 = $db->query($query1);
$k_img = $result1->fetch_array();
		
$k_cam = $k_img[13].", ".$k_img[14]."<br />";
     	if (substr($k_img[15],0,1)!='') {
$k_exif = $k_img[18]."&nbsp;&nbsp;-&nbsp;&nbsp;".$k_img[15]."&nbsp;&nbsp;-&nbsp;&nbsp;".$k_img[16]."&nbsp;&nbsp;-&nbsp;&nbsp;".$k_img[17];
		}
  		 else        	
		{ $k_cam = ""; $k_exif="Ingen EXIF-data tilgjengelige"; }


// plassering i gallerierne

$galout='';
if ($k_img[20]==1) {	
	
$ng = 0;
$query = "select type, nummer from gal_images where url='$k_img[1]'";
$result = $db->query($query);
while ( $gal = $result->fetch_array() ) {
	$typeid[$ng] = $gal[0];
	$nummer[$ng] = $gal[1];
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

$galout .= '<a href="../bo/subpage.php?s=1&l='.$nid[$mg].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$nname[$mg].'</a> > ';
$galout .= '<a href="../bo/subpage.php?s=2&k='.$kid[$mg].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$kname[$mg].'</a> > ';
$galout .= '<a href="../bo/subpage.php?s=3&t='.$typeid[$mg].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$tyname[$mg].'</a> > ';
$galout .= '<a href="../bo/subpage.php?s=4&u='.$nummer[$mg].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$enhet[$mg].'</a><br />';

	} 
}

// geografisk plassering

$geospot = '';
if ( $k_img[21]!=0 && $k_img[22]!=0 ) { 

$geospot .='<iframe src="../bo/bbcode_map.php?lon='.$k_img[22].'&lat='.$k_img[21].'" style="width: 498px; height: 242px; " scrolling="no" frameborder="0"></iframe><br />';
$geospot .= 'Vis større kart <a href="../bo/bigmap.php?lat='.$k_img[21].'&lon='.$k_img[22].'" target="_blank" class="galsearch">OpenStreetmap</a> - <a href="https://www.google.dk/maps/place/'.$k_img[21].','.$k_img[22].'" target="_blank" class="galsearch">Google</a> - 
<a href="http://www.bing.com/maps/default.aspx?rtp=pos.'.$k_img[21].'_'.$k_img[22].'&lvl=12" target="_blank" class="galsearch">Bing</a>';
}

// get ytterligere info

$query7 = "select enhet, info from gal_unit where numid = '$k_img[10]'";
	@$unitenhet = $db->query($query7)->fetch_object()->enhet;
	@$unitinfo = $db->query($query7)->fetch_object()->info;

	$yinfo = $unitenhet.'<br />'.$unitinfo;


  
?>
<div style="float: right;">
<div style="width: 40px; display: table-cell;">
	 <?php
		echo $admin_menu;
	?>
</div>
<div style="width:498px; padding-bottom: 6px; padding-right: 10px; display: table-cell; font-family: Tahoma,Arial,Helvetica,sans-serif; font-size: 12px;">
<?php 	
	if ($k_img[21] != 0 && $k_img[22] != 0) { 
?>
	<b>Fotografens plassering:</b><br />
	<?php
		echo $geospot;
	?>
	<br />
<?php } ?> 	

</div>
</div>
<div style="width: 660px; display: table-cell; font-family: Tahoma,Arial,Helvetica,sans-serif; font-size: 12px;">
	<b>EXIF-data:</b><br />
	<?php 
		echo $k_cam; echo $k_exif;
	?>
	<br />
		<br />
<?php 	
if ($k_img[20]==1) { 
?>	
	<b>Plassering i gallerierne:</b><br />
	<?php 
		echo $galout;
	?>	 
	<br />	 
<?php } ?>
	<b>Bildepresentasjon i Postvogna:</b><br />
	<?php 
		echo $postvogna_rep;
	?>
	<br />
<?php
	if ($unitinfo != '') { 
?>
	<b>Ytterligere info:</b><br />
	<?php
		echo $yinfo;
	?>
	<br />
<?php } ?>	
</div>











