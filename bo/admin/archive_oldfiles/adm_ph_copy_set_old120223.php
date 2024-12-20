<?php
include ('configi.php');

if(isset($_POST['id'])) { $id = $_POST['id']; } 
if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
if(isset($_POST['eg'])) { $eg = $_POST['eg']; } else { $eg = 0; }
if(isset($_POST['fi'])) { $fi = $_POST['fi']; } 
if(!isset($_POST['ae'])){$ae = -1;} else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}
if(isset($_POST['logid'])) { $logid = $_POST['logid']; }

 // set active element parameter string
 $ae_parstr = "";
 if($ae>0) {
    $ae_parstr = "&ae=".$ae;
 }

if(isset($_POST['drop_3'])) { $type = $_POST['drop_3']; } else { $type = 0; }
if(isset($_POST['drop_4'])) { $unit = $_POST['drop_4']; } else { $unit = 0; }

$query = "select * from gal_images where id = '$id'";
$result = $db->query($query);
$img = $result->fetch_array();

$img[4] = addslashes($img[4]); // renser tekst for uvenlige karakterer

//$datetime=date('U');

$timenow = date('U');
$query = "INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, modify_time, clean_url, clean_thumb) VALUES ('$img[1]','$img[2]','$img[3]','$img[4]','$img[5]','$img[6]','$img[7]','$img[8]','$type','$unit','$img[13]','$img[14]','$img[15]','$img[16]','$img[17]','$img[18]','1','$img[21]','$img[22]','0', '$timenow','$img[25]','$img[26]')";
$result = mysqli_query($db, $query);

if(isset($fi) && strlen($fi)>0)
{
	echo "<script>parent.location.href='../../phorum/read.php?".$fi."'</script>";
}
if ($page=='show')
{
        echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit."'</script>";
}
elseif ($page=='autolog')
{
        echo "<script>parent.location.href='index.php?s=11&logid=".$logid."'</script>";
}
else
{
	echo "<script>parent.location.href='index.php?s=1&p=".$page."&eg=".$eg.$ae_parstr."'</script>";
}




?>