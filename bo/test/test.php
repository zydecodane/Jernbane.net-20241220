<script type="Text/JavaScript">
function check() {
   	if(document.getElementById('tekst').value == ''){ alert("vennligst skriv en kommentar"); return false;}
   	if(document.getElementById('tekst').value.length < 20) { alert("Din kommentar m\u00e5 være minst 20 tegn "); return false;}
   	if(document.getElementById('tekst').value.match(/^\s*$/)){ alert("nej det går ikke"); return false;}
   	if(document.getElementById('tekst').value.match("   ")){ alert("nej det går heller ikke"); return false;}

}

</script>






<form id="voteform" name="voteform" action="vote.php" method="post" onsubmit="return check();">
	<input type="text" name="tekst", id="tekst">
	<br />
	<input type="submit">
</form>
