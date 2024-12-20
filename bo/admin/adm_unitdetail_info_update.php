<?php
include ('configi.php');

if(isset($_POST['l'])) { $l = $_POST['l']; } else { $l = 0; }
if(isset($_POST['c'])) { $c = $_POST['c']; } else { $c = 0; }
if(isset($_POST['t'])) { $t = $_POST['t']; } else { $t = 0; }
if(isset($_POST['u'])) { $u = $_POST['u']; } else { $u = 0; }
if(isset($_POST['d'])) { $d = $_POST['d']; } else { $d = 0; }

if(isset($_POST['unitdetailinfo'])) { $unitdetailinfo = $_POST['unitdetailinfo']; } else { $unitdetailinfo=""; }

$unitdetailinfo=nl2br($unitdetailinfo);
$unitdetailinfo=$db->real_escape_string($unitdetailinfo);

$query = "update gal_unitdetail set info = '$unitdetailinfo' where detailid = '$d'"; 
$result = mysqli_query($db, $query);

// update modify_time
$timenow = date('U');
$query = "update gal_unitdetail set modify_time = $timenow where detailid = '$d'"; 
$result = mysqli_query($db, $query);

?>

<?php
echo "<script>window.opener.location.href='index.php?s=3&p=5&l=".$l."&c=".$c."&t=".$t."&u=".$u."#".$d."'</script>";
?>
<script type="text/javascript">window.close();</script>