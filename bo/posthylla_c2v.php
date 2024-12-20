<?php

$nrpp = 32; //number of rows per page

$startdate = (date('U')-604800);  // current date minus one week
 
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

if ($search == 0 )
{
$init=mysql_query("SELECT id FROM gal_images WHERE timestamp > '$startdate' ORDER BY id DESC");
}

if ($search == 1 )
{
$init=mysql_query("SELECT id, fotograf FROM gal_images WHERE fotograf like '%$photographer%' ORDER BY id DESC");
}

while($i=mysql_fetch_row($init)) {
$ar[$n] = $i[0];
if ($search==1) { if ($n==0) {$fotograf=$i[1];} }
$n=$n+1;	
}

$pages = ceil($n/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;

?>

<br />
<div id="posthylla_heading">
<?php if ($search == 0) { ?>
   &nbsp;&nbsp;&nbsp;De siste opplastede bilder fra Postvogna
   <?php } ?>
<?php if ($search == 1) { 
 echo "Fotograf: "; echo $fotograf;
  } ?>   
   <img src="graphics/filler.gif" width="10px" height="23px" />
   
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>


<div class="posthylla_frame">
<br />
<table width="1270" cellspacing="0" cellpadding="0" border="0">
 <tr>
  <td width="12"></td>
  <td align="left">
   <span style="font-size: 16px;">
   <?php if ($search == 0 ) { ?>
   Posthylla!</span><br /><br />
   Dette er kun et midlertidig oppbevaringssted for nylig opplastede bilder. Bildene vil fortl&oslash;pende bli sortert inn under de rette kategoriene i v&aring;rt store bildegalleri. Bildene vil bli vist i Posthylla i 7 dager. 
   <br />
   <br />
<?php } ?>
  </td>
  <td>
  </td>
 </tr>
</table>

<div id="posthylla_fourimg">
<div style="color: #FFFFFF; text-align: center;">
<br />
<?php 
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=50&amp;p=1&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><</a>&nbsp;&nbsp;
   <?php 
					}
     
 for ($b = 1 ; $b<$pages+1 ; $b++) 
   { 
   	if ($b>1) {echo chr(124); }
   	
   	if ($b==$page){echo "<b> ";}
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=50&amp;p=<?php echo $b ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><?php }
   	  	 
   	  	  echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   }
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;">></a>&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php echo $pages; ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;">>></a>
  	<?php 	
  						} 
} 
?>
<br /><br />
</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php for ($tr = 0 ; $tr<($nrpp/4) ; $tr++) { ?>
 <tr> 
  <?php for ($td = 0 ; $td<4 ; $td++) { ?>
  <td align="center" valign="top">
   
   <?PHP
     @$getimg = mysql_query("SELECT * FROM gal_images WHERE id = '$ar[$m]'");
	 @$img = mysql_fetch_row($getimg);
	 if (isset($img[0])) {
	 ?>
	 <div class="posthylla_box">
	 <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $img[3]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $img[2] ?>" width="250" border="0" alt=""></a>
	 	 <hr style="background-color: #FFFFFF; color: #FFFFFF; height: 1px; collapse:collapse;" />
	     <div style="text-align: center; color: #FFFFFF;">
	   <?php echo $img[4]; ?><br />
	   <?php echo chr(169)." ".$img[5]; ?>
	     </div>
	     <hr style="background-color: #FFFFFF; color: #FFFFFF; height: 1px; collapse:collapse;" />
	   <?php
	     if ($img[11]>0) { $stars = round($img[11]/$img[12]); } else { $stars = 0; }
	   ?>
	    <img src="graphics/<?php echo $stars;?>stars.gif" alt="" /><div style="display: inline-block; width: 40px;"></div>
	  <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $img[3]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $path; ?>graphics/finn.jpg" border="0" alt="" /></a>

     
     <?php  $m=$m+1  ?>
   </div>
    
   <br /><br />
   <?php } ?>
  </td>
  <?php } ?>
 </tr>
<?php } ?>
</table>



<div style="color: #FFFFFF; text-align: center;">	
<br /><br />

<?php 
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=50&amp;p=1&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php if ($page==1) {echo "1";} else {echo $page-1;} ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><</a>&nbsp;&nbsp;
   <?php 
					}
     
 for ($b = 1 ; $b<$pages+1 ; $b++) 
   { 
   	if ($b>1) {echo chr(124); }
   	
   	if ($b==$page){echo "<b> ";}
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=50&amp;p=<?php echo $b ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;"><?php }
   	  	 
   	  	  echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   }
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;">></a>&nbsp;&nbsp;<a href="subpage.php?s=50&amp;p=<?php echo $pages; ?>&amp;search=<?php echo $search; ?>&amp;photographer=<?php echo $photographer; ?>" target="_parent" style="color: #F0F0F0;">>></a>
  	<?php 	
  						} 
} 
?>

<br /><br />
</div>
</div>
<br /><br />
</div>





<br />


</body>
</html>