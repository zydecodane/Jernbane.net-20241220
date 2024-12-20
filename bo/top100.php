<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ 
$loggedin = 1;
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);

// get users real name from database

$query = "select real_name, admin from phorum_users where user_id='$userid'";
$username = $db->query($query)->fetch_object()->real_name;
$isadmin = $db->query($query)->fetch_object()->admin;

} else {$loggedin = 0;}

$nrpp = 30; //number of images per page

// $startdate = (date('U')-259200);  // current date minus five days
 
if(!isset($_GET['p'])){$page = 1;}
else {$page = $_GET['p'];}

$search = 0;

if(isset($_POST['search'])) { $search = $_POST['search']; }
if(isset($_GET['search']))  { $search = $_GET['search']; }

if(isset($_POST['photographer'])) {$photographer = $_POST['photographer'];}
if(isset($_GET['photographer'])) {$photographer = $_GET['photographer'];}

if (isset($photographer)) {
if ($photographer=='') {$search=0;}
}

$n=0;

$query1 = "select * from gal_top100 order by poengsum desc";
/*
$query1 = "select a.id, sum(b.vaegtet_poeng) from gal_images a, gal_comments b
where a.url = b.url and timestamp > 1441065600
group by b.url order by 2 desc limit 100";
*/

$result1 = $db->query($query1);
while ($i = $result1->fetch_array() ) {	

$ar[$n] = $i[1];
$ap[$n] = $i[2];
$n=$n+1;	
}

if(!isset($_GET['p'])) {	// shuffler hvis vi ikke har bladret
// shuffle($ar);
}

$pages = ceil($n/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;

?>

<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=42" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Top 100</a>
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
		<div class="gal_heading">
			Top 100
		</div>
		<div class="nygal_content">

			<div class="nygal_headtext">
				<span style="font-size: 16px;">
				<?php if ($search == 0 ) { ?>
				De 100 best likte bilder fra galleriene</span><br />
				<br />
			<?php } ?>
			</div>

<!-- bladring-divtag  -->
<div class="nygal_bladring"> 


<?php
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=42&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=42&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
   	  	 echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   		}
   	if($til<$pages) {echo "..";}	
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
  	<?php
  						}
}
?>
</div>
<!-- bladring-divtag slut -->


	 <?php for ($tr = 0 ; $tr<($nrpp/3) ; $tr++) { 
	 	for ($td = 0 ; $td<3 ; $td++) { 
			@$query2 = "select * from gal_images where id = '$ar[$m]'";
			$result2 = $db->query($query2);
			@$img = $result2->fetch_array();   
	 		if (isset($img[0])) {
	 		?>
		<div class="nygal_box"> 

			<?php if ($img[11]>0) { $stars = round($img[11]/$img[12]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
			<?php	if ($loggedin == 0) { ?>
						
				<img src="<?php echo $img[2]; ?>"  class="nygal_img alt="" />
				<?php } else { ?>
				<a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $img[3]; ?>&id=<?php echo $img[0]; ?>"><img src="<?php echo $img[2]; ?>" width="250" alt="" class="nygal_img"></a>
				<?php } ?>
				
				<div style="text-align: center;">
				   <?php echo $img[4]; ?><br />
				   <?php echo "&copy; ".$img[5]; ?>    
				   <br />
				   <b>Poengsum: <?php echo number_format($ap[$m],0); ?></b>  
				</div>
			<?php  $m=$m+1; ?>
		</div>	
				
		<?php } 	  
		if($td < 2) { 
			 } 
		}

	} ?>
<br /><br />
	

<!-- bladring-divtag  -->
<div class="nygal_bladring"> 
<?php
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=42&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=42&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
   	  	 echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   		}
   	if($til<$pages) {echo "..";}	
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=42&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
  	<?php
  						}
}
?>
</div>
<!-- bladring-divtag slut -->


<br /><br />
</div>
<?php include('gal_ad.php'); ?>
</div>



