<?php
date_default_timezone_set('Europe/Oslo');

include('configi.php');
$week = date('W');
$year = date('o'); // det år som hører til ugen foroven

$query = "select id, uke, aar from gal_ukens where uke='$week' and aar = '$year'";
@$result = $db->query($query)->fetch_object()->id;

if ($result > 0) {
	// do nothing
	echo "vi er i uge ".$week."/".$year."<br />";
}
else
{
echo "vi er i uge ".$week."/".$year."<br />";	

$start = strtotime('last Monday');
$slut = $start+604799;

echo "upload-start er ".date('d.m.Y H:i:s',$start)."<br />";
echo "upload-slut ".date('d.m.Y H:i:s',$slut)."<br />";


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

	$query2 = "select id, url, thumb, sum(stemmer) as stemmer, sum(poeng) as poeng, visning, fotograf, (poeng/stemmer)+(stemmer*0.5) as score from gal_images where url in ($soekarray) group by url order by score desc, poeng desc limit 1";
	$result2 = $db->query($query2);
while ( $img2 = $result2->fetch_array() ) {

$id[$n] = $img2[0];
$url[$n] = $img2[1];
$thumb[$n] = $img2[2];
$fotograf[$n] = $img2[6];
$stemmer[$n] = $img2[3];
$poeng[$n] = $img2[4];
$score[$n] = $img2[7];

if (isset($img[5])) { $views[$n] = $img[5];	}

}

echo "and the winner is: <br />";
echo '<img src="'.$thumb[0].'" /><br />';
	
	
// now we write the result to the database

$timestamp = date('U');

$query3 = "insert into gal_ukens (imgid, uke, aar, navn, timestamp) values('$id[0]','$week','$year','auto','$timestamp')";
$result3 = mysqli_query($db, $query3);
	
	
	
}
?>