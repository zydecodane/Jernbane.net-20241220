<?php
ini_set('max_execution_time', 600); 

include('../configi.php');

$query = "SELECT id, url, thumb FROM gal_images where clean_url = ''";
$result = $db->query($query);

$n=0;
while ( $row = $result->fetch_object() ) {
    
        $id[$n] = $row->id;
        $url[$n] = $row->url;
        $thumb[$n] = $row->thumb;
    $n++;
}

for ($l = 0 ; $l<$n ; $l++) {
    
    if (substr($url[$l],0,4) == 'http') {
        $nyurl[$l] = substr($url[$l],strpos($url[$l],'jernbane.net')+12);
        $nythumb[$l] = substr($thumb[$l],strpos($thumb[$l],'jernbane.net')+12); 
        
        $query1 = "update gal_images set clean_url = '$nyurl[$l]', clean_thumb = '$nythumb[$l]' where id = '$id[$l]'";
        $result1 = mysqli_query($db, $query1);
        }
}

$db->close();
?>