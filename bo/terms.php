<?php
if (isset($_POST['language'])) {$language=$_POST['language'];} else {$language='norsk';}
?>
<form name="lan" action="terms.php" method="POST">
	<select name="language" onchange="this.form.submit()">
  	  <option value="norsk" <?php if ($language=='norsk'){echo "selected";} ?>>norsk</option>
  	<option value="english" <?php if ($language=='english'){echo "selected";} ?>>english</option>
	</select>  
</form>	
<?php
if ($language == 'norsk') {$id = 1;}
if ($language == 'english') {$id = 2;}

include('configi.php');
$query="select tekst from misc_betingelser where id = '$id'";
$tekst = $db->query($query)->fetch_object()->tekst;	
?>
<div style="font-family: Helvetica,Arial,Verdana,Sans-Serif;font-size: 12px;color: #000000;">	
<?php echo $tekst; ?>
</div>	
