<?PHP
include('configi.php');

$nyunit=$_POST['nyunit'];
$nyunit=$db->real_escape_string($nyunit);

$seq=$_POST['seq'];
$land=$_POST['land'];
$cat=$_POST['cat'];
$type=$_POST['type'];

$nyseq=$seq+1;

$query = "update gal_unit set plass = plass+1 where typeid = '$type' and plass > '$seq'"; 
$result = mysqli_query($db, $query);

$timenow = date('U');
$query1 = "insert into gal_unit (enhet, typeid, plass, modify_time) values ('$nyunit','$type','$nyseq', $timenow)"; 
$result1 = mysqli_query($db, $query1);

echo "<script>parent.location.href='index.php?s=3&p=4&l=".$land."&c=".$cat."&t=".$type."'</script>";   

?>