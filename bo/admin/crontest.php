<?php
include('configi.php');

$timestamp = date('d-m-Y - H:i:s');

$query = "insert into misc_misc (data) values('$timestamp')";
$result = mysqli_query($db, $query);



?>