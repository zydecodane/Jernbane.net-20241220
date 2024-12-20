<?php
// dette program finder alle billeder hvor feltet 'navn' er tom og skriver det rette navn i feltet.

include ('../configi.php');


$query = "select id, url FROM gal_images where navn is null";
$result = $db->query($query);


$m=0;

while ( $liste = $result->fetch_array() ) {
	
	$n = strripos($liste[1],'/',0);
	$navn = substr($liste[1],$n+1);
	
    // echo $liste[0]; echo " - "; echo $navn; echo "<br />";
	
	$query1 = "update gal_images set navn = '$navn' where id = '$liste[0]'";
	$result1 = mysqli_query($db, $query1);
	$m++;
     } 

echo $m; echo " rækker opdateret.";




?>