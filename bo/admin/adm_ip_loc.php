<?php
$ip = $_GET['ip'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

?>
<script type="text/javascript">
	alert('country: <?php echo $details->country; ?>\ncity: <?php echo $details->city; ?>\nregion: <?php echo $details->region; ?>\nhost: <?php echo $details->hostname; ?>\nlocation: <?php echo $details->loc; ?>');
</script>

<script>parent.location.href='index.php?s=8'</script>

?>