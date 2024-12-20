<?php
include('../configi.php');

$db = new mysqli($dbserver, $dbuserid, $dbpw, $dbase);
$db->set_charset("utf8");

$query = "select id, modify_time from gal_images where url = '' ";
$result = $db->query($query);

while ( $galliste = $result->fetch_array() ) {
    echo $galliste[0]; echo " - "; echo date("Y-m-d H:i:s",$galliste[1]); echo "<br />";
     } 






?>