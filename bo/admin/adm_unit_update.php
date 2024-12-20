<?PHP
include('configi.php');
ini_set('max_input_vars',4096);

$antal=$_POST['antal'];
$land=$_POST['land'];
$cat=$_POST['cat'];
$type=$_POST['type'];

echo "antal "; echo $antal; echo "<br />";

for ($m = 1 ; $m<$antal ; $m++) {

$s[$m] = $_POST['s'.$m];
$tekst[$m] = strip_tags($_POST['t'.$m]);
$tekst[$m]=$db->real_escape_string($tekst[$m]);

$id[$m] = $_POST['i'.$m];

$query = "update gal_unit set enhet = '$tekst[$m]' where numid = '$id[$m]'"; 
$result = mysqli_query($db, $query);

$query1 = "update gal_unit set plass = '$s[$m]' where numid = '$id[$m]'"; 
$result1 = mysqli_query($db, $query1);

// update modify_time
$timenow = date('U');
$query = "update gal_unit set modify_time = $timenow where numid = '$id[$m]'"; 
$result = mysqli_query($db, $query);

}

echo "<script>parent.location.href='index.php?s=3&p=4&l=".$land."&c=".$cat."&t=".$type."#".$id[$m]."'</script>"; 


?>