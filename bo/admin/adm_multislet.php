<?php
$antal = $_POST['antal'];
$n=0;
foreach($_POST['image'] as $item){
  $img[$n] = $item;
  $n++;
}

include('configi.php');

for ($m = 0 ; $m<$n ; $m++) {
	
	$query2 = "select url, navn from gal_images where id = '$img[$m]'";
	$url = $db->query($query2)->fetch_object()->url;
	$navn = $db->query($query2)->fetch_object()->navn;
	
	$query = "delete from gal_images where id = '$img[$m]'";
	$result = mysqli_query($db, $query);
}
if ($antal == $n) {
	// unlink
	
	$start = strpos($url,'/upload');
	$slut = strpos($url,'/',$start+1);
	$length = $slut-$start;
	$folder = substr($url,$start+1,$length-1);

	$fil = '../../'.$folder.'/'.$navn;
	$thumb = '../../'.$folder.'/thumbs/'.$navn;
	
	@unlink($fil);
	@unlink($thumb);
}

header('Location: ../../index.php');
?>