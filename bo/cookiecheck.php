<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["bbuserid"]))
{ $loggedin = 1;} else {$loggedin = 0;}    


if ($loggedin == 1) {
	$userid = $_COOKIE["bbuserid"];
	include ('configi.php');
	$dbase =  'jernbane_net_db_forum';	
	
	$db = new mysqli($dbserver, $dbuserid, $dbpw, $dbase);
	$db->set_charset("utf8");

	$username = $db->query("select displayname from user where userid = '$userid'")->fetch_object()->displayname;

echo $userid; echo ' - '; echo $username; 



}

else {
	
	echo "ikke logged in";
}

	
?>



