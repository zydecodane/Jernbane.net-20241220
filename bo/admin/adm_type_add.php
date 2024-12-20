<?PHP
error_reporting(-1);
ini_set('display_errors', 'On');

include('configi.php');

$nytype=$_POST['nytype'];
$seq=$_POST['seq'];
$land=$_POST['land'];
$cat=$_POST['cat'];

$nytype = $db->real_escape_string($nytype);

$nyseq=$seq+1;

$query = "UPDATE gal_type SET plass = plass+1 WHERE katid = '$cat' AND plass > '$seq'";
$result = mysqli_query($db, $query);


$timenow = date('U');
$query = "INSERT INTO gal_type (typename, katid, plass, modify_time) VALUES ('$nytype','$cat','$nyseq', $timenow)";
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='index.php?s=3&p=3&l=".$land."&c=".$cat."'</script>";   
?>