<?php

$nrpp = 32; //number of rows per page
$startdate = (date('U')-604800);  // current date minus one week
 
if(!isset($_GET['p'])){$page = 1;}
else {$page = $_GET['p'];}

if(isset($_GET['f'])) {$photographer = $_GET['f'];}

$n=0;
$photographer = mysqli_real_escape_string($db,$photographer);

$query = "select id, fotograf from gal_images where fotograf = '$photographer' order by id desc";

$result = $db->query($query);
while ($i = $result->fetch_array() ) {
$ar[$n] = $i[0];
if ($n==0) { $fotograf=$i[1]; }
$n=$n+1;	
}

$pages = ceil($n/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;
?>
<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=40" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Fotografer</a> > <a href="<?php echo $path; ?>subpage.php?s=41&f=<?php echo $fotograf; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $fotograf; ?></a>
</div>
<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			Fotograf: <?php echo $fotograf; ?>
		</div>
		<div class="nygal_content">
			
			
			<div class="nygal_bladring">
			<!-- bladring-divtag  -->
			<?php
				if ($pages > 1) { 
				if ($page > 0)  {
				?>
			   <a href="subpage.php?s=41&amp;p=1&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
			   <?php 
			   }					
				$fra=1; $til=$pages;
				if ($pages > 20)
					{
						if ($page>4) {$fra=$page-4;} else {$fra=1;}
						$til=$fra+19; if ($til>$pages) {$til=$pages;}	
						if ($fra>($til-19)) {$fra=$til-19;}
					}				
				else {$til=$pages;}	
				if ($fra>1) {echo "..";}		
			 	for ($b = $fra ; $b<$til+1 ; $b++) 
			   		{ 
			   		if ($b>1) {if ($b>$fra){echo chr(124);}}
			   	
			   	if ($b==$page){echo "<b> ";}
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=41&amp;p=<?php echo $b ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php echo $pages; ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;">>></a>
			  	<?php
			  						}
			}
			?>
			<!-- bladring-divtag slut -->
			</div>
			<br /><br />
			
			
			
			<?php for ($tr = 0 ; $tr<(ceil($nrpp/3)) ; $tr++) { 
	 		for ($td = 0 ; $td<3 ; $td++) { 
	 		
			
			   
			
			   	@$query1 = "select * from gal_images where id = '$ar[$m]'";
			    $result1 = $db->query($query1);
				$img = $result1->fetch_array();
			   
				 if (isset($img[0])) {  ?>
				<div class="nygal_box">				 
				 	<?php if ($img[11]>0) { $stars = round($img[11]/$img[12]); } else { $stars = 0; } ?>
					<div class="nygal_starhead">
						<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
					</div>
				<?php	if ($loggedin == 0) { ?>
				<img src="<?php echo $img[2]; ?>"  class="nygal_img alt="" />
				<?php } else { ?>
				 <a href="subpage.php?s=0&amp;id=<?php echo $img[0]; ?>" target="_parent"><img src="<?php echo $img[2] ?>" width="250" class="nygal_img" alt=""></a>
				<?php } 
				     if ($img[11]>0) { $stars = round($img[11]/$img[12]); } else { $stars = 0; }
				  $m=$m+1  ?>
			   	
			   
				   <div class="nygal_imgtext">
				   <?php echo $img[4]; ?>
			       </div>	    
					<div class="nygal_imgbund">
						<div class="nygal_author">
							<?php echo "&copy; ".$img[5]; ?>
						</div>
						<div class="nygal_searchicon">
							
						</div>
					</div>
				
				</div>
			    
			   
			   <?php } 
	 		}
			}
			   ?>
			<br /><br />
			<div class="nygal_bladring">
			<!-- bladring-divtag  -->
			<?php
				if ($pages > 1) { 
				if ($page > 0)  {
				?>
			   <a href="subpage.php?s=41&amp;p=1&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
			   <?php 
			   }					
				$fra=1; $til=$pages;
				if ($pages > 20)
					{
						if ($page>4) {$fra=$page-4;} else {$fra=1;}
						$til=$fra+19; if ($til>$pages) {$til=$pages;}	
						if ($fra>($til-19)) {$fra=$til-19;}
					}				
				else {$til=$pages;}	
				if ($fra>1) {echo "..";}		
			 	for ($b = $fra ; $b<$til+1 ; $b++) 
			   		{ 
			   		if ($b>1) {if ($b>$fra){echo chr(124);}}
			   	
			   	if ($b==$page){echo "<b> ";}
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=41&amp;p=<?php echo $b ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=41&amp;p=<?php echo $pages; ?>&amp;f=<?php echo $photographer; ?>" target="_parent" style="color: #000000;">>></a>
			  	<?php
			  						}
			}
			?>
			<!-- bladring-divtag  -->
			</div>
			<br /><br />	
		</div>

	<?php include('gal_ad.php'); ?>
	</div>
</div>







