<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include('configi.php');

$n=0;

$query = "select * from gal_images where posthylla = 1 and type = 0";
$result = $db->query($query);

while ( $galliste = $result->fetch_array() ) {
    

$query0 = "update gal_images set posthylla = 0 where id = '$galliste[0]'";
$result0 = $db->query($query0);

$query1 = "update gal_images set type = 0 where id = '$galliste[0]'";
$result1 = $db->query($query1);

$query2 = "update gal_images set nummer = 0 where id = '$galliste[0]'";
$result2 = $db->query($query2);

// update modify_time
$timenow = date('U');
$query = "update gal_images set modify_time = $timenow where id = '$galliste[0]'"; 
$result = mysqli_query($db, $query);
 
    $n++;
    
     } 
     
     
 
$query = "select * from gal_images where posthylla = 1 and nummer = 0";
$result = $db->query($query);

while ( $galliste = $result->fetch_array() ) {
    

$query0 = "update gal_images set posthylla = 0 where id = '$galliste[0]'";
$result0 = $db->query($query0);

$query1 = "update gal_images set type = 0 where id = '$galliste[0]'";
$result1 = $db->query($query1);

$query2 = "update gal_images set nummer = 0 where id = '$galliste[0]'";
$result2 = $db->query($query2);

// update modify_time
$timenow = date('U');
$query = "update gal_images set modify_time = $timenow where id = '$galliste[0]'"; 
$result = mysqli_query($db, $query);
 
    $n++;
    
     } 
     
     
     
     
     
     
     
     
     
     


echo $n; echo " bilder behandlet";


?>
<br /><br />
