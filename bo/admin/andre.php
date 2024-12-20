<?php
include ('configi.php');

$query1 = "select numid from gal_unit where enhet = 'andre'";
$result = $db->query($query1);

$n=0;

while ( $unitlist = $result->fetch_array() ) {
    $andre_unit[$n] = $unitlist[0];
    $n++;
     } 

$l=0;

for ($m = 0 ; $m<$n ; $m++) {
	$query2 = "select id from gal_images where nummer = '$andre_unit[$m]' and posthylla = 1";
	@$id = $db->query($query2)->fetch_object()->id;
	
	if ($id > 0) {
		echo $id; echo "<br />";
		
		$l++;
		}
}

echo $l;

?>