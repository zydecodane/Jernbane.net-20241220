<?php
$m=0;
$kat = $_GET['k'];
$back="yes";

$query = "select katname, natnavn, natid from gal_kategori where katid = '$kat'";
$result = $db->query($query);
$landkat = $result->fetch_array();

$query1 = "select typeid, typename, plass from gal_type where katid = '$kat' and typename <>'Ute av bruk for tilfellet' order by plass asc";
$result1 = $db->query($query1);
while ( $cat = $result1->fetch_array() ) {

	$n=0;
	
	$query2 = "select id from gal_images where type = '$cat[0]' and posthylla = 1";
	$result2 = $db->query($query2);
	while ( $unit = $result2->fetch_array() ) {
	
	$lok[$n] = $unit[0];	
	$n=$n+1;
	}

	if ($n>0) {  // we acually have a picture of this type in the database
		$get = mt_rand(0,$n-1); 
		
		$query3 = "select thumb, type, clean_thumb from gal_images where id = '$lok[$get]'";
		$result3 = $db->query($query3);
		$img = $result3->fetch_array();

    // now we put the output into some arrays
        $hl[$m] = htmlspecialchars_decode($cat[1]);
        $image[$m] = $img[2];
        $typeid[$m] = $img[1];
        $m=$m+1;			 
			  }
						} 	// end every type	
		
// and now we start the styled output
$rows=ceil($m/3);
$m=0;
?>
<div id="gal_breadcrum">
<a href="https://jernbane.net/bo/subpage.php?s=1&l=1" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $landkat[2]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $landkat[1]; ?></a> >
 <a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $kat; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $landkat[0]; ?></a>
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
	
	<div class="mobile">
	<?php include('../bo/bo_rand_gal_3.php'); ?>
	<br />
	</div>
	
	
	
	
	
		<div class="gal_heading">
			<?php echo $landkat[0]; ?>
	</div>
	<div class="nygal_content">
		<?php
		 for ($r = 0 ; $r<($rows) ; $r++) { 

			for ($c = 0; $c<3 ; $c++) { 

			 if (isset($image[$m])) { ?>
		  
			 <div class="nygal_box">
			 <a href="subpage.php?s=3&amp;t=<?php echo $typeid[$m]; ?>" target="_parent"><img src="<?php echo $image[$m] ?>" alt="" width="250" border="0" alt="" class="nygal_img" /></a>
				 
				 <div style="text-align: center;">
					<br />
				   <a href="subpage.php?s=3&amp;t=<?php echo $typeid[$m]; ?>" target="_parent" class="nygal"><?php echo $hl[$m]; ?></a>
				   <br />
				   <?php
					//$query4 = "select count(id) as antal from gal_images where type = '$typeid[$m]'";
					$antall = $db->query("select count(id) as antal from gal_images where type = '$typeid[$m]' and posthylla = '1'")->fetch_object()->antal;
					echo number_format($antall, 0, ',', '.'); echo " bilde"; if ($antall > 1) { echo "r";} 
				   ?>
				</div>	
			</div>	
			 <?php  $m=$m+1;  
				}
			 ?>
  <?php } 
 } ?>
	</div>
<?php
	$result->free();
	$result1->free();
	$result2->free();
	
$db->close();	
?>
		<div class="mobile">
			<?php include('gal_ad.php'); ?>
		</div>

	</div>
	

	
	
	
</div>





