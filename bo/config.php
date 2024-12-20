<?php


@define('PHORUM', "");
@include ('../phorum/include/db/config.php');
/*
$server =  $PHORUM['DBCONFIG']['server'];
$dbuser =  $PHORUM['DBCONFIG']['user'];
$pw =  $PHORUM['DBCONFIG']['password'];
$dbase =  $PHORUM['DBCONFIG']['name'];
$port =  $PHORUM['DBCONFIG']['port'];
*/


$dbserver =  'localhost';
$dbuserid =  'jernbane_net';
$dbpw =  'Kungsgatan72B';
$dbase =  'jernbane_net';

$db = mysql_connect("$server".':'."$port","$dbuser","$pw");
mysql_set_charset('utf8', $db);
  
mysql_select_db("$dbase",$db);


?>