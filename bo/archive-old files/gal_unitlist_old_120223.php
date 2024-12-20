<?php
include ('typeinfo_view.php');

// fancybox-script start
?>
<script type="text/javascript" src="fancybox2/lib/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" href="fancybox2/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox2/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<script type="text/javascript">
	$(document).ready(function() {
                $(".fancybox").fancybox();
	});
</script>


<script type="text/javascript" src="../bo/tinybox.js">
</script>



<?php
// fancybox-script slut

$back="yes";
// chek if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);

// get users real name from database - til hvad?
 
/* 
$getuser=mysql_query("SELECT real_name, admin FROM `phorum_users` WHERE user_id='$userid'");
$user = mysql_fetch_row($getuser);
$username = $user[0];
$isadmin = $user[1];
*/

} else {$loggedin = 0;}

// HACK: Visning som om alle altid er logged in
// $loggedin = 1;
// HACK

$typeid = $_GET['t'];
	$query = "select typename, katid, info, infostruct, info_deleted from gal_type where typeid = '$typeid'";
	$result = $db->query($query);
	$type = $result->fetch_array();
	
	$query1 = "select katname, natid, natnavn from gal_kategori where katid = '$type[1]'";
	$result1 = $db->query($query1);
	$kat = $result1->fetch_array();
	
	$query44 = "select count(typeid) as antal from gal_unit where typeid = '$typeid'";
	$result44 = $db->query($query44)->fetch_object()->antal;
	$antal = 0;
?>
<div id="gal_breadcrum">
	<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $kat[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[2]; ?></a> >
	<a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $type[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[0]; ?></a> >
	<a href="<?php echo $path; ?>subpage.php?s=3&t=<?php echo $typeid; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $type[0]; ?></a>
	<hr />
	<div class="mobile">
		<a href="../bo/subpage.php?s=13" target="_parent"><img src="../bo/graphics/stoett.png" title="Støtt oss" alt="Støtt oss" /></a>
	</div>	
</div>

<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			<?php echo $type[0]; ?>
	</div>
	<div class="nygal_content">
        <?php
          //  <script type="text/javascript" src="../bo/tinybox2/tinybox.js"></script>
        ?>        
		<div id="gal_typeinfo" style=" padding-left: 5px;">
	         <?php echo dbTypeInfoToHtml($type[3], $type[4] ? NULL : $type[2] );  ?>	
		</div>
		<br />
		<hr class="red_hr" />
<?php
	$query2 = "select * from gal_unit where typeid = '$typeid' order by plass";
	$result2 = $db->query($query2);
	while ( $unit = $result2->fetch_array() ) {	
	$antal++;	
?>
<?php
// stripping html-tags exept <br />

$tekst = str_replace('<br />','[br]',$unit[4]);
$tekst = str_replace('<br>','[br]',$tekst);
$tekst = str_replace('<BR>','[br]',$tekst);
$tekst = strip_tags($tekst);

$tekst = str_replace('[br]','<br />',$tekst);

// images loades into array
unset($lokid);
$n=0;

$query3 = "select id from gal_images where nummer = '$unit[0]' and posthylla = 1";
$result3 = $db->query($query3);
while ( $unitid = $result3->fetch_array() ) {


$lokid[$n] = $unitid[0];
$n=$n+1;
}
// if there is an image at all
if ($n>0)
{
 ?>
<a name="<?php echo $unit[0];?>">
<div class="nyunit_headline">
    <?php echo $unit[1]; 
    ?>
</div>

<!-- start mobilvisning -->
<div class="nyunit_text mobile_show">
  I alt <?php echo $n; ?> bilde<?php if($n>1){echo"r";} ?><?php if ($n>1) { ?> - <a href="subpage.php?s=4&amp;u=<?php echo $unit[0]; ?>" class="nygal"><b>se alle</b></a><?php } ?>
</div>


<div class="mobile_show">
<?php
// udtræk af et enkelt billede til mobilvisning

$rand_keys = array_rand($lokid, 1);

$m_imgid = $lokid[$rand_keys];

	$query8 = "select id, thumb, tekst, fotograf, poeng, stemmer, navn, clean_thumb, clean_url from gal_images where id = '$m_imgid'";
	$result8 = $db->query($query8);
	$m_img = $result8->fetch_array();	

    ?>
    
    <div class="nygal_box">
    <?php if ($m_img[4]>0) { $stars = round($m_img[4]/$m_img[5]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
<?php	if ($loggedin == 0) {
	?>
     <img src="<?php echo $m_img[7] ?>" width="250" border="0" alt="" class="nygal_img" />
<?php
}
else // user IS logged in  
{
?>
     <a href="subpage.php?s=0&amp;id=<?php echo $m_img[0]; ?>" target="_parent"><img src="<?php echo $m_img[7] ?>" width="250" border="0" alt="" class="nygal_img"/></a>
<?php
}
?>
	<div class="nygal_imgtext">
	   <?php echo $m_img[2]; ?><br />
        </div>	     
     <div class="nygal_imgbund">
			<div class="nygal_author">
				<?php echo "&copy; ".$m_img[3]; ?>
			</div>
			<div class="nygal_searchicon">
				<a href="../phorum/search.php?7,search=<?php echo $m_img[8]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="../bo/graphics/search.jpg" title="Finn i Postvogna" alt="Finn i Postvogna"/></a>
			</div>
		</div>
    </div>

</div>
<!-- slut mobilvisning -->













<!-- start pc-visning -->
<div class="mobile">

<?php
if ($n>3)
{
?>

<div class="nyunit_text mobile">
  I alt <?php echo $n; ?> bilder - <a href="subpage.php?s=4&amp;u=<?php echo $unit[0]; ?>" class="nygal"><b>se alle</b></a>
</div>

<?php
// nu trækker vi 4 ud, hvis der er flere end 4 mulige

$rand_keys = array_rand($lokid, 4);
$imgid[0] = $lokid[$rand_keys[0]];
$imgid[1] = $lokid[$rand_keys[1]];
$imgid[2] = $lokid[$rand_keys[2]];
$imgid[3] = $lokid[$rand_keys[3]];

 for ($j = 0 ; $j<3 ; $j++)
 {
	$query4 = "select id, thumb, tekst, fotograf, poeng, stemmer, navn, clean_thumb, clean_url from gal_images where id = '$imgid[$j]'";
	$result4 = $db->query($query4);
	$img = $result4->fetch_array();	

    ?>
    
    <div class="nygal_box">
    <?php if ($img[4]>0) { $stars = round($img[4]/$img[5]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
<?php	if ($loggedin == 0) {
	?>
     <img src="<?php echo $img[7] ?>" width="250" border="0" alt="" class="nygal_img" />
<?php
}
else // user IS logged in  
{
?>
     <a href="subpage.php?s=0&amp;id=<?php echo $img[0]; ?>" target="_parent"><img src="<?php echo $img[7] ?>" width="250" border="0" alt="" class="nygal_img"/></a>
<?php
}
?>
	<div class="nygal_imgtext">
	   <?php echo $img[2]; ?><br />
        </div>	
        
        
        
     <div class="nygal_imgbund">
			<div class="nygal_author">
				<?php echo "&copy; ".$img[3]; ?>
			</div>
			<div class="nygal_searchicon">
				<a href="../phorum/search.php?7,search=<?php echo $img[8]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="../bo/graphics/search.jpg" title="Finn i Postvogna" alt="Finn i Postvogna"/></a>
			</div>
		</div>
    </div>
<?php
 }
echo "<br />";
}
else
{
  for ($i = 0 ; $i<$n ; $i++)
   {
	$query5 = "select id, thumb, tekst, fotograf, poeng, stemmer, navn, nummer, clean_thumb from gal_images where id = '$lokid[$i]'";
	$result5 = $db->query($query5);
	$img = $result5->fetch_array();
    ?>
     
     <div class="nygal_box"><?php	if ($loggedin == 0) {
	?>
	<?php if ($img[4]>0) { $stars = round($img[4]/$img[5]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
	
     <img src="<?php echo $img[8] ?>" width="250" border="0" alt="" class="nygal_img" />
<?php
 }
else // user IS logged in  
{
?>
	<?php if ($img[4]>0) { $stars = round($img[4]/$img[5]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
     <a href="subpage.php?s=0&amp;id=<?php echo $img[0]; ?>&amp;u=<?php echo $img[7]; ?>" target="_parent"><img src="<?php echo $img[8] ?>" width="250" border="0" alt="" class="nygal_img" /></a>
	 <?php
}
?>
     
        <div class="nygal_imgtext">
	   <?php echo $img[2]; ?><br />
        </div>	    
		<div class="nygal_imgbund">
			<div class="nygal_author">
				<?php echo "&copy; ".$img[3]; ?>
			</div>
			<div class="nygal_searchicon">
				<a href="../phorum/search.php?7,search=<?php echo $img[6]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="../bo/graphics/search.jpg" title="Finn i Postvogna" alt="Finn i Postvogna"/></a>
			</div>
		</div>
	    

    </div>

     <?php
   }
}
?>

</div>
<!-- slut pc-visning -->


<div class="nyunit_text mobile">
  <?php echo $tekst; ?>
<br /><br />
<?php if ($loggedin == 1) { ?>




	<a href="#" class="nygal" onclick="TINY.box.show({url:'../bo/infocontainer.php?id=<?php echo $unit[0]; ?>&amp;u=<?php echo $userid; ?>&amp;t=<?php echo $typeid; ?>',width:800,height:410,opacity:50,close:false})" style="cursor:pointer">Legg til informasjon om <?php echo $type[0]; echo " - "; echo $unit[1]; ?></a>
	<br /><br />
<?php } ?>
</div>
<?php  if ($antal<$result44) { ?><hr class="red_hr" /><?php } else { ?><br /><?php }?>
<?php
} // end if there is an image at all
else { ?>
	<a name="<?php echo $unit[0];?>">
	<div class="nyunit_headline">
    <?php echo $unit[1]; ?>
	</div>
	<div class="nyunit_text">
	<b>Foreløpig ingen bilder i galleriet.<br />
	Vi venter på ditt bidrag.</b>
	</div> 
	<?php  if ($antal<$result44) { ?><br /><?php } else { ?><br /><?php }?>


<div class="nyunit_text mobile">
  <?php echo $tekst; ?>
<br /><br />
<?php if ($loggedin == 1) { ?>
	<a href="#" class="nygal" onclick="TINY.box.show({url:'../bo/infocontainer.php?id=<?php echo $unit[0]; ?>&amp;u=<?php echo $userid; ?>&amp;t=<?php echo $typeid; ?>',width:800,height:410,opacity:50})" style="cursor:pointer">Legg til informasjon om <?php echo $type[0]; echo " - "; echo $unit[1]; ?></a>
	<br /><br />
<?php } ?>
</div>



<hr class="red_hr" />
	
<?php }
}


?>

	</div>
	<div class="mobile">	
		<?php include('gal_ad.php'); ?>
	</div>
<br />
	
	
</div>	


</div>

