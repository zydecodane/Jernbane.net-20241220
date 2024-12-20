<?php
include ('configi.php');

if(isset($_POST['l'])) { $l = $_POST['l']; } else { $l = 0; }
if(isset($_POST['c'])) { $c = $_POST['c']; } else { $c = 0; }
if(isset($_POST['t'])) { $t = $_POST['t']; } else { $t = 0; }
if(isset($_POST['u'])) { $u = $_POST['u']; } else { $u = 0; }


if(isset($_POST['unitinfo'])) { $unitinfo = $_POST['unitinfo']; } else { $unitinfo=""; }

$unitinfo=nl2br($unitinfo);
$unitinfo=$db->real_escape_string($unitinfo);

$query = "update gal_unit set info = '$unitinfo' where numid = '$u'"; 
$result = mysqli_query($db, $query);

// update modify_time
$timenow = date('U');
$query = "update gal_unit set modify_time = $timenow where numid = '$u'"; 
$result = mysqli_query($db, $query);

?>

<?php
echo "<script>window.opener.location.href='index.php?s=3&p=4&l=".$l."&c=".$c."&t=".$t."#".$u."'</script>";
?>
<script type="text/javascript">window.close();</script>