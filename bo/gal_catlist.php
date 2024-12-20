<?php
$natid = $_GET['l'];
$back="yes";
// get categories where country is set
$m=0;

$query = "select katid, katname from gal_kategori where natid = '$natid' order by plass";
$result = $db->query($query);
while ( $cat = $result->fetch_array() ) {

	$n=0;
	$category[$m] = $cat[1];
 	$catnum[$m] = $cat[0];
	// get type where category is set
	
	$query1 = "select typeid from gal_type where katid='$cat[0]'";
	$result1 = $db->query($query1);
	while ( $type = $result1->fetch_array() ) {
		
		// get pictures where type is set
		
		$query2 = "select id from gal_images where type = '$type[0]' and posthylla = 1";
		$result2 = $db->query($query2);
		while ( $img = $result2->fetch_array() ) {	
				
        $image[$n] = $img[0]; 
		$n=$n+1;     
		                 }		
		@$ir = mt_rand(0,$n-1);
		@$pic[$m] = $image[$ir];
		$t[$m] = $n;	
											}					
        $m=$m+1;		
										}	
// now we an array containing all categories and an variable with one random image from this category 

$rows = ceil(($m-1)/3)+1 ;
$o=0;
// and now we start the styled output

$query3 = "select natnavn from gal_nations where natid = '$natid'"; 
$land = $db->query($query3)->fetch_object()->natnavn;
?>
<div id="gal_breadcrum">
<a href="https://jernbane.net/bo/subpage.php?s=1&l=1" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $natid; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $land; ?></a>
<hr /> 
<?php
    if (isset($_COOKIE["xf_user"]))
    { $loggedin = 1;} else {$loggedin = 0;}    
if ($loggedin==0) { ?>
    <div class="register_top">
        <a class="galsearch" href="../phorum/login.php">Logg inn</a>&nbsp; - &nbsp;<a class="galsearch" href="../phorum/register.php">Opprett en ny profil</a>
    </div>
<?php } ?>        
        
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
			<?php echo $land; ?>
		</div>
		<div class="nygal_content">
			<?php
			 for ($r = 0 ; $r<($rows) ; $r++) { ?>
			  
			  <?php 
			    for ($c = 0; $c<3 ; $c++) { ?>
			  
			    <?php 
			    if (isset($category[$o]))
			     { ?>
			  
				 <div class="nygal_box">
				<?php
				 $query4 = "select id, thumb, clean_thumb from gal_images where id = '$pic[$o]'";
				 $result4 = $db->query($query4);
				 $im = $result4->fetch_array()
				?>	 
			 	<a href="subpage.php?s=2&amp;k=<?php echo $catnum[$o]; ?>" target="_parent"><img src="<?php echo $im[2]; ?>" alt="" width="250" border="0" class="nygal_img" /></a>	 	 
				     <div style="text-align: center;">
				   		<br />
				       <a href="subpage.php?s=2&amp;k=<?php echo $catnum[$o]; ?>" target="_parent" class="nygal"><?php echo $category[$o] ?></a>
					   <br />
					   <?php echo number_format($t[$o], 0, ',', '.'); echo " bilde"; if ($t[$o]>1) {echo "r";} ?>
				     </div>
				 </div>				 
			     <?php  $o=$o+1;  
			       }
			    } 
			} 		
			?>		
		</div>
			<div class="mobile">
				<?php include('gal_ad.php'); ?>		
			</div>
	
	
	</div>
</div>
