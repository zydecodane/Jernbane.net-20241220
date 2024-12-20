<?PHP
$version=$_POST['version'];
include('configi.php');

$query = "update misc_betingelser set version = '$version'";
$result = mysqli_query($db, $query);


echo "<script>parent.location.href='../../phorum/index.php'</script>"; 

  

?>