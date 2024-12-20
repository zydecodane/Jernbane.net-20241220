<?php
include('configi.php');

if (isset($_POST['image'])) {$image=$_POST['image'];} else { $image='';}
if (isset($_POST['poeng'])) {$poeng=$_POST['poeng'];} else { $poeng=0;}
if (isset($_POST['comid'])) {$comid=$_POST['comid'];} else { $comid=0;}


$query = "UPDATE gal_images SET poeng=(poeng-'$poeng') WHERE id='$image'";
$result = mysqli_query($db, $query);

$query = "UPDATE gal_images SET stemmer=stemmer-1 WHERE id='$image'";
$result = mysqli_query($db, $query);

$query = "DELETE FROM gal_comments WHERE id='$comid'";
$result = mysqli_query($db, $query);


echo "<script>parent.location.href='subpage.php?s=0&id="; echo $image; echo"'</script>";


?>
