<?PHP
$antal=$_POST['antal'];
$land=$_POST['land'];
$cat=$_POST['cat'];

include('configi.php');

for ($m = 1 ; $m<$antal ; $m++) {

    $id[$m] = $_POST['i'.$m];
    $tekst[$m]=$_POST['t'.$m];
    $plass[$m] = $_POST['s'.$m];

    $tekst[$m] = $db->real_escape_string($tekst[$m]);

    $query = "UPDATE gal_type SET typename = '$tekst[$m]' WHERE typeid = '$id[$m]'";
    $result = mysqli_query($db, $query);

    $query = "UPDATE gal_type SET plass = '$plass[$m]' WHERE typeid = '$id[$m]'";
    $result = mysqli_query($db, $query);

    // update modify_time
    $timenow = date('U');
    $query = "update gal_type set modify_time = $timenow where typeid = '$id[$m]'"; 
    $result = mysqli_query($db, $query);

}

 echo "<script>parent.location.href='index.php?s=3&p=3&l=".$land."&c=".$cat."'</script>"; 
?>