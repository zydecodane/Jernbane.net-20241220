<?PHP
$antal=$_POST['antal'];
$land=$_POST['land'];

include('configi.php');

for ($m = 1 ; $m<$antal ; $m++) {

$tekst[$m]=$_POST['t'.$m];
$id[$m] = $_POST['i'.$m];
$plass[$m] = $_POST['p'.$m];

$query = "UPDATE gal_kategori SET katname = '$tekst[$m]' WHERE katid = '$id[$m]'";
$result = mysqli_query($db, $query);

$query = "UPDATE gal_kategori SET plass = '$plass[$m]' WHERE katid = '$id[$m]'";
$result = mysqli_query($db, $query);
}


echo "<script>parent.location.href='index.php?s=3&p=2&l=".$land."'</script>"; 
?>