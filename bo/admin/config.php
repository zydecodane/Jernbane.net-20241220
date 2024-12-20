<?php
define('PHORUM', "");
include ('../../phorum/include/db/config.php');

$server =  $PHORUM['DBCONFIG']['server'];
$dbuser =  $PHORUM['DBCONFIG']['user'];
$pw =  $PHORUM['DBCONFIG']['password'];
$dbase =  $PHORUM['DBCONFIG']['name'];
$port =  $PHORUM['DBCONFIG']['port'];

/*
$db = mysql_connect("$server".':'."$port","$dbuser","$pw");
mysql_select_db("$dbase",$db);
*/

$db = new mysqli($server, $userid, $pw, $dbase);
$db->set_charset("utf8");

?>