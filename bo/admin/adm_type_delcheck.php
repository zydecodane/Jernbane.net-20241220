<?php 
$l = $_GET['l'];
$c = $_GET['c'];
$t = $_GET['t'];

include('configi.php');

$query0 = "select typename from gal_type where typeid='$t'";

$typename = $db->query($query0)->fetch_object()->typename;

$typename = utf8_decode($typename);

$n=0;

$query1 = "select id from gal_images where type='$t'";

$result1 = $db->query($query1);
while ( $liste1 = $result1->fetch_array() ) {
    $n++;    } 

if ($n > 0){
?>
<script type="text/javascript">
	alert("<?php echo htmlspecialchars($typename); ?>\n\nDu kan ikke slette denne type/bane\nDer er <?php echo $n; ?> bilder i databasen");
</script>
<?php
	echo '<script>parent.location.href="index.php?s=3&p=3&l='.$l.'&c='.$c.'&t='.$t.'"</script>';	
}

else {
$unitlist = '';	
	$query2 = "select numid, enhet from gal_unit where typeid='$t'";

	$result2 = $db->query($query2);

// var_dump($result2);

	// while ($liste2 = $result2->fetch_array() ) {	
	// 	$unitlist .= '- '.$liste2[1].'\n';
	// }
?>
<script type="text/javascript">	
 var l = <?php echo $l; ?>;
 var c = <?php echo $c; ?>;
 var t = <?php echo $t; ?>;
 var confirmationText = "Ingen bilder i databasen.\n<?php echo htmlspecialchars($typename); ?> inneholder disse enheter/steder, som ogs\u00E5 vil bli slettet:\n\n<?php echo $unitlist; ?>\nVil du fortsette?";
 var r = confirm(confirmationText);
if (r == true) {
	parent.location.href="adm_type_del_nak.php?s=3&p=3&l="+l+"&t="+t+"&c="+c;
} else {
    parent.location.href="index.php?s=3&p=3&l="+l+"&c="+c;
}	

</script>


<?php
}

?>