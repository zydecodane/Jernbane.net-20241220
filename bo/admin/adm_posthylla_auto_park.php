<?php
include('configi.php');

$id = $_POST['id'];
$logid = $_POST['logid'];

$query = "update gal_images set posthylla = 2 where id = '$id'";
$result = mysqli_query($db, $query);

header("Location: index.php?s=11&logid=".$logid);
?>