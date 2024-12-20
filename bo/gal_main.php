<?php

$back="yes";
// get categories where country is set
$m=0;

$natlist=mysql_query("SELECT natID, natnavn FROM gal_nations ORDER BY plass");
while($nat=mysql_fetch_row($natlist)) {
	
	$n=0;
	$natid[$m] = $nat[0];
 	$natnavn[$m] = $nat[1];

	// get kat where country is set
	
	$getkat=mysql_query("SELECT katID FROM gal_kategori WHERE natid='$nat[0]' ");
	while($kat=mysql_fetch_row($getkat)) {
		
		// get pictures where type is set
		$kat=1 //testnummer
		$getimg=mysql_query("SELECT id FROM gal_images WHERE type = 1 AND posthylla = 1 ");
		while($img=mysql_fetch_row($getimg)) {
				
        $image[$n] = $img[0]; 
		$n=$n+1;               
		                 }		
		@$ir = mt_rand(0,$n-1);
		@$pic[$m] = $image[$ir];		
											}					
        $m=$m+1;
										}	
	
// now we an array containing all categories and an variable with one random image from this category 

$rows = ceil(($m-1)/4)+1 ;
$o=0;
// and now we start the styled output

$land=$nat[1]

?>
<div id="gal_breadcrum">
  <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $natid; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $land; ?></a>
</div>


<div id="posthylla_heading">Galleri
   &nbsp;&nbsp;&nbsp;<?php echo $land; ?>
   <img src="graphics/filler.gif" width="10px" height="23px" alt="" />  
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" alt="" />
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
    <?php 
    if (isset($natid[$o]))
     { ?>
  
	 <div class="posthylla_box">
<?php
 $getim=mysql_query("SELECT id, thumb FROM gal_images WHERE id = '$pic[$o]' ");
 $im = mysql_fetch_row($getim);
?>	 
 <a href="subpage.php?s=2&amp;k=<?php echo $natnavn[$o]; ?>" target="_parent"><img src="<?php echo $im[1]; ?>" alt="" width="250" border="0" /></a>
	 	 
	     <div style="text-align: center; color: #FFFFFF;">
	   		<br />
	       <a href="subpage.php?s=2&amp;k=<?php echo $natnavn[$o]; ?>" target="_parent" class="gal"><?php echo $natid[$o] ?></a>
	     </div>
     <?php  $o=$o+1;  
       echo "</div>";
    	
    	}
     ?>
  </td>
  <?php } ?>
 </tr>
<?php } ?>
</table>

</div>
<br /><br />
</div>
<br />

