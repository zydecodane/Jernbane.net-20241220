<br />
<div id="bo_heading" style="line-height:30px;">
   <span style="font-size: 16px;"><b>På Sporet av 2014</b></span>
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;} else {$loggedin = 0;}    
if ($loggedin == 0)
{ // user is not logged in
?>
<div class="bo_intro">
  <br /><br />
  Du er ikke innlogget. Du m&aring; v&aelig;re innlogget for &aring; kunne deltage i konkurransen. Log inn <a href="../phorum/login.php">her</a><br /><br /><br />
</div>
<?php
}
else // user IS logged in  
{
?>
<div class="bo_intro">

<script type="text/javascript" src="/datepicker/jquery-1.7.1.min.js"></script>

<?php
if(isset($_POST['username'])) {$username = $_POST['username']; } else { $username=''; }
if(isset($_POST['password'])) {$password = $_POST['password']; } else { $password=''; }
if(isset($_POST['forum'])) {$forum1 = $_POST['forum']; } else { $forum1=''; }
if(isset($_POST['bildetekst'])) {$tekst1 = $_POST['bildetekst']; } else { $tekst1=''; }
if(isset($_POST['forumhead'])) {$forumhead = $_POST['forumhead']; } else { $forumhead=''; }
if(isset($_POST['forumbody'])) {$forumbody = $_POST['forumbody']; } else { $forumbody=''; }


// get the user from db
$query = "select real_name from phorum_users where user_id = '$userid'";
$user = $db->query($query)->fetch_object()->real_name;
?>

<br />
<h3>Regler for deltagelse:</h3><br />

<b>Alle registrerte brukere av jernbane.net kan delta med opp til tre bilder hver</b>.<br />
<br />
Det er ikke nødvendig å redigere dine bilder i ett fotoprogram før opplasting, bilder større enn 1200pix i bredde justeres automatisk ned til passende størrelse.<br />
<br />
Alle bidrag skal være fotografert i 2014.<br />
<br />
Opplastingen til "På Sporet av 2014" stenger den 31 mars 2015!<br />
<br />
Du stemmer fram vinnerne ved å bruke stjernene.<br />
Avstemmingen pågår fra 1 februar til og med 30 april 2015.<br />
<br />
Glem ikke å lese <a href="http://jernbane.net/phorum/read.php?1,249070,249070#msg-249070" target="_parent" style="color: blue;">våre regler</a> for å delta i konkurransen.

<br />
<br />
<hr />
<b><?php echo $user; ?>, opplast ditt beste bilde her</b>
<br /><br />
<script type="Text/JavaScript">
           function isValidDate(sText) {
            var reDate = /(?:0[1-9]|[12][0-9]|3[01])\.(?:0[1-9]|1[0-2])\.(?:19|20\d{2})/;
           return reDate.test(sText);
    		}   		
          function validate() {
          if(document.getElementById('datepicker1').value != ''){
            var oInput1 = document.getElementById("datepicker1");
            if (isValidDate(oInput1.value)) {
           } else {
           if (document.getElementById('datepicker1').value != '')
            alert("Feil i datoformat - bilde 1"); return false;
            }
        }
            
     }
</script>
<!-- script for datepicker --!> 
		<script type="text/javascript">
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker1" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker1" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		</script>	


<!-- script for select-boxes --!>
<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
      $.get("func.php", {
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

function FillForumtekst(f) {
    f.bildetekst.value = f.forumbody.value; 
  }
</script>

<script type="Text/JavaScript">
function validate() {
	if(document.getElementById('bildetekst').value == ''){ alert("Vennligst skriv en tekst til ditt bilde."); return false;} 
	if(document.getElementById('bildetekst').value.substring(0,1) == ' '){ alert("Vennligst skriv en tekst til ditt bilde."); return false;} 

		
}
</script>

<form action="process_konk.php" method="post" name="form" enctype="multipart/form-data" onsubmit="return validate();">
<div style="width: 1024px; vertical-text-align: top; display: inline-flex;">



<div style="width: 500px; display: inline-block;">
	<input type="file" name="img[]" class="file" />
<br /><br />
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="70" height="30">
				Bildetekst:
			</td>
			<td>
				<input type="text" name="bildetekst" id="bildetekst" value="<?php echo $tekst1; ?>" style="width: 350px;"  />
			</td>
		</tr>
		<tr>
			<td width="70" height="30">
				Dato:
			</td>
			<td>
				<input type="text" name="date1" id="datepicker1" style="width:80px" />
			</td>
		</tr>
	</table>


 
<br /><br />

</div>

<div style="width: 400px; display: inline-block;">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="100" height="30">
				Land
			</td>
			<td width="300" height="30">
				<select name="drop_1" id="drop_1" >
		    <option value="" selected="selected" disabled="disabled" >Velg land</option>
		     <?php
		     include('func.php'); 
		     getTierOne(); 
		     ?>
		 </select>
			</td>
		</tr>
		<tr>
			<td width="100" height="30">
				Kategori
			</td>
			<td width="300" height="30">
				<span id="result_1" style="display: none;"></span>
			</td>
		</tr>
		<tr>
			<td width="100" height="30">
				Type
			</td>
			<td width="300" height="30">
				<span id="result_2" style="display: none;"></span>
			</td>
		</tr>
		<tr>
			<td width="100" height="30">
				Nummer
			</td>
			<td width="300" height="30">
				<span id="result_3" style="display: none;"></span>
			</td>
		</tr>
	</table>
		
</div>
</div>

<hr />
<br />
<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="100" height="30">
				Emne til inlegget:
			</td>
			<td>
				<input type="text" name="forumhead" id="forumhead" value="<?php echo $user; ?>" style="width: 400px;" />
			</td>
		</tr>
		<tr>
			<td width="100" height="30" valign="top">
				Tekst til inlegget:
			</td>
			<td>
				<textarea name="forumbody" id="forumbody" style="width: 400px; height: 70px;"><?php echo $forumbody; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="100" height="30" valign="top">
			</td>
			<td>
				<br /><br />
				<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
				<input type="submit" value="Last opp og send inlegg !" style="width: 400px;">
			</td>
		</tr>

</table>
<br />
 
<br /><br />
</form>



</div>
<?php
}
?>
</div>
<br /><br />

