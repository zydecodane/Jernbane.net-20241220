<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$to = "mail@gill.dk";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "jernbanenet@gmail.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "done.";
?>