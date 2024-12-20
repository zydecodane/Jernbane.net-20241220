<?PHP
$nykat=$_POST['nykat'];
$nyiso=$_POST['nyiso'];
$nycon=$_POST['nycontinent'];
$seq=$_POST['seq'];
$inseq=$seq+1;
include('configi.php');

$query = "UPDATE gal_nations SET plass = plass+1 WHERE plass > '$seq'";
$result = mysqli_query($db, $query);


// indset den nye category til sidst
$query = "INSERT INTO gal_nations (nat, natnavn, plass, gruppe) VALUES ('$nyiso','$nykat','$inseq', '$nycon')";
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='index.php?s=3&p=1'</script>";
?>