<?PHP
include('configi.php');
ini_set('max_input_vars',4096);

$antal=$_POST['antal'];
$land=$_POST['land'];
$cat=$_POST['cat'];
$type=$_POST['type'];
$type=$_POST['type'];
$unit=$_POST['unit'];

echo "antal "; echo $antal; echo "<br />";

for ($m = 1 ; $m<$antal ; $m++) {

$s[$m] = $_POST['s'.$m];
$tekst[$m] = strip_tags($_POST['u'.$m]);
$tekst[$m]=$db->real_escape_string($tekst[$m]);

$id[$m] = $_POST['i'.$m];

$query = "update gal_unitdetail set navn = '$tekst[$m]' where detailid = '$id[$m]'"; 
$result = mysqli_query($db, $query);

$query1 = "update gal_unitdetail set plass = '$s[$m]' where detailid = '$id[$m]'"; 
$result1 = mysqli_query($db, $query1);

// update modify_time
$timenow = date('U');
$query = "update gal_unitdetail set modify_time = $timenow where detailid = '$id[$m]'"; 
$result = mysqli_query($db, $query);

}

echo "<script>parent.location.href='index.php?s=3&p=5&l=".$land."&c=".$cat."&t=".$type."&u=".$unit."#".$id[$m]."'</script>"; 


?>