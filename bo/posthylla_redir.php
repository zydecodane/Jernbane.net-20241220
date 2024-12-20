<?php
// include('configi.php');

// $query = "select data from phorum_settings where name = 'http_path'";
// $http_path = $db->query($query)->fetch_object()->data;

if (isset($_GET['img'])) { $img = $_GET['img']; } 
if (isset($_GET['id'])) { $id = $_GET['id']; }

// $query = "select message_id from phorum_search where search_text like '%/$img%'";
// $mid = $db->query($query)->fetch_object()->message_id ;

// if (empty($mid)){
$url='subpage.php?s=0&id='.$id ; 
// }
/*
else {
	$query1 = "select message_id, forum_id, thread from phorum_messages where message_id='$mid'";
	$result1 = $db->query($query1);
	$post = $result1->fetch_array();	
	
$url=$http_path.'/read.php?'.$post[1].','.$post[2].','.$post[0].'#msg-'.$post[0];
}
*/
header ("Location: $url");
?>