<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="../datepicker/jquery-1.7.1.min.js"></script>
<?php
$id = 80234;
$url = 'http://jernbane.net/upload_08/1414831497_pa_20141031_04.jpg';
?>

<script>
jQuery(document).ready(function() {
jQuery("#btn").click(function() {
jQuery.ajax( {
	url: "info.php",
	data: {idx: "<?php echo $id; ?>",urlx: "<?php echo = $url; ?>"},
	success: function(data) { 
		$("#myDiv").append(data); 
		$("#new").show("slow"); 
    },
	});
});
});
</script>
</head>
<body>
<h2>Jernbane.net</h2>
<div id="myDiv"><h2>Let AJAX change this text</h2>
</div>
<button id="btn" type="button">Change Content</button>
</body>
</html>
