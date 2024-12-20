<?php
if(isset($_GET['f'])) {$f = $_GET['f'];} else {$f='A';}
$fu=0;

$query = "select distinct(fotograf) from gal_images where (substr(fotograf,1,1) = '$f') ";
$result = $db->query($query);
while ( $flist = $result->fetch_array() ) {
  $fotograf[$fu] = $flist[0];
  $fu = $fu+1;	
 }
?>

<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=40" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Fotografer</a>
</div>
<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			Fotografer på Jernbane.<i>net</i>
		</div>
		<div class="nygal_content">
			<div class="nygal_bladring">
			<br />
			<?php
			 $fn=1;
			 foreach (range('A','Z') as $setletter) {
			 	$letter[$fn] = $setletter;
			 	$fn=$fn+1;
			 }
			    $letter[$fn] = 'Æ'; $fn=$fn+1;
			    $letter[$fn] = 'Ø'; $fn=$fn+1;
			    $letter[$fn] = 'Å'; $fn=$fn+1;
			
			for ($fm = 1 ; $fm<$fn ; $fm++) {
				echo "&nbsp;&nbsp;";
				if ($f == $letter[$fm]) { ?><b><?php }
				else { ?><a href="subpage.php?s=40&amp;f=<?php echo $letter[$fm]; ?>" target="_parent" style="color: #000000;"><?php }
				echo $letter[$fm];
				if ($f == $letter[$fm]) { ?></b><?php }
				else { ?></a><?php }
				echo "&nbsp;&nbsp;";
				if ($fm<$fn-1) { echo chr(124); }
				}
				?>
				<br /><br /><br />
				</div>
				
				
				<div class="fotographer_container">
				<?php
				 $ft=0;
				 $fr = ceil(($fu-1)/4);
				 for ($fo = 1 ; $fo<$fr+1 ; $fo++) {
					for ($fp = 1 ; $fp<5 ; $fp++) {
				    if ($ft<$fu) {
						
					$fotograf_esc[$ft] = mysqli_real_escape_string($db,$fotograf[$ft]);	
						
				    $query1 = "select count(*) as antal from gal_images where fotograf = '$fotograf_esc[$ft]'";	
				    $antal = $db->query($query1)->fetch_object()->antal;
				    ?>
				 	<div class="fotographer_box">
				     <a href="subpage.php?s=41&f=<?php echo $fotograf[$ft]; ?>" target="_parent" style="color: #000000;">
				     <?php 
				      	echo $fotograf[$ft]; echo "</a>";
				    	echo "&nbsp;("; echo number_format($antal, 0, '.', '.'); echo ")";
				    	$ft=$ft+1; ?>
				    </div>	
				    <?php	
				    } } }
				    ?>  
				</div>
			</div>
	<?php include('gal_ad.php'); ?>
	</div>
</div>
