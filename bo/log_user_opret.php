<?php
include('configi.php');

if(isset($_SERVER['REMOTE_ADDR'])) { $bruker_ip = $_SERVER['REMOTE_ADDR']; }
if(isset($userdata["username"])) { $bruker_navn = $userdata["username"]; }
if(isset($_POST["real_name"])) { $bruker_realname = $_POST["real_name"]; }
if(isset($userdata["email"])) { $bruker_email = $userdata["email"]; }
$datotid = date('U');

$query="INSERT INTO log_user_create (datetime, user_name, user_realname, user_email, user_ip) VALUES ('$datotid', '$bruker_navn', '$bruker_realname', '$bruker_email', '$bruker_ip')";
$result = mysqli_query($db, $query);
?>