<?php	
if (isset($_GET['id'])) {$firstid = $_GET['id'];} else {$firstid = 0;}

$rir=0;
$query = "select id, url, thumb, navn, tekst, clean_url, stemmer, poeng, fotograf, clean_thumb from gal_images where posthylla = '1' and poeng > 10 order by RAND() LIMIT 8";	
$result2 = $db->query($query);
while ( $rlist = $result2->fetch_array() ) {
 @$rstars[$rir] = round($rlist[7]/$rlist[6]);	
 $rfotograf[$rir] = $rlist[8];
 $riid[$rir] = $rlist[0];
 $riurl[$rir] = $rlist[1];
 $rithumb[$rir] = $rlist[2];
 $rinavn[$rir] = $rlist[3];
 $ritekst[$rir] = $rlist[4];
 $riclean_url[$rir] = $rlist[5];
 $riclean_thumb[$rir] = $rlist[9];  
 $rir++;
}

if ($firstid > 0) {
	$query3 = "select id, url, thumb, navn, tekst, clean_url, stemmer, poeng, fotograf, clean_thumb from gal_images where id = '$firstid'";	
	$result3 = $db->query($query3);
	while ( $flist = $result3->fetch_array() ) {
	 @$rstars[0] = round($flist[7]/$flist[6]);	
	 $rfotograf[0] = $flist[8];
	 $riid[0] = $flist[0];
	 $riurl[0] = $flist[1];
	 $rithumb[0] = $flist[2];
	 $rinavn[0] = $flist[3];
	 $ritekst[0] = $flist[4];
	 $riclean_url[0] = $flist[5];
	 $riclean_thumb[0] = $flist[9];  
	}
}

$totant = $db->query("select count(id) as antal from gal_images where posthylla=1 and (timestamp is null or timestamp > 0)")->fetch_object()->antal;
?>	
<div class="gal_container">
			<div class="gal_heading1">
				<b>Fra galleriene</b> - tilfeldig valgt blant totalt <?php echo number_format($totant, 0, ',', '.'); ?> bilder i databasen
			</div>
			<div class="nygal_content1">
				<?php for ($n = 0 ; $n<4 ; $n++) { ?>
					<div class="nygal_box"> 
						<div class="nygal_starhead">
							<img src="<?php echo $path; ?>graphics/<?php echo @$rstars[$n]; ?>stars.gif" alt="" />
						</div>
					<?php	if ($loggedin == 0) { ?>
						<img src="https://jernbane.net/<?php echo $riclean_thumb[$n]; ?>"  class="nygal_img alt="" />
						<?php } else { ?>
						<a href="<?php echo $path; ?>subpage.php?s=0&id=<?php echo $riid[$n]; ?>"><img src="https://jernbane.net/<?php echo $riclean_thumb[$n]; ?>" width="250" alt="" class="nygal_img"></a>	<?php } ?>
				
						<div style="text-align: center;">
						   <?php echo $ritekst[$n]; ?><br />
						   <?php echo "&copy; ".$rfotograf[$n]; ?>     
						</div>
				</div>
				<?php } 
				for ($n = 4 ; $n<8 ; $n++) { ?>
					<div class="nygal_box"> 
						<div class="nygal_starhead">
							<img src="<?php echo $path; ?>graphics/<?php echo @$rstars[$n]; ?>stars.gif" alt="" />
						</div>
					<?php	if ($loggedin == 0) { ?>
						<img src="https://jernbane.net/<?php echo $riclean_thumb[$n]; ?>"  class="nygal_img alt="" />
						<?php } else { ?>
						<a href="<?php echo $path; ?>subpage.php?s=0&id=<?php echo $riid[$n]; ?>"><img src="https://jernbane.net/<?php echo $riclean_thumb[$n]; ?>" width="250" alt="" class="nygal_img"></a>	<?php } ?>
				
						<div style="text-align: center;">
						   <?php echo $ritekst[$n]; ?><br />
						   <?php echo "&copy; ".$rfotograf[$n]; ?>     
						</div>
				</div>
				<?php } ?>
				
				
			</div>	
</div>
<br />
