<?php

$back="yes";
// get categories where country is set


// get countries in europe

$m=0; // countervariable - how many countries are there
$query0 = "select natid, natnavn from gal_nations where gruppe = 'eu' order by natnavn";
$result0 = $db->query($query0);
while ( $nat = $result0->fetch_array() ) {
		$p=0;  //new country
			
		$query1 = "select katid, katname from gal_kategori where natid = '$nat[0]' ORDER BY rand() LIMIT 5";
		$result1 = $db->query($query1);
		while ( $cat = $result1->fetch_array() ) {
			
				$query2 = "select typeid from gal_type where katid = '$cat[0]' ORDER BY rand() LIMIT 1";
				$result2 = $db->query($query2);
				while ( $type = $result2->fetch_array() ) {
					
					$query3 = "select thumb from gal_images where type = '$type[0]' and posthylla = 1 ORDER BY rand() LIMIT 1";
					@$thumb = $db->query($query3)->fetch_object()->thumb;
					if ($p==0) {
								if ($thumb!='') {
									$land[$m] = $nat[1];
									$landid[$m] = $nat[0];
									$img[$m] = $thumb;
									$m++;
									$p=1;	
								}
					}	
		}	
	}
}
$rows = ceil(($m-1)/3)+1 ;
$o=0;
// and now we start the styled output
?>
<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=21" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Europa</a>
<hr />
<a href="../bo/subpage.php?s=13" target="_parent"><img src="../bo/graphics/stoett.png" title="Støtt oss" alt="Støtt oss" /></a>
</div>

<div class="gal_container">

	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
		?>
	</div>
	<div id="index_right">
		<div class="gal_heading">Europa</div>
		<div class="nygal_content">
			<?php
			 for ($r = 0 ; $r<($rows) ; $r++) { ?>  
			  <?php 
			    for ($c = 0; $c<3 ; $c++) { 
			  	if(isset($land[$o])) {
			 ?>
				 <div class="nygal_box">
				 	<a href="subpage.php?s=1&amp;l=<?php echo $landid[$o]; ?>" target="_parent"><img src="<?php echo $img[$o]; ?>" alt="" width="250" border="0" class="nygal_img" /></a>
				    <div style="text-align: center;">
				   	<br />
				    <a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $landid[$o]; ?>" class="nygal"><?php echo $land[$o]; ?></a>
				    </div>
				 </div>   
			     <?php  $o=$o+1;  
			       }
			    }
			 }
			?>
			<br /><br />
		</div>
<?php include('gal_ad.php'); ?>		
	</div>
</div>
