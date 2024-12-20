<br /><br />
<?php
$cweek = date('W');
$getuge = mysql_query("SELECT max(id) FROM gal_ukens WHERE uke <= '$cweek' ");
$uge = mysql_result($getuge,0);

$getimgid = mysql_query("SELECT imgid FROM gal_ukens WHERE id = '$uge' ");
$imgid = mysql_result($getimgid,0);
	
$getimg = mysql_query("SELECT id, url, tekst, fotograf FROM gal_images WHERE id = '$imgid'");
$img=mysql_fetch_row($getimg);
?>
<center>

<div style="background-color: #800000; width: 1280px;">
<br />
<table width="1270" cellpadding="10" cellspacing="0" border="0">
<tr>
 <td width="250" valign="top" class="page0_menu" align="left">
 <img src="graphics/logo_big.gif" alt="" border="0" />
          <br />
 <br />
  <span style="font-size: 11px;"><?php echo date ('j.n.Y - H:i'); ?></span>
 <br />
 <br />
 <br />
  <a href="../phorum/" target="_parent" class="page0_menu"><img src="graphics/bull2.gif" alt="" align="top" border="0" /> &nbsp;&nbsp; <b>Postvogna</b></a>
 <br />
 <br />
  <a href="subpage.php?s=10" target="_parent" class="page0_menu"><img src="graphics/bull2.gif" alt="" align="top" border="0" /> &nbsp;&nbsp; <b>Postvognas kjøreregler</b></a>
 <br />
 <br />
  <a href="subpage.php?s=51" target="_parent" class="page0_menu"><img src="graphics/bull2.gif" alt="" align="top" border="0" /> &nbsp;&nbsp; <b>Bildeopplasting</b></a>
 <br />
 <br />
 <a href="../phorum/register.php" target="_parent" class="page0_menu"><img src="graphics/bull2.gif" alt="" align="top" border="0" /> &nbsp;&nbsp; <b>Registrer deg</b></a>
 <br />
 <br />
  <a href="../phorum/login.php" target="_parent" class="page0_menu"><img src="graphics/bull2.gif" alt="" align="top" border="0" /> &nbsp;&nbsp; <b>Logg inn</b></a>
 <br />
 <br />



 </td>
 <td style="background-color: #FFFFCC;" align="center">
     <img src="<?php echo $img[1]; ?>" border="0" width="800" alt="" />
 </td>
</tr>
</table>
<br />





</div>

<br />

</center>