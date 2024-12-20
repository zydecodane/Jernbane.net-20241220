<?php
$back="yes";

// chek if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);

// get users real name from database
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

$unitid = $_GET['u'];

$query = "select enhet from gal_unit where numid = '$unitid'";
$lok = $db->query($query)->fetch_object()->enhet;

$sn=0;

$query1 = "select id from gal_images where nummer = '$unitid' AND posthylla = 1";
$result1 = $db->query($query1);
while ($image = $result1->fetch_array()){

	$img[$sn] = $image[0];
	$sn=$sn+1;
	}

	$query2 = "select enhet, typeid, info from gal_unit where numid = '$unitid'";
	$result2 = $db->query($query2);
	$unit = $result2->fetch_array();
	
	$query3 = "select typename, katid from gal_type where typeid = '$unit[1]'";
	$result3 = $db->query($query3);
	$type = $result3->fetch_array();
	
	$query4 = "select katname, natid, natnavn from `gal_kategori` where katid = '$type[1]'";
	$result4 = $db->query($query4);
	$kat = $result4->fetch_array();
?>
<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $kat[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[2]; ?></a> >
	<a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $type[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[0]; ?></a> >
	<a href="<?php echo $path; ?>subpage.php?s=3&t=<?php echo $unit[1] ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $type[0]; ?></a> >
	<a href="<?php echo $path; ?>subpage.php?s=4&u=<?php echo $unitid; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $unit[0]; ?></a>
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
			<?php echo $lok; ?>
		</div>
	<div class="nygal_content">
	<?php
	$ik=0;
	// $query6 = "select url, clean_url from gal_images where nummer = '$unitid' and posthylla ='1'";
	// $result6 = $db->query($query6);
	?>
		<div class="nyunit_text">
			<?php if ($unit[2]!='') { 
				echo strip_tags($unit[2],'<br><br />')."<br /><br />"; } ?>
		</div>
			<?php if ($unit[2]!='') { ?>
				<hr class="red_hr" /><?php } ?>	
	<?php
	$o=0;
	for ($l = 0 ; $l<(ceil($sn/3)) ; $l++)
	 { 
		for ($k = 0 ; $k<3 ; $k++)
			{
				@$query5 = "select id, thumb, tekst, fotograf, poeng, stemmer, navn, clean_thumb, clean_url from gal_images where id = '$img[$o]'";
				@$result5 = $db->query($query5);
				@$image = $result5->fetch_array();        	

				if (isset($image[0])){ ?>
				
		   <div class="nygal_box">
		   <?php	if ($loggedin == 0) {
		?>
		<?php if ($image[4]>0) { $stars = round($image[4]/$image[5]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
		 <img src="<?php echo $image[7] ?>" width="250" alt="" class="nygal_img" />
	<?php
	}
else // user IS logged in  
{
?>
	<?php if ($image[4]>0) { $stars = round($image[4]/$image[5]); } else { $stars = 0; } ?>
			<div class="nygal_starhead">
				<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
			</div>
     <a href="subpage.php?s=0&amp;id=<?php echo $image[0]; ?>&amp;u=<?php echo $unitid; ?>" target="_parent"><img src="<?php echo $image[7] ?>" width="250" class="nygal_img" alt="" /></a>
<?php
}
?>
		<div class="nygal_imgtext">
	   <?php echo $image[2]; ?><br />
        </div>	    
		<div class="nygal_imgbund">
			<div class="nygal_author">
				<?php echo "&copy; ".$image[3]; ?>
			</div>
			<div class="nygal_searchicon">
				<a href="../phorum/search.php?7,search=<?php echo $image[8]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="../bo/graphics/search.jpg" title="Finn i Postvogna" alt="Finn i Postvogna"/></a>
			</div>
		</div>
	    
</div>
           <?php
               	}
          	$o=$o+1;
        
		}		
 	}

$db->close();
?>
	</div>
	<div class="mobile">
		<?php include('gal_ad.php'); ?>
	</div>	
	
</div>
</div>


