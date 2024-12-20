<?php

if(isset($_GET['u'])){$u = $_GET['u'];} else {$u="";} 

$getimg=mysql_query("SELECT * FROM `gal_images` WHERE navn = '$u'");

?>


<br />
<div id="bo_heading">
	 <span style="font-size: 14px; font-weight: bold;">&nbsp;&nbsp;&nbsp;Bildets plassering i gallerierne</span>
	 <img src="graphics/filler.gif" height="1px" width="50px" />
	 
	
	<img class="logo_align" src="graphics/jernbanenet_h28.gif">
</div>
<div class="bo_intro">
<br />
<?php
 $n=0;
 while($img=mysql_fetch_row($getimg)) {
 if ($n==0) { ?>
 
 
 <table cellpading="0" cellspacing="0" border="0">
  <tr>
   <td width="280">
    <a target="_parent" href="subpage.php?s=0&id=<?php echo $img[0]; ?>"><img src="<?php echo $img[2]; ?>" style="border: 1px solid black;"></a>
   </td>
   <td valign="top">
    <table cellpadding="1" cellspacing="0" border="0" width="760">
               <tr>
               <br />
                <td width="80" valign="top">
                   <b>Fotograf:</b>
                </td>
                <td valign="top">
                     <?php echo $img[5]; ?>
                </td>
               </tr>
        <?php if ($img[4]!='') { ?>
               <tr>
                <td width="80" valign="top">
                  <b>Tekst:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $img[4]; ?>
                </td>
               </tr>
        <?php } 
              if ($img[6]!='') {
        ?>
               <tr>
                <td width="80" valign="top">
                  <b>Dato:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo date('d.m.Y',$img[6]); ?>
                </td>
               </tr>
    <?php 
              } 
    if ($img[13] != '') { ?>
               <tr>
                <td width="80" valign="top">
                  <b>Kamera:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php if ($img[13] != '') {
		         	echo $img[13]; echo ", "; echo $img[14]; echo '<br />';
		         	       }
		   ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Exif-data:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php if ($img[13] != '') {
		         	echo $img[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $img[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[17];
		         	echo '<br />';
  		         	}
		        ?>
                </td>
               </tr>
    <?php  } ?>           
              </table> 
   </td>
  </tr>
 </table>  
 <br />
 	 	
 	<?php } ?>
 <hr />	
 <br />
<?php 
 $gettype=mysql_query("SELECT typename, katid FROM `gal_type` WHERE typeid = '$img[9]'");
 $type=mysql_fetch_row($gettype);
 
 $getkat=mysql_query("SELECT katname, natid, natnavn FROM `gal_kategori` WHERE katid = '$type[1]'");
 $kat=mysql_fetch_row($getkat);
 
 $getunit=mysql_query("SELECT enhet FROM `gal_unit` WHERE numid = '$img[10]'");
 $unit=mysql_fetch_row($getunit);
?>
 <a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $kat[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[2]; ?></a> -> 
 <a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $type[1]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kat[0]; ?></a> -> 
 <a href="<?php echo $path; ?>subpage.php?s=3&t=<?php echo $img[9]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $type[0]; ?></a> -> 
 <a href="<?php echo $path; ?>subpage.php?s=4&u=<?php echo $img[10]; ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $unit[0]; ?></a>
 <br /><br />
 <?php
 $n=$n+1;
 }
?>	  <br />
</div>




<br />




