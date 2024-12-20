<?php
include('configi.php');

if (isset($_POST['navn'])) {$navn=$_POST['navn'];} 

$query = "insert into misc_sponsor (navn) values ('$navn')"; 
$result = mysqli_query($db, $query);

header("location: ../subpage.php?s=13");
?>