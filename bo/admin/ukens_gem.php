<?php
 
 
  
  $i='';
  if (isset($_POST['i'])) { $i=$_POST['i']; }
  if ($i != '') { 
   	$getother=mysql_query("SELECT id, url, thumb, stemmer, poeng, visning, fotograf FROM `gal_images` WHERE id = '$i'");
   	$other=mysql_fetch_row($getother);
   	
   	if (isset($other[0])) { $stars = @round($other[4]/$other[3]); }
  }
 ?>
   <td valign="top">
   <div style="width: 187px; height: 18px; text-align: center; background-color: #333333;">
    <?php
    if (isset($other[0])) { ?>
     <img src="../graphics/<?php echo $stars; ?>stars.gif">
    <?php } ?>
   </div>
   <?php
    if (isset($other[0])) { 
    	?>
   	 <a href="../subpage.php?s=0&id=<?php echo $other[0]; ?>"><img src="<?php echo $other[2]; ?>" border="0" class="adm_img" width="185"></a>	
   	<?php	} 
     else { ?> 
   <br><br>
   <div style="text-align:center;">et helt andet bilde<br>
   <br>
     <form action="index.php?s=2" method="post">
	     bilde-id: &nbsp;&nbsp;<input type="text" name="i" style="width: 70px;"><br>
	     <input type="hidden" name="f" value="<?php echo $faktor; ?>">
	     <input type="submit" style="width: 130px;" value="hent bilde">
     </form>
    </div>
   <?php  }  ?>
   </td>   
  </tr>
  <tr>
  







<?php  
     for ($m = 0 ; $m<5 ; $m++)  { ?>
   <td>
   <br>
    <form name="setukens<?php echo $m; ?>" action="adm_ukens_set.php" method="post">
    <input type="hidden" name="u" value="<?php echo $uke; ?>">
    <input type="hidden" name="y" value="<?php echo $year; ?>">
    <input type="hidden" name="i" value="<?php echo $id[$m]; ?>">
    <input type="hidden" name="n" value="<?php echo $username; ?>">
     <input type="submit" value="velg dette" style="width: 180px;">
    </form>
   </td>
   <?php } ?>
   <td>
   <br>
   <?php
      if(isset($other[0])) {
     ?>
    <form name="setukens5" action="adm_ukens_set.php" method="post">
    <input type="hidden" name="u" value="<?php echo $uke; ?>">
    <input type="hidden" name="y" value="<?php echo $year; ?>">
    <input type="hidden" name="i" value="<?php echo $other[0]; ?>">
    <input type="hidden" name="n" value="<?php echo $username; ?>">
     <input type="submit" value="velg dette" style="width: 180px;">
    </form>
    <?php } ?>
   </td>
  </tr>
  
</table>   
<hr> 
<br>
<b>Ukens bilde - uke <?php echo $uke; echo "/"; echo $year;?></b>
<br><br>
<?php
// check om denne uge findes i tabellen
$checkukens=mysql_query("SELECT id, imgid, navn, timestamp FROM `gal_ukens` WHERE uke = '$uke' AND aar = '$year'");
$check=mysql_fetch_row($checkukens);

if(isset($check[0])) {
// hent det valgte bilde
	
$getimage=mysql_query("SELECT id, thumb, fotograf, tekst, stemmer, poeng, visning FROM `gal_images` WHERE id = '$check[1]'");
$image=mysql_fetch_row($getimage);	
	
	
?>
<div style="width: 200px; display: inline-block;">	
 <?php 
   if (@$image[5]>0) {
   $stars = round($image[5]/$image[4]);  } 
   else { $stars=0; }
   ?>
<div style="width: 187px; height: 18px; text-align: center; background-color: #333333;">
   <img src="../graphics/<?php echo $stars; ?>stars.gif">
</div>
<a href="../subpage.php?s=0&id=<?php echo $image[0]; ?>"><img src="<?php echo $image[1]; ?>" width="185" class="adm_img"></a>
</div>

<div style="display: inline-block; vertical-align: top;">
<table cellpadding="1" cellspacing="0">
		 <tr>
	      <td width="70">Fotograf : </td>
	      <td><?php echo $image[2]; ?></td>
	     </tr>
	     <tr>
	      <td width="70">Tekst : </td>
	      <td><?php echo $image[3]; ?></td>
	     </tr>
	     <tr>
	      <td width="70">Poeng : </td>
	      <td><?php echo $image[5]; if ($image[5] > 0) { echo " ("; echo number_format(($image[5]/$image[4]), 1, ',', ''); echo ")";} ?>
	      </td>
	     </tr>
	     <tr>
	      <td width="70">Stemmer : </td>
	      <td><?php echo $image[4]; ?></td>
	     </tr>
	     <tr>
	      <td width="70">Visninger : </td>
	      <td><?php echo $image[6]; ?></td>
	     </tr>
	     <tr>
	      <td width="70">
	      <br>
	      <b>Valgt av : </b></td>
	      <td>
	      <br>
	      <b><?php echo $check[2]; ?></b>&nbsp;&nbsp;&nbsp; <?PHP echo @date("d.m.Y - H:i",$check[3]); ?></td>
	     </tr>
	    </table>	
</div>	

	
<?php } 
else { echo "<br>Ukens bilde ikke valgt";}


?> 
 

<br><br>






<hr />

<?php
$getuke=mysql_query("SELECT imgid, uke, aar, navn, timestamp FROM `gal_ukens` ORDER BY aar DESC, uke DESC LIMIT 15");
while ($uke=mysql_fetch_row($getuke)) {
  
  $getbilde =  mysql_query("SELECT id, thumb, fotograf, stemmer, poeng, timestamp, tekst, visning, kamera, kameramodel, lukkertid, blender, iso, focal FROM gal_images WHERE id = '$uke[0]'");
  $bilde = mysql_fetch_row($getbilde);
?>

<table cellpadding="0" cellspacing="0" border ="0">
    <tr >
     <td valign="top" width="120">
      <b>Uke <?php echo $uke[1]; echo "/"; echo $uke[2]; ?></b>
     </td>
     <td width="270" valign="top">
     <br />
   <?php
   if (@$bilde[4]>0) {
   $stars = round($bilde[4]/$bilde[3]);  }
   else { $stars=0; }
   ?>
      <div style="width: 250px; height: 18px; text-align: center; background-color: #333333;">
       <img src="../graphics/<?php echo $stars; ?>stars.gif">
      </div>
      <a href="http://jernbane.net/bo/subpage.php?s=0&id=<?php echo $bilde[0]; ?>"><img src="<?php echo $bilde[1]; ?>" width="248" class="adm_img" alt="<?php echo $bilde[0]; ?>" title="<?php echo $bilde[0]; ?>" /></a>
      <br /><br />
     </td>
     <td valign="top">
      <br />
          <table cellpadding="1" cellspacing="0" border="0" width="760">
               <tr>
                <td width="80" valign="top">
                   <b>Fotograf:</b>
                </td>
                <td valign="top">
                     <?php echo $bilde[2]; ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                   <b>Opplastet:</b>
                </td>
                <td valign="top">
                   <?PHP echo date("d.m.Y - H:i",$bilde[5]); ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Tekst:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $bilde[6]; ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Kamera:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php if ($bilde[8] != '') {
		         	echo $bilde[8]; echo ", "; echo $bilde[9]; echo '<br />';
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
                   <?php if ($bilde[8] != '') {
		         	echo $bilde[13]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $bilde[10]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
		         	echo $bilde[11]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $bilde[12];
		         	echo '<br />';
  		         	}
		        ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                   <br />
                </td>
                <td valign="top">
                   <br />
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Stemmer:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $bilde[3]; ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Poeng:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $bilde[4]; ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Score:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php if ($bilde[4] > 0) { echo number_format(($bilde[4]/$bilde[3]), 1, ',', '');} ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Visninger:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $bilde[7]; ?>
                </td>
               </tr>
               <tr>
                <td width="80" valign="top">
                  <b>Valgt av:</b>
                   <br />
                </td>
                <td valign="top">
                   <?php echo $uke[3]; echo " - "; echo @date("d.m.Y  H:i",$uke[4]);?>
                </td>
               </tr>
            </table>
        </td>
      </tr>
  </table>
  <hr />
 <?php
}
 ?>
<br /><br />



















</div>



