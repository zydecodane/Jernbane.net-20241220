<?php
if (isset($_POST['id'])) { $id = $_POST['id']; }
if (isset($_POST['imgid'])) { $imgid = $_POST['imgid']; }
if (isset($_POST['poeng'])) { $poeng = $_POST['poeng']; }


include('../configi.php');

$query = "delete from gal_comments where id='$id'";
$query2 = "update gal_images set poeng=(poeng-'$poeng') where id='$imgid'";
$query3 = "update gal_images set stemmer=(stemmer-1) where id='$imgid'";


$result = mysqli_query($db, $query);
$result2 = mysqli_query($db, $query2);
$result3 = mysqli_query($db, $query3);

$db->close();


header('Location: ../subpage.php?s=0&id='.$imgid.'phorum/index.php');
?>