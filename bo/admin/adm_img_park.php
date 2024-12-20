<?php
if(!isset($_POST['id'])){ $id = $_GET['id'];} 
if(isset($_POST['page'])) { $page = $_POST['page']; } 
	
include ('configi.php');

$query = "select type from gal_images where id = '$id'";
$type = $db->query($query)->fetch_object()->type;

$query1 = "update gal_images set posthylla = 2, type = 0, nummer = 0 where id='$id'"; 
$result = mysqli_query($db, $query1);

$db->close();

echo '<script>parent.location.href="../subpage.php?s=3&t='.$type.'"</script>"';
?>