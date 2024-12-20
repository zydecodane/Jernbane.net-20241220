<?php


$dbserver =  'mysql54.unoeuro.com';
$dbuserid =  'jernbane_net';
$dbpw =  'Lotta1962';
$dbase =  'jernbane_net_db';

/*
$dbserver =  'localhost';
$dbuserid =  'phorum';
$dbpw =  'ivarslund';
$dbase =  'jernbane';
*/


$db = new mysqli($dbserver, $dbuserid, $dbpw, $dbase);
$db->set_charset("utf8");

?>