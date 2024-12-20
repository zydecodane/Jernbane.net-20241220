<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="../stylesheet.css" rel="stylesheet" >
<title></title>
</head>
<body style="margin: 20px; min-width: 800px !important; ">

<?php
if(isset($_GET['l'])) { $l = $_GET['l']; } else { $l = 0; }
if(isset($_GET['c'])) { $c = $_GET['c']; } else { $c = 0; }
if(isset($_GET['t'])) { $t = $_GET['t']; } else { $t = 0; }
if(isset($_GET['u'])) { $u = $_GET['u']; } else { $u = 0; }

include('configi.php');

// get the type
$query = "SELECT * FROM gal_type WHERE typeid = '$t'";
$result = $db->query($query);
$type = $result->fetch_array();

$query = "SELECT * FROM `gal_unit` WHERE numid = '$u'";
$result = $db->query($query);
$unit = $result->fetch_array();

echo "<b>";echo $type[1]; echo " "; echo $unit[1];
$info=str_replace("<br />","",$unit[4]);
//$info = $unit[4];

?>
<form action="adm_unit_info_update.php" name="unitinfo" method="post" >
  <textarea name="unitinfo" style="width: 740px; height: 280px;"><?php echo $info; ?></textarea>
<input type="hidden" name="l" value="<?php echo $l; ?>">
<input type="hidden" name="c" value="<?php echo $c; ?>">
<input type="hidden" name="t" value="<?php echo $t; ?>">
<input type="hidden" name="u" value="<?php echo $u; ?>">
<br /><br />
<input type="submit" value="    oppdatere endringer   ">

</form>


