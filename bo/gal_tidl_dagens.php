<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ 
$loggedin = 1;
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);

// get users real name from database
/*
$query = "select real_name, admin from phorum_users where user_id='$userid'";
$username = $db->query($query)->fetch_object()->real_name;
$isadmin = $db->query($query)->fetch_object()->admin;
*/
} else {$loggedin = 0;}

$nrpp = 30; //number of rows per page
//$startdate = (date('U')-604800);  // current date minus one week
 
if(!isset($_GET['p'])){$page = 1;}
else {$page = $_GET['p'];}

if(isset($_GET['f'])) {$photographer = $_GET['f'];}

$n=0;

$query = "select a.id, a.imgid, b.id
from gal_dagens a,
gal_images b
where a.imgid = b.id
order by a.id desc";
$result = $db->query($query);
while ($i = $result->fetch_array() ) {
$ar[$n] = $i[1];
$as[$n] = $i[0];

$n=$n+1;	
}

$pages = ceil($n/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;
?>
<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Dagens Bilde</a>
</div>
<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			Dagens Bilde
		</div>
		<div class="nygal_content">
			
			<div class="nyunit_text">
			<br />
			Dagens Bilde velges ut alle dager klokka 19.00.00.<br />
			Alle bilder som får 1 stjerne eller flere, og som er delt på Jernbane.Net i løpet av tidsrommet 19.00.01 til 18.59.59 kommende dag, har muligheten til å bli valgt til Dagens Bilde.<br />
			Det er du som bestemmer !<br />
			Om ingen bilder lastes opp, eller ikke oppnår stjerner i perioden, velges ingen bilder det aktuelle døgnet.<br />
			Det er ingen automatikk i at <a href="subpage.php?s=17">Dagens Bilde</a> blir <a href="subpage.php?s=5">Ukens Bilde</a>, det er fortsatt du som betrakter bildene, som har muligheten til å avgjøre hvilket bilde som blir valgt.
			</div>
			<br />
			<hr class="red_hr" />
			<br />
				
			<?php
			   
			if ($loggedin == 0)
			{ // user is not logged in
			?>
			
			  <br /><br />
			  Du er ikke innlogget. Du må være logget inn for å se denne siden. Log inn <a href="../phorum/login.php">her</a><br /><br /><br />
			
			<?php
			}
			else
			{
			?>
			
			<div class="nygal_bladring">
			<!-- bladring-divtag  -->
			<?php
				if ($pages > 1) { 
				if ($page > 0)  {
				?>
			   <a href="subpage.php?s=17&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=17&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
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
			   
				@$query3 = "select datetime from gal_dagens  where imgid = '$ar[$m]'";	
			    @$dagensdate = $db->query($query3)->fetch_object()->datetime;
								
				 if (isset($img[0])) {  ?>
				<div class="nygal_box">	
				<b><?php echo date("d.m.Y",$dagensdate); ?></b>
				<br /><br />
			
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
			   	
				<div style="text-align: center;">
		 		<?php echo $img[4]; ?><br />
		 		<?php echo "&copy; ".$img[5]; ?>
				</div>	
				<br />
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
			   <a href="subpage.php?s=17&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=17&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=17&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
			  	<?php
			  						}
			}
			?>
			<!-- bladring-divtag slut -->
			</div>
			<br /><br />
			
		<?php
		  }
		?>	
			
			
		</div>

	<?php include('gal_ad.php'); ?>
	</div>
</div>







