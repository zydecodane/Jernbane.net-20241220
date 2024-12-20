<?php

// New file
// FP 20240210

include('configi.php');
include('../func/func_retext.php');

// Test
echo('<p>Her er adm_retext_update.php</p>');

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$eg = isset($_POST['eg']) ? $_POST['eg'] : 0;

if (isset($_POST['u'])) {
    $unit = $_POST['u'];
}
if (isset($_POST['fi'])) {
    $fi = $_POST['fi'];
}

if (!isset($_POST['ae'])) {
    $ae = -1;
} else {
    $ae = $_POST['ae'];
}
if (isset($_GET['ae'])) {
    $ae = $_GET['ae'];
}
if (isset($_POST['padmin'])) {
    $padmin = $_POST['padmin'];
} else {
    $padmin = 0;
}

$photographer = isset($_POST['fotograf']) ? $_POST['fotograf'] : '';
$newtext = isset($_POST['tekst']) ? $_POST['tekst'] : '';
$newdate = isset($_POST['dato']) ? $_POST['dato'] : '';

// set active element parameter string
$ae_parstr = "";
if ($ae > 0) {
    $ae_parstr = "&ae=" . $ae;
}


// Test: Print the parameters

// var_dump($_POST);

// echo("<p>id = " . $id . "</p>");
// echo("<p>u = " . $unit . "</p>");
// echo("<p>page = " . $page . "</p>");
// echo("<p>fi = " . $fi . "</p>");
// echo("<p>eg = " . $eg . "</p>");
// echo("<p>padmin = " . $padmin . "</p>");
// echo("<p>ae = " . $ae . "</p>");
// echo("<p>ae_parstr = " . $ae_parstr . "</p>");
// echo("<p>fotograf = " . $photographer . "</p>");
// echo("<p>tekst = " . $newtext . "</p>");
// echo("<p>dato = " . $newdate . "</p>");

// Test ende


// Sanitize params



retext_image($id, $photographer, $newtext, $newdate);

retext_db($id, $photographer, $newtext, $newdate);

if ($page == "gal") 
{
	echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit."'</script>";
}

if ($page=="show")
{
    if($unit!=0) {
        echo "<script>parent.location.href='../subpage.php?s=4&u=".$unit."'</script>";
    } else {
        echo "<script>parent.location.href='../subpage.php?s=0&id=".$id."'</script>"; 
    }
}

else
{

	echo "<script>parent.location.href='index.php?s=1&p=".$page."&eg=".$eg.$ae_parstr."'</script>";

}