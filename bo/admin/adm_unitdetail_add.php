<?PHP
include('configi.php');

$nyunitdetail=$_POST['nyunitdetail'];
$nyunitdetail=$db->real_escape_string($nyunitdetail);

$seq=$_POST['seq'];
$land=$_POST['land'];
$cat=$_POST['cat'];
$type=$_POST['type'];
$unit=$_POST['unit'];

$nyseq=$seq+1;

$query = "update gal_unitdetail set plass = plass+1 where numid = '$unit' and plass > '$seq'"; 
$result = mysqli_query($db, $query);

$timenow = date('U');
$query1 = "insert into gal_unitdetail (navn, numID, plass, modify_time) values ('$nyunitdetail','$unit','$nyseq', $timenow)"; 
$result1 = mysqli_query($db, $query1);

echo "<script>parent.location.href='index.php?s=3&p=5&l=".$land."&c=".$cat."&t=".$type."&u=".$unit."'</script>";   

?>