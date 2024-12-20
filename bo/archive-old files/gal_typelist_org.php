<?php

$m=0;
$kat = $_GET['k'];
$back="yes";

$getlandkat=mysql_query("SELECT katname, natnavn, natid FROM gal_kategori WHERE katid = '$kat'");
$landkat=mysql_fetch_row($getlandkat);

 $catlist=mysql_query("SELECT typeid, typename, plass FROM gal_type WHERE katid = '$kat' AND typename <>'Ute av bruk for tilfellet' ORDER BY plass ASC");
 while($cat=mysql_fetch_row($catlist)) {
	$n=0;
	$unitlist=mysql_query("SELECT id FROM gal_images WHERE type = '$cat[0]' AND posthylla = 1");
	while($unit=mysql_fetch_row($unitlist)) {
	$lok[$n] = $unit[0];	
	$n=$n+1;
	}

	if ($n>0) {  // we acually have a picture of this type in the database
		$get = mt_rand(0,$n-1); 
		$getimg=mysql_query("SELECT thumb, type FROM gal_images WHERE id = '$lok[$get]'");
		$img = mysql_fetch_row($getimg);
    // now we put the output into some arrays
        $hl[$m] = $cat[1];
        $image[$m] = $img[0];
        $typeid[$m] = $img[1];
        $m=$m+1;			 
			  }
						} 	// end every type	
		
// and now we start the styled output
$rows=ceil($m/4);
$m=0;
?>
<div id="gal_breadcrum">
<a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $landkat[2]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $landkat[1]; ?></a> >
 <a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $kat; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $landkat[0]; ?></a>
</div>

<div id="posthylla_heading">
   &nbsp;&nbsp;&nbsp; <?php echo $landkat[0]; ?>
   <img src="graphics/filler.gif" width="10px" height="23px" />
   
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<div class="posthylla_frame">
<br />
<div id="posthylla_fourimg">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php
 for ($r = 0 ; $r<($rows) ; $r++) { ?>
 <tr> 
  <?php 
    for ($c = 0; $c<4 ; $c++) { ?>
  <td align="center" valign="top">
    <?php if (isset($image[$m])) { ?>
  
	 <div class="posthylla_box">
	 <a href="subpage.php?s=3&amp;t=<?php echo $typeid[$m]; ?>" target="_parent"><img src="<?php echo $image[$m] ?>" alt="" width="250" border="0" alt="" /></a>
	 	 
	     <div style="text-align: center; color: #FFFFFF;">
	   		<br />
	       <a href="subpage.php?s=3&amp;t=<?php echo $typeid[$m]; ?>" target="_parent" class="gal"><?php echo $hl[$m]; ?></a>
	     </div>
	    
     <?php  $m=$m+1;  
    	}
     ?>
   </div>

  </td>
  <?php } ?>
 </tr>
<?php } ?>
</table>

</div>
<br /><br />
</div>


<br />
