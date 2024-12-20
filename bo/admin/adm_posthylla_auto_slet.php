<?php
include('configi.php');

$id = $_POST['id'];
$logid = $_POST['logid'];

$query = "select clean_url, clean_thumb from gal_images where id = '$id'";
$url = $db->query($query)->fetch_object()->clean_url;
$thumb = $db->query($query)->fetch_object()->clean_thumb;

$url = "../../".substr($url, 1);
$thumb = "../../".substr($thumb, 1);

echo $url; echo "<br />";
echo $thumb;

unlink($url);
unlink($thumb);

$query2 = "delete from gal_images where id = '$id'";
$result2 = mysqli_query($db, $query2);

$db->close();
header("Location: index.php?s=11&logid=".$logid);
?>