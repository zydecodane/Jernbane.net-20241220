<!-- script for select-boxes --!>
<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
      $.get("funci.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_four(id, response) {
  $('#wait_3').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
</script>
<script type="text/javascript" src="fancybox/jquery_min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$("a#single").fancybox({
		'padding'  : 0,
		'margin'   : 0
		});
		$("a.grouped_elements").fancybox({
			'padding'  : 0,
		    'margin'   : 0,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition'     : 'none',
			'titleShow'         : 'none'
		});
				});
</script>
<?php

 if(isset($_POST['id'])) { $id = $_POST['id']; }
 if(isset($_GET['id'])) { $id = $_GET['id']; }
 if(isset($_POST['fi'])) { $fi = $_POST['fi']; } 
 if(isset($_GET['fi'])) { $fi = $_GET['fi']; }


 
 $query = "select id, url, thumb, fotograf, tekst, dato, type, nummer from gal_images where id = '$id'";
 $result = $db->query($query);
 $img = $result->fetch_array();
?>

<div class="wide_heading">
	Bildets kommentarer
</div>
<div class="wide_content" style="overflow: hidden;">


<?php
echo "Fotograf: "; echo $img[3]; echo "<br />";
echo $img[4];
if ($img[5]!=0) { echo ", "; echo date('j.n.Y', $img[5]); }

?>
	<br />
	<br />

	<a class="grouped_elements" rel="" href="<?php echo $img[1]; ?>"><img src="<?php echo $img[2]; ?>" alt="0" class="adm_img" /></a>

	
<?php
$query1 = "select * from gal_comments where url = '$img[1]'";
 $result1 = $db->query($query1);
?>
<br /><br />
<style>
	.comtable td
	{
	border: 2px solid #ffffff; 
	background-color: #E6E6E6; 
	padding: 5px;
	spacing: 5px;
	}
</style>
<table class="comtable">
	<tr>
		<td width="220">
			<b>Bruker</b>
		</td>
		<td width="670">
			<b>Kommentar</b>
		</td>
		<td width="50">
			<b>Poeng</b>
		</td>
		<td width="130">
			<b>dato/tid</b>
		</td>
		<td width="80">
			<b>Slett</b>
		</td>
	</tr>
<?php
while ( $comliste = $result1->fetch_array() ) {
?>
	<tr>
		<td width="220">
			<?php echo $comliste[4]; ?>
		</td>
		<td width="670">
			<?php echo $comliste[2]; ?>
		</td>
		<td width="50" style="text-align:center;">
			<?php echo $comliste[3]; ?>
		</td>
		<td width="130">
			<?php
				date_default_timezone_set('Europe/Oslo');
				echo date('d.m.Y - H:i:s',$comliste[5]);
			?>
		</td>
		<td width="80">
			<style>
				.knap {
					height: 17px; 
					line-height: 13px; 
					width: 78px; 
					margin: 0px;
					//border: 1px solid black;
					//background-color: #ffffff;
				}
			</style>
			<form name="commslett<?php echo $comliste[0] ?>" method="post" action="adm_comm_slet.php" style="margin: 0px;" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette denne kommentaren og de tilh\u00F8rende poeng?');">
				<input type="hidden" name="id" value="<?php echo $comliste[0]; ?>" />
				<input type="hidden" name="imgid" value="<?php echo $img[0]; ?>" />
				<input type="hidden" name="poeng" value="<?php echo $comliste[3]; ?>" />
				<input type="submit" value="  slett  "  class="knap" />
			</form>
		</td>
	</tr>
<?php	
     } 
?>

</table>

<br /><br />
<form name="tilbage" method="post" action="../subpage.php?s=0&id=<?php echo $img[0]; ?>" style="margin: 0px;">
	<input type="submit" value="  tilbake  " style="width: 100px;" />
</form>
<br />

</div>