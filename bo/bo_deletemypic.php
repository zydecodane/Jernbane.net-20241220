<?php
if (isset($_POST['id'])) { $id = $_POST['id']; }
if (isset($_POST['navn'])) { $navn = $_POST['navn']; }

include ('configi.php');

$query = "select var from gal_variables where id = 1";
$folder = $db->query($query)->fetch_object()->var;


$query = "delete from gal_images where id = '$id'";
$result = mysqli_query($db, $query);

$fil = '../'.$folder.'/'.$navn;
$filthumb = '../'.$folder.'/thumbs/'.$navn;


@unlink($fil);
@unlink($filthumb);


echo "<script>parent.location.href='subpage.php?s=60'</script>";

?>