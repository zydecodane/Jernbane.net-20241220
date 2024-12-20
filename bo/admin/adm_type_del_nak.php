<?php
if(isset($_GET['l'])) { $l = $_GET['l']; } else { $l = 0; }
if(isset($_GET['c'])) { $c = $_GET['c']; } else { $c = 0; }
if(isset($_GET['t'])) { $t = $_GET['t']; } else { $t = 0; }

include('configi.php');

$query1 = "delete from gal_unit where typeid='$t'";
$result1 = mysqli_query($db, $query1);

$query2 = "delete from gal_type where typeid='$t'";
$result2 = mysqli_query($db, $query2);


// echo '<script>parent.location.href="index.php?s=3&p=3&l='.$l.'&c='.$c.'&t='.$t.'"</script>';
echo '<script>parent.location.href="index.php?s=3&p=3&l='.$l.'&c='.$c.'"</script>';

?>