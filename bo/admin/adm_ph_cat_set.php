<?php
include('configi.php');

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

if(isset($_POST['drop_3'])) { $type = $_POST['drop_3']; } else { $type = 0; }
if(isset($_POST['drop_4'])) { $unit = $_POST['drop_4']; } else { $unit = 0; }
if(isset($_POST['drop_5'])) { $unitdetail = $_POST['drop_5']; } else {$unitdetail = 0; }

if(isset($_POST['id'])) { $id = $_POST['id']; } else { $id = 0; }

if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
if(isset($_GET['page'])) { $page = $_GET['page']; }

if(isset($_POST['eg'])) { $eg = $_POST['eg']; }

if(isset($_POST['fi'])) { $fi = $_POST['fi']; }

if(!isset($_POST['ae'])){$ae = -1;}
else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}

if(isset($_POST['logid'])) { $logid = $_POST['logid']; }

// set active element parameter string
$ae_parstr = "";
if($ae>0) { $ae_parstr = "&ae=".$ae; }


$query = "UPDATE gal_images SET type = '$type' WHERE id = '$id'";
$result = mysqli_query($db, $query);

$query1 = "UPDATE gal_images SET nummer = '$unit' WHERE id = '$id'";
$result1 = mysqli_query($db, $query1);

$query1a = "UPDATE gal_images SET detailid = IF('$unitdetail' = 0, NULL, '$unitdetail') WHERE id = '$id'";
$result1a = mysqli_query($db, $query1a);

$query2 = "UPDATE gal_images SET posthylla = '1' WHERE id = '$id'";
$result2 = mysqli_query($db, $query2);

// update modify_time
$timenow = date('U');
$query = "update gal_images set modify_time = $timenow where id = '$id'"; 
$result = mysqli_query($db, $query);

if(isset($fi) && strlen($fi)>0)
{
	echo "<script>parent.location.href='../../phorum/read.php?".$fi."'</script>";
}
if ($page=="show") 
{
echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit.$ae_parstr."'</script>";
}
elseif($page=="autolog") {
echo "<script>parent.location.href='index.php?s=11&logid=".$logid."'</script>";
}
else 
{
echo "<script>parent.location.href='index.php?s=1&p=".$page."&eg=".$eg.$ae_parstr."'</script>";
}


?>