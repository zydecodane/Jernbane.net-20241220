<?PHP
$ufolder=$_POST['ufolder'];
include('configi.php');

$query = "update gal_variables set var = '$ufolder' where name = 'upload_folder'";
$result = mysqli_query($db, $query);


echo "<script>parent.location.href='index.php?s=3'</script>"; 

  

?>