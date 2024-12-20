<?PHP
$id=$_POST['id'];
$tekst=$_POST['tekst'];

include('configi.php');

$tekst = addslashes($tekst);

$query = "update misc_betingelser set tekst = '$tekst' where id = '$id'";
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='index.php?s=13'</script>"; 
?>