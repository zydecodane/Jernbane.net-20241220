<?php
if (isset($_GET['user'])){$userid = $_GET['user'];} else {$userid = 0;}
if ($userid > 0) {
$query = "select real_name from phorum_users where user_id = '$userid'";
$real_name = $db->query($query)->fetch_object()->real_name;
?>
<script type="text/javascript">
alert('Hei <?php echo $real_name; ?>\n\nDu har ennå ikke akseptert våre nye vilkår. Vennligst aksepter for å få full tilgang til alle funksjoner på Jernbane.Net\n\nYou have not yet accepted our new terms and conditions. Please accept in order to gain full access to all features at Jernbane.Net');
</script>
<?php
}
?>
<br />
<script type="text/javascript">
		function validateCheckboxes() {
		   if (document.querySelector('[name="2"]:checked')) {
		        return true;
		   } else {
		        alert('Du må akseptere reglene / You must accept the rules');
		        return false;
		   }
		};
	</script>

<div id="bo_heading">

   <span style="font-size: 14px;">Brukerrettigehder og regler / terms and conditions</span>
   <img src="graphics/filler.gif" width="10px" height="23px" />
   
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<div class="bo_intro">
  <br />
  <?php
  if (isset($_POST['language'])) {$language=$_POST['language'];} else {$language='norsk';}
  ?>
  <div style="display:inline-block;">
  	<form name="lan" action="subpage.php?s=10&amp;user=<?php echo $userid; ?>" method="POST">
  		<select name="language" onchange="this.form.submit()">
  	  	  <option value="norsk" <?php if ($language=='norsk'){echo "selected";} ?>>norsk</option>
  	  	<option value="english" <?php if ($language=='english'){echo "selected";} ?>>english</option>
  		</select>  
  	</form>	
  </div>
  <?php
  if ($language == 'norsk') {$id = 1;}
  if ($language == 'english') {$id = 2;}

  $query = "select tekst from misc_betingelser where id = '$id'";	
  $tekst = $db->query($query)->fetch_object()->tekst;
echo"<br /><br />";
echo $tekst;
?>
<hr /><br />
<div style="display: inline-block; width: 30px;">
<form action="user_terms_reg.php" method="post" onsubmit="return validateCheckboxes();">
	<input type="checkbox" name="2" value="12" id="2_12" />
	<br /><br />
	<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
</div>	
<div style="display: inline-block; width: 1000px;">
<?php
if ($id == 1) {echo "<b>Ved å godkjenne reglene for bruk av nettstedet Jernbane.Net bekrefter jeg at jeg har lest og forstått reglene for bruk av nettstedet. Samtidig bekrefter jeg at jeg er fylt 18 år ved tidspunktet for godkjenningen av denne avtalen. I fall jeg ikke er fylt 18 år bekrefter jeg at jeg har tillatelsen fra mine foresatte.</b>";}
if ($id == 2) {echo "<b>By accepting the rules for the Jernbane.Net website, I confirm that I have read and understood the rules. I confirm that I am 18 years old at the time of approval of this agreement. In case I have not reached the age of 18, I confirm that I have the permission of my guardians.</b>";}
?>
</div>
<br /><br />
		<input type="submit" value="<?php if ($id==1){echo "Jeg aksepterer";} else {echo "I accept";} ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="location.href='../bo/logoff.php?u=<?php echo $userid; ?>';" value="Logoff" />
</form>	
<br /><br />



</div>
<br /><br />



