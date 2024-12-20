<?php
date_default_timezone_set('Europe/Oslo');

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

$week = date('W');
$year = date('o'); // the year according to weeknumber above

$query = "select id, uke, aar from gal_ukens where uke='$week' and aar = '$year'";
@$result = $db->query($query)->fetch_object()->id;

if ($result > 0) {
	// do nothing
}
else
{
$start = strtotime('last Monday');
$slut = $start+604799;

// now we have the interval and are ready to pull out the images

$a=0; $n=0;
$soekarray = "";

$query = "select id, url from gal_images where poeng>0 and timestamp between '$start' and '$slut'";	

$result = $db->query($query);
while ( $img = $result->fetch_array() ) {	
	$surl[$a] = $img[1];
	$a++;
}	

for ($b = 0 ; $b<$a ; $b++) {
	$soekarray .= "'".$surl[$b]."'";
	if ($b < $a-1) {$soekarray .= ",";}
	
}

$query2 = "select sum(vaegtet_poeng) as sum, url from gal_comments where url in ($soekarray) group by url order by 1 desc limit 1";
$result2 = $db->query($query2);
while ( $img2 = $result2->fetch_array() ) {
	
	$query3 = "select id, url, thumb, sum(stemmer) as stemmer, sum(poeng) as poeng, visning, fotograf from gal_images where url = '$img2[1]'";	
	$id = $db->query($query3)->fetch_object()->id;
				}
			}
// now we write the result to the database

$timestamp = date('U');

 $query3 = "insert into gal_ukens (imgid, uke, aar, navn, timestamp) values('$id','$week','$year','auto','$timestamp')";
 $result3 = mysqli_query($db, $query3);	

?>