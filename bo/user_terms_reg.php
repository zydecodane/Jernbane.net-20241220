<?php
if (isset($_POST['userid'])){$userid = $_POST['userid'];} else {$userid = 0;}
$datetime = date('U');

if ($userid > 0) {
include('configi.php');

$query0 = "select real_name from phorum_users where user_id = '$userid'";
$realname = $db->query($query0)->fetch_object()->real_name;

// hent current version

$query = "select version from misc_betingelser where id = '1'";
$currversion = $db->query($query)->fetch_object()->version;

$accversion = 0;
$query2 = "select version from misc_user where user_id = '$userid'";
@$result2 = $db->query($query2)->fetch_object()->version;
if (isset($result2)){ //user er i tabellen i forvejen 
		$query3 = "update misc_user set version = '$currversion', datetime = '$datetime' where user_id = '$userid'";
		$result3 = mysqli_query($db, $query3);
	}
	else // user skal tilføjes i tabellen
	{
		$query4 = "insert into misc_user (user_id, username, version, datetime) values ('$userid','$realname','$currversion','$datetime')";
		$result4 = mysqli_query($db, $query4);
	}	

}
echo "<script>parent.location.href='../phorum/index.php'</script>";
?>