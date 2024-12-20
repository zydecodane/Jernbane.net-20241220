<?php
include('configi.php');

if(isset($_POST['id'])) { $id = $_POST['id']; } else { $id = 0; }
if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
if(isset($_POST['u'])) { $unit = $_POST['u']; }
if(isset($_POST['eg'])) { $eg = $_POST['eg']; } else { $eg = 0; }
if(isset($_POST['fi'])) { $fi = $_POST['fi']; } 

if(!isset($_POST['ae'])){$ae = -1;}
else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}
if(isset($_POST['padmin'])){$padmin = $_POST['padmin'];} else { $padmin = 0;}


// set active element parameter string
$ae_parstr = "";
if($ae>0) {
    $ae_parstr = "&ae=".$ae;
}

$query = "select url, navn, nummer, type from gal_images where id = '$id'";
$result = $db->query($query);
$img = $result->fetch_array();
if($img) {
   $unit = $img[2];
   $type = $img[3];
} else { 
   $unit = 0;
   $type = 0;    
}

$query = "delete from gal_images where id = '$id'";
$result = mysqli_query($db, $query);

$start = strpos($img[0],'/upload');
$slut = strpos($img[0],'/',$start+1);
$length = $slut-$start;
$folder = substr($img[0],$start+1,$length-1);

$fil = '../../'.$folder.'/'.$img[1];
$filthumb = '../../'.$folder.'/thumbs/'.$img[1];


 
	@unlink($fil);
	@unlink($filthumb);


if(isset($fi) && strlen($fi)>0)
{
	echo "<script>parent.location.href='../../phorum/read.php?".$fi."'</script>";
}

if ($page == "gal") 
{
	echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit."'</script>";
}

if ($page=="show")
{
    if($unit!=0) {
        echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit."'</script>";
    } else if ($type!=0) {
        echo "<script>parent.location.href='../subpage.php?s=3&t=".$type."'</script>";
    } else {
        echo "<script>parent.location.href='../index.php".$unit."'</script>";
    }
}

else
{

	echo "<script>parent.location.href='index.php?s=1&p=".$page."&eg=".$eg.$ae_parstr."'</script>";

}
?>