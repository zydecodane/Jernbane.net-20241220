<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<meta name="viewport" content="maximum-scale=1,width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<head>
<title>Jernbane.net</title>
 <link type="text/css" href="pc_stylesheet.css?v=<?php echo date('U'); ?>" rel="stylesheet" /> 
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
<div class="votecontainer">
	<div style="width: 280px; padding: 10px;">
		<div style="height: 17px; padding: 13px; background-color: #800000; ">
			<img src="graphics/<?php echo $p; ?>stars.gif" alt="" />
		</div>
		<br />
		<b>Du ga bildet <?php echo $p; ?> stjerne<?php if($p > 1) {echo "r";} ?>. Din kommentar: </b>	  
		<br /><br />	
		<form id="voteform" name="voteform" action="vote.php" method="post" <?php if ($p > 3) {echo 'onsubmit="return check();"';} ?>>  
			   <input type="text" name="tekst" id="tekst" style="width: 275px; height: 20px; border: 1px solid grey;" />
		       <input type="hidden" name="id" value="<?php echo $id; ?>" /><br /><br /><br />
		       <input type="hidden" name="poeng" value="<?php echo $p; ?>" /><br />
		       <input type="submit" name="stem" value="Stem / Lagre kommentar" style="width: 275px;" ><img src="graphics/filler.gif" width="40px" alt="" border="0" /><br />
		       <input type="reset" name="angre" value="   Angre   " style="width: 275px;" OnClick="javascript:parent.TINY.box.hide()" />
		</form>
		<br />
				
		
	</div>
	
<script type="text/javascript"> 
setTimeout("document.getElementById('tekst').focus();",500);
</script>

</div>
</body>
</html>