<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="../stylesheet.css" rel="stylesheet" >
<title></title>
</head>
<body style="margin: 100px;">
  
<?php
  
if(isset($_GET['p'])) { $u = $_GET['p']; } else { $p = 0; }
if(isset($_GET['l'])) { $l = $_GET['l']; } else { $l = 0; }
if(isset($_GET['c'])) { $c = $_GET['c']; } else { $c = 0; }
if(isset($_GET['t'])) { $t = $_GET['t']; } else { $t = 0; }
if(isset($_GET['u'])) { $u = $_GET['u']; } else { $u = 0; }
if(isset($_GET['d'])) { $d = $_GET['d']; } else { $d = 0; }
  
include('configi.php');


$query1 = "select typename from gal_type where typeid = '$t'";
$type = $db->query($query1)->fetch_object()->typename;

$query2 = "select enhet from gal_unit where numid = '$u'";
$unit = $db->query($query2)->fetch_object()->enhet;

$query3 = "select navn from gal_unitdetail where detailid = '$d'";
$unitdetail = $db->query($query3)->fetch_object()->navn;

$query4 = "select * from gal_images where type = '$t' and nummer = '$u' and detailid = '$d'";
$result4 = $db->query($query4);
  
echo '<pre>'; print_r($result4); echo '</pre>';
  
$n=0;
while ( $liste = $result4->fetch_array() ) {
    $n++;
     } 

if ($n>0) { ?>
<script type="text/javascript">
	alert("<?php echo $type; ?>\n<?php echo $unit; ?>\n<?php echo $unitdetail; ?>\n\nDu kan ikke slette denne detalj\nDer er <?php echo $n; ?> bilder i databasen");
</script>
<?php
	echo '<script>parent.location.href="index.php?s=3&p=5&l='.$l.'&c='.$c.'&t='.$t.'&u='.$u.'"</script>';
 } 
else { ?>

<script type="text/javascript">	
 var l = <?php echo $l; ?>;
 var c = <?php echo $c; ?>;
 var t = <?php echo $t; ?>;
 var u = <?php echo $u; ?>;
 var d = <?php echo $d; ?>;

 var r = confirm("<?php echo $type; ?>\n<?php echo $unit; ?>\n<?php echo $unitdetail; ?>\n\nIngen bilder i databasen. Vil du slette ?");
if (r == true) {
    parent.location.href="adm_unitdetail_del_nak.php?s=3&p=5&l="+l+"&c="+c+"&t="+t+"&u="+u+"&d="+d;
} else {
    parent.location.href="index.php?s=3&p=5&l="+l+"&c="+c+"&t="+t+"&u="+u;
}	

</script>
<?php
}
?>

</body>
</html>
<?php

//echo '<script>parent.location.href="index.php?s=3&p=5&l='.$l.'&c='.$c.'&t='.$t.'&u='.$u."</script>';
?>