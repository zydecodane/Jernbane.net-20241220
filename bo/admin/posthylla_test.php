<?php
include('../configi.php');

$unixdate = date('U');


$previous = date('W',$unixdate);
$current = date('W',$unixdate+604800);

$uke=date('W',$unixdate+604800);
$year = date('o',$unixdate+604800);

$uploaduke = date('W',$unixdate);
$uploadyear = date('o',$unixdate);

$datostreng = $uploadyear.'W'.($uploaduke);
$weekstart = strtotime($datostreng);

echo "<h2>Posthylla - oplastet seneste uge og sorteret efter stemmer</h2> <br />";

$query = "select id, url, thumb, stemmer, poeng, visning, fotograf from gal_images where timestamp > '$weekstart' order by poeng desc, visning desc";
$result = $db->query($query);
while ( $img = $result->fetch_array() ) {
	
	echo '<a href="../subpage.php?s=0&id='.$img[0].'">';
	echo '<img src="';
	echo $img[2];
	echo '" /></a> ';
	echo $img[6];
	echo ' - ';
	echo $img[4];
	echo '<br />';
    echo '<hr />';
}

?>