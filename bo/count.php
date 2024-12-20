<?php
include ('config.php');

mysql_query("ALTER TABLE phorum_messages AUTO_INCREMENT = 160000");

$getcount = mysql_query("SELECT count(*) FROM phorum_messages");
$count = mysql_result($getcount,0);
echo $count;


?>