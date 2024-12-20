<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Jernbane.net</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <link type="text/css" href="stylesheet.css" rel="stylesheet" /> 
 </head>
<body style="margin-top: 10px; -webkit-text-size-adjust: none;" >
<script type="Text/JavaScript">
		       function check() {
		       	if(document.getElementById('tekst').value == ''){ alert("vennligst skriv en kommentar"); return false;}
		       	if(document.getElementById('tekst').value.length < 15) { alert("Din kommentar m\u00e5 v\346re minst 15 tegn "); return false;}
		       	if(document.getElementById('tekst').value.match(/^\s*$/)){ alert("vennligst skriv en kommentar !!"); return false;}
		       	if(document.getElementById('tekst').value.match("   ")){ alert("vennligst skriv en kommentar, minst 15 tegn."); return false;}
}
</script>
<?php
 @$id = $_GET['id'];
 @$p = $_GET['p'];
?>
<style>
 #left {
 	height: 20px;
 	padding-top: 9px;  
 	width: 200px;
 	display: inline-block; 
 	text-align: left; 
 	padding-left: 20px; 
 	float: left;
}
 #right {
 	width: 330px; 
 	height: 30px;
 	padding-top: 2px; 
 	display: inline-block; 
 	text-align: right; 
 	float: left;
}
</style>
<div style="width: 600px; display: block;">
	<div style="padding-left: 20px; padding-right: 20px;">
		<div style="height: 34px; background-color: #800000; ">
		 	<div id="left">
				<img src="graphics/<?php echo $p; ?>stars.gif" alt="" />
		 	</div>
		 	<div id="right">
				<img src="graphics/jernbanenet_h28.gif" alt="" />
		 	</div>
		</div>
		<br />
		       <b>Du ga bildet <?php echo $p; ?> stjerne<?php if($p > 1) {echo "r";} ?>. Din kommentar: </b>	  
		<br /><br />	
		<form id="voteform" name="voteform" action="vote.php" method="post" <?php if ($p > 3) {echo 'onsubmit="return check();"';} ?>>  
			   <input type="text" name="tekst" id="tekst" style="width: 555px; border: 1px solid grey;" />
		       <input type="hidden" name="id" value="<?php echo $id; ?>" />
		       <input type="hidden" name="poeng" value="<?php echo $p; ?>" /><br />
		       <input type="submit" name="stem" value="Stem / Lagre kommentar" style="width: 200px;" ><img src="graphics/filler.gif" width="40px" alt="" border="0" />
		       <input type="reset" name="angre" value="   Angre   " style="width: 100px;" OnClick="javascript:parent.TINY.box.hide()" />
		</form>
		<br />
		<div class="vote_text">
Bedøm bildet etter fotografiets komponering og tekniske kvalitet og fotografens kreativitet, det gir fotografen en mulighet til å forbedre sin teknikk.<br />
<br />
Husk at alle en gang har vært nybegynnere, derfor er det bra at du er snill i kritikken mot våre nye venner. Husk at om du gir 3 stjerner eller mer, vil vi at du forklarer hvorfor du mener at bildet er så bra at fotografen fortjener ditt omdømme !
<br /><br />
Husk at du skal gi fotografen en rettferdig behandling.
<hr />
Rate the image after photographic composition and technical quality and the photographer´s creativity, it gives the photographers an opportunity to improve their technique.<br />
<br />
Remember that all have been beginners once, so be kind in your criticism towards our new friends.<br />
<br />
Remember, if you give three stars or more, we want you to explain why you think that the picture is so good that the photographer deserves the credit.<br />
	  </div>
		
		
	</div>
	
<script type="text/javascript"> 
setTimeout("document.getElementById('tekst').focus();",500);
</script>

</div>
</body>
</html>