<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include ('configi.php');

$typeid = '891';

$query = "select numid, enhet, plass from gal_unit where typeid = '$typeid' order by plass";
$result = $db->query($query);
while ( $unit = $result->fetch_array() ) {
	
	$nyplass = intval(substr($unit[1],4,3));
	 
	if (substr($unit[1],0, 3) == '650') { 
		$query1 = "update gal_unit set plass = '$nyplass' where numid = '$unit[0]'";
		$result1 = mysqli_query($db, $query1);
	
		// echo $unit[0]." - ".$unit[2]." - ".$unit[1]." -> ".$unit[2]." ==> ny plass: ".$nyplass."<br />" ;
		}

	} 










?>