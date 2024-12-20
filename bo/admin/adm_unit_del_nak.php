<?php

if(isset($_GET['l'])) { $l = $_GET['l']; } else { $l = 0; }
if(isset($_GET['c'])) { $c = $_GET['c']; } else { $c = 0; }
if(isset($_GET['t'])) { $t = $_GET['t']; } else { $t = 0; }
if(isset($_GET['u'])) { $u = $_GET['u']; } else { $u = 0; }


include('configi.php');

$query = "delete from gal_unit where numid = '$u'";
$result = mysqli_query($db, $query);

echo '<script>parent.location.href="index.php?s=3&p=4&l='.$l.'&c='.$c.'&t='.$t.'"</script>';

?>