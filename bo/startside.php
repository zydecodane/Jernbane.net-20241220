<div id="gal_breadcrum">
<a href="../forum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> 
<hr />
<a href="../bo/subpage.php?s=13" target="_parent"><img src="../bo/graphics/stoett.png" title="Støtt oss" alt="Støtt oss" /></a>
</div>
	<div class="gal_container">
<div id="index_left">
	<div style="display: inline-block; width: 285px; float: left; margin-top: 10px;">
		<?php 
		include('bo_sideshow.php'); 
		?>
	</div>
</div>
<div id="index_right" style="margin-top: 10px;">
<?php
// check om cookie er sat
if ( $first == 1 )
{ ?>
		<div>
			<div class="gal_heading">
				<?php
					$totant = $db->query("select count(id) as antal from gal_images where posthylla=1 and (timestamp is null or timestamp > 0)")->fetch_object()->antal;
				?>
				 En tilfeldig valgt smakebit, blant totalt   <?php echo number_format($totant, 0, ',', '.'); ?>  fotografier som du i øyeblikket finner bevart på Jernbane.Net!
			</div>
			<div class="nygal_content" style="padding-left: 0px;">
				<?php
				$query = "select * from gal_images where posthylla = '1' and poeng > 30 order by RAND() LIMIT 1";	
				$result2 = $db->query($query);
				while ( $img = $result2->fetch_array() ) {
				 ?>				 
			 	<div id="show_header" style="width: 1000px; margin-left: auto; margin-right:auto; ">		 	    
			 	    <?php
			 	      if($img[12]>0) { $stars=round(($img[11]/$img[12])); } else { $stars=0;}
			 	    ?>
			 	    <div id="show_top_starcontainer" style="width: 1000px; padding-left: 20px;"><img src="graphics/<?php echo $stars; ?>stars.gif" alt="" /></div> 
			 	    	<img src="graphics/jernbanenet_h28.gif" alt="" class="lo;go_align" />
			 		</div>
			    	<div id="show_imgcontainer" style="width: 1000px; text-align: center !important; margin-left: auto; margin-right:auto; padding: 0;">
						<div style="text-align: center;">
			       	 		<a href="subpage.php?s=100&id=<?php echo $img[0]; ?>"><img src="<?php echo $img[1]; ?>" alt="copyright <?php echo $img[5]; ?>" title="copyright <?php echo $img[5]; ?>" style="text-align: center; max-width: 100%;" /></a>  
						</div> 
			       </div>
			       <br /> 
				<?php } ?> 
			</div>	
		</div>
<br />		
<?php			
}	
else {
include ('bo_start_gal.php');
}
$k=0;
$sql2 = "select id, url, thumb, navn, tekst, clean_url, stemmer, poeng, fotograf, clean_thumb from gal_images where timestamp <> '0' order by id desc LIMIT 48";
$res2 = $db->query($sql2);
while ( $llist = $res2->fetch_array() ) {
 @$lstars[$k] = round($llist[7]/$llist[6]);	
 $lfotograf[$k] = $llist[8];
 $lid[$k] = $llist[0];
 $lurl[$k] = $llist[1];
 $lthumb[$k] = $llist[2];
 $lnavn[$k] = $llist[3];
 $ltekst[$k] = $llist[4];
 $lclean_url[$k] = $llist[5];
 $lclean_thumb[$k] = $llist[9];
 $k++;
}
?>
<div class="gal_container">
	<div>

		<div class="gal_heading">
			<b>Posthylla</b> - De nyeste opplastede bilder
		</div>
		<div class="nygal_content">
			
			<?php  
			$p=0;
				for ($o = 0 ; $o<12 ; $o++) {   // tre rækker
				for ($n = $p ; $n<$p+3 ; $n++) { ?>
		<div class="nygal_box"> 
			<div class="nygal_starhead">
				<img src="<?php echo $path; ?>graphics/<?php echo @$lstars[$n]; ?>stars.gif" alt="" />
			</div>
		<?php	if ($loggedin == 0) { ?>
			<img src="https://jernbane.net/<?php echo $lclean_thumb[$n]; ?>"  class="nygal_img alt="" />
			<?php } else { ?>
			<a href="<?php echo $path; ?>subpage.php?s=0&id=<?php echo $lid[$n]; ?>"><img src="https://jernbane.net/<?php echo $lclean_thumb[$n]; ?>" width="250" alt="" class="nygal_img"></a>	<?php } ?>
	
			<div style="text-align: center;">
			   <?php echo $ltekst[$n]; ?><br />
			   <?php echo "&copy; ".$lfotograf[$n]; ?>     
			</div>
	</div>
			<?php }
			$p=$p+3;
			?>
<br /><br />
		<?php } ?>

</div>
<br />
	<div style="display: inline-block; width: 995px;">
		
	
	<?php include('gal_ad.php'); ?>
	</div>		
	</div>
</div>
</div>
</div>


