<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Jernbane.Net</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <link type="text/css" href="stylesheet.css" rel="stylesheet" /> 
 </head>
<body style="margin-top: 10px; -webkit-text-size-adjust: none;" >
<script type="Text/JavaScript">
		       function check() {
		       	if(document.getElementById('infotext').value == ''){ alert("Du har ikke skrevet noe som helst..."); return false;}
		       	}
</script>
<?php
 @$id = $_GET['id'];
 @$u = $_GET['u'];
 @$t = $_GET['t'];
?>
<style>
 #left {
 	height: 20px;
 	padding-top: 9px;  
 	width: 400px;
 	display: inline-block; 
 	text-align: left; 
 	padding-left: 20px; 
 	float: left;
 	color: #ffffff; 
 	font-size: 16px; 
 	font-weight: bold;
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

<?php
include('configi.php');
$query = "select real_name from phorum_users where user_id='".$u."'";
$username = $db->query($query)->fetch_object()->real_name; 

$query1 = "select enhet from gal_unit where numid='".$id."'";
$unitname = $db->query($query1)->fetch_object()->enhet; 

$query2 = "select typename from gal_type where typeid='".$t."'";
$typename = $db->query($query2)->fetch_object()->typename;
?>
<script type="text/javascript">
function resetFunc() {
    javascript:parent.TINY.box.hide();
	javascript:window.open('subpage.php?s=3&t=<?php echo $t; ?>#<?php echo $id; ?>','_top');
}
</script>


<div style="width: 800px; display: block;">
	<div style="padding-left: 20px; padding-right: 20px;">
		<div style="height: 34px; background-color: #800000; ">
		 	<div id="left">
				<div><?php echo $username; ?></div>
		 	</div>
		 	<div id="right">
				<img src="graphics/jernbanenet_h28.gif" alt="" />
		 	</div>
		</div>
		<br />
		<b>Legg til informasjon om <?php echo $typename; echo " - ";echo $unitname; ?></b>	  
		<br /><br />	
		Legg til dine opplysninger om enheten her.
		En av våre administratorer vil gå gjennom informasjonen du sender.<br>Informasjonen vil eventuelt legges til i vårt galleri.
		<br /><br />
		<form id="infoform" name="infoform" action="info_to_insp.php" method="post" onsubmit="return check();">  
			<textarea name="infotext" id="infotext" style="width: 755px; height: 190px;"></textarea><br />	 
			<input type="hidden" name="u" value="<?php echo $u; ?>" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="t" value="<?php echo $t; ?>" />  
		    <input type="submit" name="send" value="Send" style="width: 200px;" ><img src="graphics/filler.gif" width="40px" alt="" border="0" />
		    <input type="reset" name="angre" value="   Angre   " style="width: 100px;" OnClick="javascript:resetFunc();" />
		</form>
		<br />
      <p></p>
	</div>
	
<script type="text/javascript"> 
setTimeout("document.getElementById('infotext').focus();",500);
</script>

</div>
</body>
</html>