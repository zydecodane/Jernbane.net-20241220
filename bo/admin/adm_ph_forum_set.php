<?php
include('configi.php');

if(isset($_POST['id'])) { $id = $_POST['id']; } else { $id = 0; }
if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
if(isset($_POST['eg'])) { $eg = $_POST['eg']; } else { $eg = 0; }
if(!isset($_POST['ae'])){$ae = -1;}
else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}

// set active element parameter string
$ae_parstr = "";
if($ae>0) { $ae_parstr = "&ae=".$ae; }

$query = "update gal_images set posthylla = 2 where id = '$id'";
$result = mysqli_query($db, $query);

$query1 = "update gal_images set type = 0 where id = '$id'";
$result1 = mysqli_query($db, $query1);

$query2 = "update gal_images set nummer = 0 where id = '$id'";
$result2 = mysqli_query($db, $query2);

// update modify_time
$timenow = date('U');
$query = "update gal_images set modify_time = $timenow where id = '$id'"; 
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='index.php?s=1&p=".$page."&eg=".$eg.$ae_parstr."'</script>";
?>