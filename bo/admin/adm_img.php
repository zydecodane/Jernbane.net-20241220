<?php
// fancybox-script start
error_reporting(-1);
ini_set('display_errors', 'On');
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
				});
</script>
<?php
// fancybox-script slut

if(isset($_GET['id'])){$id = $_GET['id'];}
?>

<div style="width: 1000px; text-align: left;">
<span style="font-size: 14px; font-weight: bold;">Posthylla &nbsp;&nbsp;</span> 

<br /><br />
</div>
<?php
include('configi.php');
$query = "SELECT id, url, thumb, tekst, fotograf, dato, type, nummer, timestamp FROM `gal_images` WHERE id = '$id'";
$result = $db->query($query);
while ( $img = $result->fetch_array() ) {
    
    
    
    
    
    
 } // img-løkke slut

?>



<div style="padding:10px;border:1px solid black;width:980px; background-color: #FFFFFF; text-align: left;"> 


<table width="980" cellpadding="0" cellspacing="0" style="color: #000000;">


<tr >
 <td style="width: 420px; border-bottom: 1px solid #800000;">
 <br />
  <a class="grouped_elements" rel="" href="<?php echo $img[1]; ?>"><img src="<?php echo $img[2]; ?>" class="adm_img" alt="<?php echo $img[0]; ?>" title="<?php echo $img[0]; ?>" /></a>
  <br /><br />
 </td>
 <td style="border-bottom: 1px solid #800000; vertical-align: top; ">
  <br />
      <table cellpadding="1" cellspacing="0" border="0" width="478">
       <tr>
        <td width="80" valign="top">
           <b>Fotograf:</b>
        </td>
        <td valign="top">
             <?php echo $img[4]; ?>
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <b>Opplastet:</b>
        </td>
        <td valign="top">
           <?PHP echo date("d.m.Y - H:i",$img[8]); ?>
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
<?php
  $getunit=mysql_query("SELECT numid, enhet FROM `gal_unit` WHERE numid = '$img[7]'");
  $unit=mysql_fetch_row($getunit);

  $gettype=mysql_query("SELECT typeid, typename, katid FROM `gal_type` WHERE typeid = '$img[6]'");
  $type=mysql_fetch_row($gettype);
  
  $getkat=mysql_query("SELECT katid, katname, natid FROM `gal_kategori` WHERE katid = '$type[2]'");
  $kat=mysql_fetch_row($getkat);

  $getland=mysql_query("SELECT natid, natnavn FROM `gal_nations` WHERE natid = '$kat[2]'");
  $land=mysql_fetch_row($getland);

  $check=0;
?>
       <tr>
        <td width="80" valign="top">
           <b>Land :</b>
        </td>
        <td valign="top">
           <?php echo $land[1]; if ($land[1]!='') { $check=$check+1; } ?>
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <b>Kategori :</b>
        </td>
        <td valign="top">
           <?php echo $kat[1]; if ($kat[1]!='') { $check=$check+1; } ?>
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <b>Type :</b>
        </td>
        <td valign="top">
           <?php echo $type[1]; if ($type[1]!='') { $check=$check+1; } ?>
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <b>Nummer :</b>
        </td>
        <td valign="top">
           <?php $needle='andre';
				if (strlen(strstr($unit[1],$needle))>0) {
				?><font color=red><b><?php echo $unit[1]; ?></font></b><?php if ($unit[1]!='') { $check=$check+1; }} 
				
				else
				{echo $unit[1]; if ($unit[1]!='') { $check=$check+1; }}?>
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
           <b>Tekst :</b>
        </td>
        <td valign="top">
            <?php echo $img[3]; if ($img[5]!='') { echo ", "; echo date("d.m.Y",$img[5]); } ?>
        </td>
       </tr>
      </table>
 <br />
 </td>
 <td style="width: 220px; border-bottom: 1px solid #800000; vertical-align: top;">
 <br />
    <table cellpadding="3" cellspacing="0" border="0">
     <tr>
       <td>
        <?php if ($check==4) { ?>
        <form name="ok" method="post" action="adm_ph_gal_set.php">
         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
         <input type="hidden" name="page" value="<?php echo $page; ?>" />
         <input type="submit" value="til galleriet som det er <?php if (strlen(strstr($unit[1],$needle))>0) {echo " ???";} ?>" style="width: 220px; text-align: left;" />
        </form>
        <?php
             } else { echo "<font color=red>kategorisering ikke fullført</font><br />"; }
        ?>
       </td>
     </tr>
     <tr>
       <td>
        <form name="forum" method="post" action="adm_ph_forum_set.php">
         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
         <input type="hidden" name="page" value="<?php echo $page; ?>" />
         <input type="submit" value="parker bildet - vises i forum" style="width: 220px; text-align: left;" />
        </form> 
       </td>
     </tr>
     <tr>
       <td>
        <form name="cat" method="post" action="index.php?s=6">
         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
         <input type="hidden" name="page" value="<?php echo $page; ?>" />
         <input type="submit" value="kategorisering ..." style="width: 220px; text-align: left;" />
        </form> 
       </td>
     </tr>
     <tr>
       <td>
        <form name="copy" method="post" action="index.php?s=7">
         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
         <input type="hidden" name="page" value="<?php echo $page; ?>" />
         <input type="submit" value="kopiere til ytterligere plassering ..." style="width: 220px; text-align: left;" />
        </form> 
       </td>
     </tr>
     <tr>
       <td>
        <form name="del" method="post" action="adm_ph_slet.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
         <input type="hidden" name="page" value="<?php echo $page; ?>" />
         <input type="submit" value="slet bildet" style="width: 220px; text-align: left;" />
        </form> 
       </td>
     </tr>
    </table>
 </td>
</tr>

</table>
</div>
<br />



