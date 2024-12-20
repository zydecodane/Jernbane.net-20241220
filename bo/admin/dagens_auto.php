<?php
include('configi.php');

// opdater vaegtet poeng

$query1 = "UPDATE gal_comments SET vaegtet_poeng = poeng where vaegtet_poeng = 0";
$result1 = mysqli_query($db, $query1);
$query2 = "UPDATE gal_comments SET vaegtet_poeng = (poeng+0.5) where poeng < 4";
$result2 = mysqli_query($db, $query2);

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

// find dagens bilde

$til = mktime(19, 0, 0);
$fra = $til-86400;
$til=$til-1;

$query3 = "select id, url from gal_images where timestamp between '$fra' and '$til'";
$result3 = $db->query($query3);

$n=0;
while ( $liste = $result3->fetch_array() ) {	
	
	$query4 = "select sum(vaegtet_poeng) as sum from gal_comments where url = '$liste[1]' group by url order by 1 desc";
	if (isset($db->query($query4)->fetch_object()->sum)) {
	$poeng[$n] = $db->query($query4)->fetch_object()->sum; } else {
		$poeng[$n] = 0;
	}
	if ($poeng[$n] > 0) {
							$id[$n] = $liste[0];
						}
	$n++;

if ($n>0) {	
$max= array_search(max($poeng), $poeng); 
}
// skriv til gal_dagens

}
if (@$id[$max] > 0) {
	$datetime = date('U');
	$query5 = "insert into gal_dagens (imgid, datetime) values('$id[$max]','$datetime')"; 
	$result5 = mysqli_query($db, $query5);
}

// opdater top100-tabellen

$query9 = "select a.id, sum(b.vaegtet_poeng) as poengsum from gal_images a, gal_comments b
	where a.url = b.url and timestamp > 1441065600
	group by b.url order by 2 desc limit 100";

	$result9 = $db->query($query9);


	$query8 = "truncate gal_top100"; // tabellen bliver tømt
	$result8=$db->query($query8);
	
	while ( $liste9 = $result9->fetch_array() ) {
	    
		$query10 = "insert into gal_top100 (imgid, poengsum) values ('$liste9[0]','$liste9[1]')";
		$result10=$db->query($query10);
	
	}
?>
