<?PHP
$nykat=$_POST['nykat'];
$natid=$_POST['land'];
$seq=$_POST['seq'];

$nyseq=$seq+1;
include('configi.php');

// get country-info

$query = "select nat, natnavn from gal_nations where natid='$natid'";
$nat = $db->query($query)->fetch_object()->nat;
$natnavn = $db->query($query)->fetch_object()->natnavn;

$query = "UPDATE gal_kategori SET plass = plass+1 WHERE natid = '$natid' AND plass > '$seq'";
$result = mysqli_query($db, $query);

$query = "INSERT INTO gal_kategori (katname, plass, nat, natnavn, natid) VALUES ('$nykat','$nyseq','$nat','$natnavn','$natid')" ;
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='index.php?s=3&p=2&l=".$natid."'</script>";
?>