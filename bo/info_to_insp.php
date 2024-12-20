<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Jernbane.net</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <link type="text/css" href="stylesheet.css" rel="stylesheet" /> 
 </head>
<body style="margin-top: 10px; -webkit-text-size-adjust: none;" >

<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

 @$id = $_POST['id'];
 if(isset($_POST['u'])) { $u = $_POST['u']; } else { $u = 0; }
 @$t = $_POST['t'];
 @$infotext = $_POST['infotext'];
?>
<style>
 #left {
 	height: 20px;
 	padding-top: 9px;  
 	width: 400px;
 	display: inline-block; 
 	text-align: left; 
 	padding-left: 20px; 
 	float: left;
 	color: #ffffff; 
 	font-size: 14px; 
 	font-weight: bold;
}
 #right {
 	width: 330px; 
 	height: 30px;
 	padding-top: 2px; 
 	display: inline-block; 
 	text-align: right; 
 	float: left;
}
</style>

<?php
include('configi.php');
$query = "select real_name from phorum_users where user_id='".$u."'";
$username = $db->query($query)->fetch_object()->real_name; 

$query1 = "select enhet from gal_unit where numid='".$id."'";
$unitname = $db->query($query1)->fetch_object()->enhet; 

$query2 = "select typename, katid from gal_type where typeid='".$t."'";
$typename = $db->query($query2)->fetch_object()->typename;
$katid = $db->query($query2)->fetch_object()->katid;

$query3 = "select natid from gal_kategori where katid='".$katid."'";
$natid = $db->query($query3)->fetch_object()->natid;
?>
<div style="width: 800px; display: block;">
	<div style="padding-left: 20px; padding-right: 20px;">
		<div style="height: 34px; background-color: #800000; ">
		 	<div id="left">
				<div><?php echo $username; ?></div>
		 	</div>
		 	<div id="right">
		 		<img src="graphics/jernbanenet_h28.gif" alt="" />
		 	</div>
		</div>

<?php

$query = "SELECT MAX(message_id) FROM `phorum_messages` AS max_id";
$result = $db->query($query);
while ( $galliste = $result->fetch_array() ) {
    $next_id = $galliste[0]+1; 
     } 

$datetime = date('U');
$forumhead = "!! - Supplerende informasjon - ".$typename."-".$unitname;
$forumbody = "[b]Supplerende informasjon mottatt via webform fra ".$username."[/b]\r\n\r\n".$infotext."\r\n\r\n----------------------------------------------\r\n\r\n[url=http://jernbane.net/bo/admin/index.php?s=3&amp;p=4&amp;l=".$natid."&amp;c=".$natid."&amp;t=".$t."]Link til administrering av denne typen[/url]\r\n";

$forumhead = $db->real_escape_string($forumhead);
$forumbody = mysqli_real_escape_string($db, $forumbody);

$clientip = $_SERVER['REMOTE_ADDR'];

if ($u > 0) {

$query = "INSERT INTO phorum_messages (forum_id, thread, user_id, author, subject, body, ip, status, modifystamp, thread_count, sort, datestamp, meta, recent_message_id, recent_user_id, recent_author) VALUES ('12', '$next_id', '$u', '$username', '$forumhead', '$forumbody', '$clientip', '2', '$datetime', '1', '2', '$datetime', 'a:0:{}', '$next_id', '$u', '$username')";
$result = mysqli_query($db, $query);

$searchtext = $username." | ".$forumhead." | ".$forumbody;

$query = "INSERT INTO phorum_search (message_id, forum_id, search_text) VALUES ('$next_id','$2', '$searchtext')";
$result = mysqli_query($db, $query);

$query = "UPDATE phorum_forums SET message_count=message_count+1 where forum_id = '2'";
$result = mysqli_query($db, $query);
$query = "UPDATE phorum_forums SET thread_count=thread_count+1 where forum_id = '2'"; 
$result = mysqli_query($db, $query);
$query = "UPDATE phorum_forums SET lats_post_time = '$datetime' where forum_id = '2'";
$result = mysqli_query($db, $query);

}
?>

	</div>
</div>


<script type="text/javascript">alert('Informasjonen er mottatt.');</script>
<script type="text/javascript">parent.TINY.box.hide();</script>
<script type="text/javascript">window.open('subpage.php?s=3&t=<?php echo $t; ?>#<?php echo $id; ?>','_top');</script>

</body>
</html>