<?php
//include('config.php');

// get user
$loggedin=0;

@$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);
if ($userid > 0) {$loggedin=1;}

// get user slut

// HACK: Visning som om alle altid er logged in
// $loggedin = 1;
// HACK

$nrpp = 24; //number of rows per page

if(!isset($_GET['p'])){$page = 1;}
else {$page = $_GET['p'];}

$unixdate = date('U')+604800 ;
$cweek = date ('W',$unixdate);
$cyear = date ('o',$unixdate);

$query = "select id from gal_ukens where uke = '$cweek' AND aar = '$cyear'";
@$latest = $db->query($query)->fetch_object()->id;

if(isset($latest)) {
	$query = "select imgid, uke, aar from gal_ukens where id<>'$latest' order by aar desc, uke desc";
	}
else {
	$query = "select imgid, uke, aar from gal_ukens order by aar desc, uke desc";
	}
$un=0;
$result = $db->query($query);
while ( $uge = $result->fetch_array() ) {
	$uge_1[$un] = $uge[1];
    $aar_1[$un] = $uge[2];

	$query1 = "select id, thumb, tekst, fotograf, navn, stemmer, poeng from gal_images where id = '$uge[0]'";
	@$id[$un] = $db->query($query1)->fetch_object()->id;
	@$thumb[$un] = $db->query($query1)->fetch_object()->thumb;
	@$tekst[$un] = $db->query($query1)->fetch_object()->tekst;
	@$fotograf[$un] = $db->query($query1)->fetch_object()->fotograf;
	@$navn[$un] = $db->query($query1)->fetch_object()->navn;
	@$stemmer[$un] = $db->query($query1)->fetch_object()->stemmer;
	@$poeng[$un] = $db->query($query1)->fetch_object()->poeng;

$un=$un+1;
}
?>
<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=5" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Ukens Bilde</a>
</div>

<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			Ukens Bilde
		</div>
		<div class="nygal_content">
			<div class="nyunit_text">
			<br />
			Utvelgelsen av Ukens Bilde skjer nå helt automatisk natt mot mandager klokka 00.10.<br />
			<br />
			Alle bilder som får 1 eller flere stjerner får plusset på 0.5 poeng på den poengsum du gir.<br />
			Dette for at valget skal bli så rettferdig som mulig.<br />
			I praksis vil det si at alle bilder har like store mulighet til å bli valgt.<br />
			Det er du som bestemmer ved å gjøre aktive valg.<br />
			Om samme fotograf eller nesten samme motiv går til topps flere uker i rad, kan våre moderatorer velge ett annet bilde.<br />
			</div>
			<br />
			<hr class="red_hr" />
			<br />
<?php
$pages = ceil($un/$nrpp);
$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;

$rows=ceil($n/3);
?>

<!-- bladring-divtag  -->
			<div class="nygal_bladring"> 
			<?php
			if ($pages > 1) { 
				if ($page > 0)  {
				?>
			   <a href="subpage.php?s=5&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=5&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
			  	<?php
			  						}
			}
			?>
			</div>
<!-- bladring-divtag slut -->
<br />
<?php for ($tr = 0 ; $tr<($nrpp/3) ; $tr++) { 
	 	for ($td = 0 ; $td<3 ; $td++) { 
		  
		  if (isset($thumb[$m])) { ?>
		  
		  <div class="nygal_box">
		  <b>Uke <?php echo $uge_1[$m]; ?>, <?php echo $aar_1[$m]; ?></b><br /><br />
	 	
	 		<?php if ($stemmer[$m]>0) { $stars = round($poeng[$m]/$stemmer[$m]); } else { $stars = 0; } ?>
				<div class="nygal_starhead">
					<img src="graphics/<?php echo $stars;?>stars.gif" alt="" />
				</div>
							
<?php if ($loggedin==1) { ?>  	 
	 <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $navn[$m]; ?>&id=<?php echo $id[$m]; ?>"><img src="<?php echo $thumb[$m]; ?>" width="250" alt="" class="nygal_img" /></a>
<?php } else { ?>
    <img src="<?php echo $thumb[$m]; ?>" width="250" alt="" class="nygal_img" />
<?php } ?>	 
	 
	    
		 <br />
		 	<div style="text-align: center;">
		 		<?php echo $tekst[$m] ?><br />
		 		<?php echo "&copy; ".$fotograf[$m] ?>
		 	</div>
		 </div> 
	    
     <?php
     $m++; 
     } 	  
		if($td < 2) { 
			 } 
		}
}
	 ?>
<br />
<!-- bladring-divtag  -->
			<div class="nygal_bladring"> 
			<?php
			if ($pages > 1) { 
				if ($page > 0)  {
				?>
			   <a href="subpage.php?s=5&amp;p=1" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
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
			   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=5&amp;p=<?php echo $b ?>" target="_parent" style="color: #000000;"><?php }
			   	  	 echo $b;
			   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
			   	if ($b==$page){echo " </b>";} 
			   		}
			   	if($til<$pages) {echo "..";}	
			  if ($page<$pages+1)   {
			  	?>
			  	&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=5&amp;p=<?php echo $pages; ?>" target="_parent" style="color: #000000;">>></a>
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


