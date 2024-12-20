<?php


$dbserver =  'mysql54.unoeuro.com';
$dbuserid =  'jernbane_net';
$dbpw =  'Lotta1962';
$dbase =  'jernbane_net_db';




$db = new mysqli($dbserver, $dbuserid, $dbpw, $dbase);
$db->set_charset("utf8");


/*
Server-flytning:
phorum_settings: 
- session_domain: jernbane.net
- http_path: http://jernbane.net


*/


?>