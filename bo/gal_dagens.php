<?php
include ('configi.php');
$dagens[9] = 0;

$nu = date('U');
$u24 = $nu-86400;


$query = "select imgid, datetime from gal_dagens order by 1 desc limit 1";
$dagimg = $db->query($query)->fetch_object()->imgid;
$dagnitten = $db->query($query)->fetch_object()->datetime;

// hvis der er et bilde i tabelle som har dato indenfor seneste 24 timer
if ($dagnitten > $u24) {

$query2 = "select id, thumb, url, tekst, stemmer, poeng, fotograf, clean_url, timestamp, navn from gal_images where id = '$dagimg'";
$result2 = $db->query($query2);
while ( $dayliste = $result2->fetch_array() ) {	
		// check if yesterday	
		// hvis bildet har fået stjerner
			if ($dayliste[4] > 0)
				{
				$dagens[0] = $dayliste[0]; // id
				$dagens[1] = $dayliste[1]; // url
				$dagens[2] = $dayliste[2]; // thumb
				$dagens[3] = $dayliste[3]; // tekst
				$dagens[4] = $dayliste[4]; // stemmer
				$dagens[5] = $dayliste[5]; // poeng
				$dagens[6] = $dayliste[6]; // fotograf  
				$dagens[7] = $dayliste[7]; // clean_url
				$dagens[8] = $dayliste[9]; // navn
				$dagens[9] = 1;
				}
        }
}	 
?>