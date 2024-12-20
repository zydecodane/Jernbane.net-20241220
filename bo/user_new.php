<?php
$query0 = "select version from misc_betingelser where id = '1'";	
$version = $db->query($query0)->fetch_object()->version;

include('configi.php');

if(isset($userdata["username"])) { $username = $userdata["username"]; }

$datotid = date('U');
	
$query = "select user_id, real_name from phorum_users where username = '$username'";	
$userid = $db->query($query)->fetch_object()->user_id;
$realname = $db->query($query)->fetch_object()->real_name;

	
$result2='';	
$query2 = "select user_id from misc_user where user_id = '$userid'";
@$result2 = $db->query($query2)->fetch_object()->user_id;
	
if($result2 == '') {
   
	$query3 = "insert into misc_user (user_id, username, version, datetime) values('$userid','$realname','$version','$datotid')"; 
	$result3 = mysqli_query($db, $query3);
	
}
?>