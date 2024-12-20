<?php
// fancybox-script start
?>
<script type="text/javascript" src="fancybox/jquery_min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$("a#single").fancybox({
		'padding'  : 0,
		'margin'   : 0
		});
		$("a.grouped_elements").fancybox({
			'padding'  : 0,
		    'margin'   : 0,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition'     : 'none',
			'titleShow'         : 'none'
		});
                documentGotoActive();
				});
</script> 

<?php
// fancybox-script slut

if(!isset($_GET['p'])){$page = 1;}
else {$page = $_GET['p'];}

if(!isset($_POST['eg'])){$eg = 0;}
else {$eg = $_POST['eg'];}
if(isset($_GET['eg'])){$eg = $_GET['eg'];}

if(!isset($_POST['ae'])){$ae = -1;}
else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}

$nrpp = 20; //number of rows per page

// how many are there...read them into an array
$n=0;
$query = "select id from gal_images where posthylla = '$eg' order by id";
$result = $db->query($query);
while ( $init = $result->fetch_array() ) {
$id[$n] = $init[0];
$n=$n+1;
}
$antal=$n;

$pages = ceil($antal/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;
?>

<div class="wide_heading">
	Posthylla
</div>
<div class="wide_content" style="overflow: hidden;">
	<span style="font-size: 10px;"><?php echo $m+1; echo " - "; if ($m+$nrpp<$antal){echo $m+$nrpp;} else {echo $antal;} echo " af "; echo $antal; echo " bilder til behandling";?></span>
	<br /><br />
	<form name="egform" id="egform" method="post" action="index.php?s=1">
		<div style="width: 120px; float: left">
			opplastede &nbsp;&nbsp;<input type="radio" name="eg" <?php if($eg == 0){ echo "checked";} ?> value="0" onClick="document.egform.submit()" />
		</div>
		<div style="width: 120px; float: left">
			parkerte  &nbsp;&nbsp;<input type="radio" name="eg" <?php if($eg == 2){ echo "checked";} ?> value="2" onClick="document.egform.submit()" />
		</div>
	</form>
	<br /><br />	

	<!-- bladring-divtag  -->
	<div style="width: 1240px; text-align: center;">
	<?php
	if ($pages > 1) { 
		if ($page > 0)  {
		?>
	   <a href="index.php?s=1&amp;p=1&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
	   <?php 
	   }					
		$fra=1; $til=$pages;
		if ($pages > 30)
			{
				if ($page>14) {$fra=$page-14;} else {$fra=1;}
				$til=$fra+29; if ($til>$pages) {$til=$pages;}	
				if ($fra>($til-29)) {$fra=$til-29;}
			}				
		else {$til=$pages;}	
		if ($fra>1) {echo "..";}		
	 	for ($b = $fra ; $b<$til+1 ; $b++) 
	   		{ 
	   		if ($b>1) {if ($b>$fra){echo chr(124);}}
	   	
	   	if ($b==$page){echo "<b> ";}
	   	  if ($b!=$page)  { ?>&nbsp;<a href="index.php?s=1&amp;p=<?php echo $b ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><?php }
	   	  	 echo $b;
	   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
	   	if ($b==$page){echo " </b>";} 
	   		}
	   	if($til<$pages) {echo "..";}	
	  if ($page<$pages+1)   {
	  	?>
	  	&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php echo $pages; ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">>></a>
	  	<?php
	  						}
	}
	?>
	</div>
	<!-- bladring-divtag slut -->
	
	
	<br /><br />
	<div style="width: 1240px; border-top: 1px solid #800000; border-bottom: 1px solid #800000; "> 
	<br />
	<?php 
	
	for ($tr = 0 ; $tr<($nrpp) ; $tr++) { 
		@$query = "select id, url, thumb, tekst, fotograf, dato, type, nummer, timestamp, detailid, navn from gal_images where id = '$id[$m]'";
		$result = $db->query($query);
		$img = $result->fetch_array();
		$m=$m+1; 
	        $thisae = $tr+1;
			
//	echo '<p> id = ' . $id[$m-1] . ' og $img[0] = ' . $img[0] . '</p>';
			
	if ($img[0] > 0) {
	if ($m <= $antal) {
	?>
		<div class="phylla_line">
			<div class="phylla_img">
				<a href="../subpage.php?s=0&id=<?php echo $img[0]; ?>"><img src="<?php echo $img[2]; ?>" class="adm_img" alt="<?php echo $img[0]; ?>" title="<?php echo $img[0]; ?>" /></a>
			</div>
	
			<div class="phylla_text" <?php if( ($tr+1)==$ae || ($ae>($tr+1) && ($m == $antal || ($tr+1)==$nrpp) ) )  { echo 'id="aktivt_element"'; } ?> >
				<div class="phylla_text_left">
					<b>Fotograf:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo htmlspecialchars($img[4]); ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Opplastet:</b>
				</div>
				<div class="phylla_text_right">
					<?PHP echo date("d.m.Y - H:i",$img[8]); ?><br />
				</div>
				<br /><br />
	<?php
//	echo '<p> img[7] er ' . $img[7] . '</p>';
	$query = "select numid, enhet from gal_unit where numid = '$img[7]'";
	$result = $db->query($query);
	$unit = $result->fetch_array();
//	echo '<p>' . $unit[0] . $unit[1] . '</p>';
	
	$query = "select detailid, navn from gal_unitdetail where detailid = '$img[9]'";
	$result = $db->query($query);
	$unitdetail = $result->fetch_array();
//	echo '<p>' . $unit . '</p>';
	
	$query = "select typeid, typename, katid from gal_type where typeid = '$img[6]'";
	$result = $db->query($query);
	$type = $result->fetch_array();
//	echo '<p>' . $unit . '</p>';
	        
	$query = "select katid, katname, natid from gal_kategori where katid = '$type[2]'";
	$result = $db->query($query);
	$kat = $result->fetch_array();
//	echo '<p>' . $unit . '</p>';
	
	$query = "select natid, natnavn from gal_nations where natid = '$kat[2]'";
	$result = $db->query($query);
	$land = $result->fetch_array();
//	echo '<p>' . $unit . '</p>';
	
	
	
	$check=0;
	?>
			    <div class="phylla_text_left">
					<b>Land:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $land[1]; if ($land[1]!='') { $check=$check+1; } ?><br />
				</div>   
				<div class="phylla_text_left">
					<b>Kategori:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $kat[1]; if ($kat[1]!='') { $check=$check+1; } ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Type:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $type[1]; if ($type[1]!='') { $check=$check+1; } ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Nummer:</b>
				</div>				
				
				<div class="phylla_text_right">
					<?php $needle='andre';
							if (strlen(strstr($unit[1],$needle))>0) {
							?><font color=red><b><?php echo $unit[1]; ?></font></b><?php if ($unit[1]!='') { $check=$check+1; }} 
							else
							{echo $unit[1]; if ($unit[1]!='') { $check=$check+1; }}?><br />
				</div>
				<div class="phylla_text_left">
					<b>Detalj:</b>
				</div>
				<div class="phylla_text_right">
				  <?php echo $unitdetail[1] ?> <br />
				</div> 
					<br /><br />
				<div class="phylla_text_left">
					<b>Tekst:</b>
				</div>	
				<div class="phylla_text_right">
					<?php echo htmlspecialchars($img[3]) ?><br />
				</div>  

				<div class="phylla_text_left">
					<b>Dato:</b>
				</div>	
				<div class="phylla_text_right">
					<?php if ($img[5]!='') { echo date("d.m.Y",$img[5]); } ?><br />
				</div>  
				
				<div class="phylla_text_left">
					<b>Postvogna:</b>
				</div>	
				<div class="phylla_text_right">
					<?php
					$slutp = strrpos($img[10],'.',$offset = 0 ); // filtrerer .jpg fr strengen
					?>
					<a href="https://jernbane.net/forum/search/?q=<?php echo substr($img[10],0,$slutp); ?>" target="_blank">Finn innlegget der bildet er vist</a>
				</div>
			</div>
		<div class="phylla_buttons">
            <?php 
            if ($eg == 0) {
            ?>
            <div class="phylla_bottom_line">
		     <?php if ($check==4) { ?>
		        <form name="ok" method="post" action="adm_ph_gal_set.php">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="submit" value="til galleriet som det er <?php if (strlen(strstr($unit[1],$needle))>0) {echo " ???";} ?>" class="button15" />
		        </form>
		        <?php
		             } else { echo "<font color=red>kategorisering ikke fullført</font><br />"; }
		        ?>
			</div>
			<div class="phylla_bottom_line">
		        <form name="forum" method="post" action="adm_ph_forum_set.php">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="submit" value="parker bildet - vises i forum" class="button15" />
		        </form> 
			</div>
			<div class="phylla_bottom_line">
		        <form name="cat" method="post" action="index.php?s=6">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="submit" value="kategorisering ..." class="button15" />
		        </form> 
			</div>
			<div class="phylla_bottom_line">
		        <form name="copy" method="post" action="index.php?s=7">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="submit" value="kopiere til ytterligere plassering ..." class="button15" />
		        </form> 
			</div>
			<div class="phylla_bottom_line">
		        <form name="retext" method="post" action="index.php?s=15">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="hidden" name="padmin" value="1" />
		         <input type="submit" value="rett teksten på bildet" class="button15" />
		        </form> 
			</div>
			<div class="phylla_bottom_line">
		        <form name="del" method="post" action="adm_ph_slet.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="hidden" name="padmin" value="1" />
		         <input type="submit" value="slett bildet" class="button15" />
		        </form> 
			</div>
            
             <?php } 
                if ($eg == 2) {
                    $query1 = "select typeid, typename from gal_type where katid = 1153";
                    $result1 = $db->query($query1);
                    while ( $liste1 = $result1->fetch_array() ) {
                        $liste1[1] = str_replace(" - ","",$liste1[1]);
                        $parantes=strpos($liste1[1], "(");
                ?>            
                <div class="phylla_bottom_line">
		        <form name="del<?php echo $liste1[0] ?>" method="post" action="adm_ph_park_set.php">
		         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
		         <input type="hidden" name="page" value="<?php echo $page; ?>" />
		         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
		         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
		         <input type="hidden" name="padmin" value="1" />
                 <input type="hidden" name="ptyp" value="<?php echo $liste1[0]; ?>" />
		         <input type="submit" value="<?php echo "parker -> "; echo substr($liste1[1],0,$parantes); ?>"style="width: 220px; text-align: left;" />
		        </form> 
			</div>        
                        
               
            <?php } ?>
    
            
                    <div class="phylla_bottom_line">
                        <form name="cat" method="post" action="index.php?s=6">
                         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
                         <input type="hidden" name="page" value="<?php echo $page; ?>" />
                         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
                         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
                         <input type="submit" value="kategorisering ..." style="width: 220px; text-align: left;" />
                        </form> 
			        </div> 
                    <div class="phylla_bottom_line">
                        <form name="del" method="post" action="adm_ph_slet.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
                         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
                         <input type="hidden" name="page" value="<?php echo $page; ?>" />
                         <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
                         <input type="hidden" name="ae" value="<?php echo $thisae; ?>" />
                         <input type="hidden" name="padmin" value="1" />
                         <input type="submit" value="slet bildet" style="width: 220px; text-align: left;" />
                        </form> 
			        </div>
                    
            
            
            
            
            
            
                    
                    <?php
                    
                }
            ?>
            
		</div>

	<?php
	} 
	?>
	<br /><br />
	</div>
	<?php if($tr < $nrpp-1) { if ($m<$antal) { ?><hr /><?php }} ?>
	<br />
	<?php
	} }
	?>


</div>

<br />
	<!-- bladring-divtag  -->
	<div style="width: 1240px; text-align: center;">
	<?php
	if ($pages > 1) { 
		if ($page > 0)  {
		?>
	   <a href="index.php?s=1&amp;p=1&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
	   <?php 
						}	
						
		$fra=1; $til=$pages;
		if ($pages > 30)
			{
				if ($page>14) {$fra=$page-14;} else {$fra=1;}
				$til=$fra+29; if ($til>$pages) {$til=$pages;}	
				if ($fra>($til-29)) {$fra=$til-29;}
			}				
		else {$til=$pages;}	
		if ($fra>1) {echo "..";}		
	 	for ($b = $fra ; $b<$til+1 ; $b++) 
	   		{ 
	   		if ($b>1) {if ($b>$fra){echo chr(124);}}
	   	
	   	if ($b==$page){echo "<b> ";}
	   	  if ($b!=$page)  { ?>&nbsp;<a href="index.php?s=1&amp;p=<?php echo $b ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><?php }
	   	  	 echo $b;
	   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
	   	if ($b==$page){echo " </b>";} 
	   		}
	   	if($til<$pages) {echo "..";}	
	  if ($page<$pages+1)   {
	  	?>
	  	&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="index.php?s=1&amp;p=<?php echo $pages; ?>&amp;eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">>></a>
	  	<?php
	  						}
	}
	?>
	</div>
	<!-- bladring-divtag slut -->
	<br /><br />
	
</div>	