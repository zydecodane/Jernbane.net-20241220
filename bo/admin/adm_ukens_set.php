<?php
if (isset($_POST['u'])) { $u = $_POST['u']; }
if (isset($_POST['y'])) { $y = $_POST['y']; }
if (isset($_POST['i'])) { $i = $_POST['i']; }
if (isset($_POST['n'])) { $n = $_POST['n']; }
/*
if(!isset($_POST['ae'])){$ae = -1;}
else {$ae = $_POST['ae'];}
if(isset($_GET['ae'])){$ae = $_GET['ae'];}
*/
// set active element parameter string
//$ae_parstr = "";
//if($ae>0) { $ae_parstr = "&ae=".$ae; }

$timestamp = date('U');
$current = date ('W');
include('configi.php');
// if ($u == $current) {$faktor = 1;}

// check om denne uge findes i tabellen
$query = "SELECT id, imgid FROM `gal_ukens` WHERE uke = '$u' AND aar = '$y'";
$result = $db->query($query);
$check = $result->fetch_array();

if(isset($check[0])) {
$query = "update gal_ukens set imgid = '$i' where id = '$check[0]'";	
$result = mysqli_query($db, $query);

$query = "update gal_ukens set navn = '$n' where id = '$check[0]'";
$result = mysqli_query($db, $query);

$query = "update gal_ukens set timestamp = '$timestamp' where id = '$check[0]'";
$result = mysqli_query($db, $query);
}

else {
$query = "insert into gal_ukens (imgid, uke, aar, navn, timestamp) values('$i','$u','$y','$n','$timestamp')";
$result = mysqli_query($db, $query);
}

echo '<script>parent.location.href="index.php?s=2&u='.$u.'&y='.$y.'"</script>';
?>