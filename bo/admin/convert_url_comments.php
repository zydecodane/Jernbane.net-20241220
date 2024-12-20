<?php
ini_set('max_execution_time', 6000); 

include('../configi.php');


$query = "SELECT id, url FROM gal_comments WHERE clean_url = '' ";
$result = $db->query($query);


$n=0;
while ( $row = $result->fetch_object() ) {
    
        $id[$n] = $row->id;
        $url[$n] = $row->url;
        
    $n++;
}
  

for ($l = 0 ; $l<$n ; $l++) {
    
    if (substr($url[$l],0,4) == 'http') {
        $nyurl[$l] = substr($url[$l],strpos($url[$l],'jernbane.net')+12);
        
        $query1 = "update gal_comments set clean_url = '$nyurl[$l]' where id = '$id[$l]'";
        $result1 = mysqli_query($db, $query1);
    }
}


$db->close();
?>