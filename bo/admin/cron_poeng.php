<?php
date_default_timezone_set('Europe/Oslo');

if (date('G') > 6) {
	if (date('G') < 22) {
	
include('configi.php');

// opdater vaegtet poeng

$query8 = "UPDATE gal_comments SET vaegtet_poeng = poeng where vaegtet_poeng = 0";
$result8 = mysqli_query($db, $query8);
$query9 = "UPDATE gal_comments SET vaegtet_poeng = (poeng+0.5) where poeng < 4";
$result9 = mysqli_query($db, $query9);

$timestamp=date('U');

$query11 = "select data from log_poeng where value='poeng'";
@$result11 = $db->query($query11)->fetch_object()->data;

if (!isset($result11)) {
	$query12 = "insert into log_poeng (value, data) values ('poeng','$timestamp')";
	$result12 = mysqli_query($db, $query12);
} else {
	$query12 = "update log_poeng set data='$timestamp' where value='poeng'";
	$result12 = mysqli_query($db, $query12);
}
}}

?>