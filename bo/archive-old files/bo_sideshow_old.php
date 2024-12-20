<?php
// get user
$isloggedin = 0;
if ($userid !='') { $isloggedin = 1; }

$isloggedin = 1;
$loggedin = 1;

// get ukens
date_default_timezone_set('CET');
$uk_year = date('o');
$uk_week = date('W');

$squery = "select imgid from gal_ukens where uke = '$uk_week' and aar = '$uk_year'";
@$uk_id = $db->query($squery)->fetch_object()->imgid;

if(isset($uk_id)) {  // ukens bilde er valgt

$squery = "select id, thumb, url, tekst, stemmer, poeng, fotograf, clean_url, navn from gal_images where id = '$uk_id'";
$sresult = $db->query($squery);
$sukens = $sresult->fetch_array();
}
?>
<div class="sideshow">
	<div class="sideshow_heading">
		<b>Ukens Bilde</b>
	</div>
	<div class="sideshow_content">
	<?php 
			if(isset($uk_id)) { @$ustars= round($sukens[5]/$sukens[4]);
	?>
		<div id="ukens_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$ustars; ?>stars.gif" alt="" />
		</div>
		<div id="ukens_img">
    	<?php if(isset($uk_id)) { 
            // https
            if (substr($sukens[1],0,5) == 'http:') {
                $sukens[1] = 'https:'.substr($sukens[1],5);
            }
            ?>
    		<?php if ($isloggedin ==1) { ?> <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $sukens[8]; ?>&id=<?php echo $sukens[0]; ?>"><?php } else { ?><a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i full størrelse.')"><?php } ?><img src="<?php echo $sukens[1]; ?>" alt="ukens bilde"  class="latest_uploads" width="250" /> </a>
    		<br />
    	</div>
    	<?php  if(isset($uk_id)) { echo $sukens[3]; echo "<br />Fotograf: "; echo $sukens[6];  } ?>	
    	<br /><br />
    	<a href="<?php echo $path; ?>subpage.php?s=5" style="color: "0000ff !important;"><u>Tidligere Ukens Bilde</u></a>
    	<br /><br />
 				<?php } 
 			} else { echo "<br />Denne ukes <i>Picture of the Week</i><br />ikke valgt ennå<br /><br />"; } ?>
 	</div>
 	
 	<div class="sideshow_filler">
 	</div>
	
 	<?php 
 	if ($dagens[9]==1) // der er et dagens bilde, som skal vises
 	{ 
 	?>
 		<div class="sideshow_heading">
 			<b>Dagens bilde</b>
 		</div>
 			<div class="sideshow_content">
	<?php 
		 @$dstars= round($dagens[5]/$dagens[4]);
	?>
		<div id="ukens_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$dstars; ?>stars.gif" alt="" />
		</div>
		<div id="ukens_img">
    	<?php 
            // https
            if (substr($dagens[2],0,5) == 'http:') {
                $dagens[2] = 'https:'.substr($dagens[2],5);
            }
            ?>
    		<?php if ($isloggedin ==1) { ?> <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $dagens[8]; ?>&id=<?php echo $dagens[0]; ?>"><?php }  else { ?> <a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.')"> <?php } ?><img src="<?php echo $dagens[1]; ?>" alt="dgens bilde"  class="latest_uploads" width="250" /></a>
    		<br />
    	</div>
    	<?php echo $dagens[3]; ?><br />Fotograf: <?php echo $dagens[6]; ?>	
    	<br /><br />
		
    	<a href="<?php echo $path; ?>subpage.php?s=17" style="color: "0000ff !important;"><u>Tidligere Dagens Bilde</u></a>
    	<br /><br />
 				
 	</div>
 	<br />	
 	<?php 
 	} 
	
	
 	?>	
		
	<div class="sideshow_heading">
		Top 100
	</div>
	<?php
	$query9 = "select imgid from gal_top100 order by rand() limit 1";
	$result9 = $db->query($query9)->fetch_object()->imgid;
	
	$query10 = "select id, clean_thumb, url, tekst, stemmer, poeng, fotograf, clean_url, navn from gal_images where id = '$result9'";
	$result10=$db->query($query10);
	$top = $result10->fetch_array();
	?>
 	<div class="sideshow_content">
	<?php 
		 @$tstars= round($top[5]/$top[4]);
	?>
		<div id="ukens_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$tstars; ?>stars.gif" alt="" />
		</div>
		<div id="ukens_img">
		
		<?php if ($isloggedin ==1) { ?> <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $top[8]; ?>&id=<?php echo $top[0]; ?>"><?php }  else { ?> <a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.')"> <?php } ?><img src="<?php echo $top[1]; ?>" alt="Top 100"  class="latest_uploads" width="250" /></a>
		<br />
	</div>
	<?php echo $top[3]; echo "<br />Fotograf: "; echo $top[6]; ?>	
	<br /><br />
	<a href="<?php echo $path; ?>subpage.php?s=42" style="color: "0000ff !important;"><u>Top-100-bilder</u></a>
	<br /><br />
	</div>
 	<div class="sideshow_filler">
 	</div>
	
	
  	<div class="sideshow_heading">
 		Seneste opplastninger
 	</div>
 	<div class="sideshow_content">
 	 	<?php
		 // get latest uloads
		 $a=0;
		 $squery1 ="select id, url, thumb, clean_url, navn from gal_images where timestamp > 0 order by id desc limit 16";
		 $sresult1 = $db->query($squery1);
		 while ( $latest = $sresult1->fetch_array() ) {
    		$late_id[$a] = $latest[0];
    		$late_navn[$a] = $latest[4];
    		$late_thumb[$a] = $latest[2];
			$late_clean_url[$a] = $latest[3];
			
            // https
            if (substr($late_thumb[$a],0,5) == 'http:') {
                $late_thumb[$a] = 'https:'.substr($late_thumb[$a],5);
            }           
     		$a++;
     		} 
	     $a=0;
		 
		 for ($l = 0 ; $l<8 ; $l++) {
		 
		 for ($n = 0 ; $n<2 ; $n++) { ?>
		<div class="sideshow_latest">
			<?php if ($isloggedin==1) { echo '<a href="'.$path.'posthylla_redir.php?img='.$late_navn[$a].'&id='.$late_id[$a].'">'; } else { ?> <a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.')"> <?php } ?><img src="<?php echo $late_thumb[$a]; ?>" width="120" alt="" class="latest_uploads" /></a>
			<?php $a++; ?>
		</div>
		<?php } 
	}	
	?>
 	</div>
<!-- Siste inlegg inte längre aktuellt - bortkommenterat av GB 230127 rad 164-197 
 	<div class="sideshow_filler">
 	</div>
		 	<div class="sideshow_heading">
 		Siste innlegg
 	</div>
 	<div class="sideshow_content">
 	
 		<?php
                                 
 		$squery4 = "select forum_id, name from phorum_forums";
		 $sresult4 = $db->query($squery4);
		 while ( $sforum = $sresult4->fetch_array() ) {
   		 $sfnavn[$sforum[0]] = strip_tags($sforum[1]);
  		 } 

		$squery2 = "select data from phorum_settings where name = 'http_path'";
 		$http_path = $db->query($squery2)->fetch_object()->data;

		$squery3 = "select message_id, forum_id, thread, subject from phorum_messages where forum_id <> 2 and forum_id <> 12 and forum_id <> 3 and forum_id <> 16 order by message_id desc limit 45";
		$sresult3 = $db->query($squery3);
?>		

		<div class="sideshow_siste">
			<ul style="list-style-image: url(<?php echo $path; ?>graphics/bullet.gif); padding-left: 28px; margin-top:0px; ">
			<?php while ( $lpost = $sresult3->fetch_array() ) { ?>
				<li class="sideshow_item">
						<?php echo '<a href="'.$http_path.'/read.php?'.$lpost[1].','.$lpost[2].','.$lpost[0].'#msg-'.$lpost[0].'" class="sideshow_siste_pv">'.$lpost[3]; ?></a><br />
				<div style="font-size: 9px; color: #A4A4A4;"><?php echo $sfnavn[$lpost[1]]; ?></div>				
				</li><br />
			<?php } ?>
			</ul>
 		</div>
 	</div>
 	
 	<div class="sideshow_filler">
 	</div>
-->
                                
		</div>
 	</div>
<?php
	
?>	
</div>
<br />		
	
