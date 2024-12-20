<script type="Text/JavaScript">
function validate() {
	if(document.getElementById('navn').value == ''){ alert("Vennligst skriv et navn."); return false;} 
}
</script>
<div class="wide_heading">
	Legg til en sponsor
</div>
<div class="wide_content" style="overflow: hidden;">

<br  />
<form action="adm_sponsor_add.php" method="post" onsubmit="return validate();">
Navn: <input type="text" name="navn" id="navn" style="margin-left: 40px; width: 200px;"><br />
<br/>
<input type="submit" value="Legg til" style="margin-left: 75px;">
</form>
<br />



</div>