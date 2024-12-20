<br />
<div id="bo_heading" style="line-height:30px;">
   <span style="font-size: 16px;"><b>Kvikk-opplasting</b></span>
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
  Du er ikke innlogget. Du må være innlogget for å kunne laste opp bilder. Log inn <a href="../phorum/login.php">her</a><br /><br /><br />
</div>
<?php
}
else // user IS logged in  
{
?>
<div class="bo_intro">
<br />
Her kan du laste opp et bilde og skrive et innlegg i en av vognene i én operasjon.<br />
<br />
Du trenger ikke å behandle bildet - hvis bildet er for stort, vil det bli justert automatisk.<br />
<hr />
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
	if(document.getElementById('forum').value == ''){ alert("Vennligst velg en vogn."); return false;}
	if(document.getElementById('forumhead').value == ''){ alert("Vennligst skriv en overskrift til ditt innlegg."); return false;}
	

		
}
</script>

<form action="process_konk.php" method="post" name="form" enctype="multipart/form-data" onsubmit="return validate();">


<div class="bosimple_container">

	<div class="bosimple_left">
		<input type="file" name="img[]" class="file" />
	<br /><br />
				<div class="bosimple_lefttab">
					Fotograf:
				</div>
				<div class="bosimple_righttab">
					<input type="text" name="fotograf" value="<?php echo $user; ?>"  class="bosimple_inputfield" />
				</div>
				
				<div class="bosimple_lefttab">
					Bildetekst:
				</div>
				<div class="bosimple_righttab">
					<input type="text" name="bildetekst" id="bildetekst" value="<?php echo $tekst1; ?>" class="bosimple_inputfield"  />
				</div>
				
				<div class="bosimple_lefttab">
					Dato:
				</div>
				<div class="bosimple_righttab">
					<input type="text" name="date1" id="datepicker1" style="width:80px" />
				</div>
	<br />

</div>
<div class="bosimple_container">	
	</div>
	<div class="mobile_show">
		<hr />
	</div>
	<div class="bosimple_right">
	
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="100" height="30">
					Land
				</td>
				<td class="bosimple_cattabr">
					<select name="drop_1" id="drop_1" >
			    <option value="" selected="selected" disabled="disabled" >Velg land</option>
			     <?php
			     include('func.php'); 
			     getTierOne(); 
			     ?>
			 </select>&nbsp;<span id="wait_1" style="display: none;">
	    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
	    </span>
				</td>
			</tr>
			<tr>
				<td width="100" height="30">
					Kategori
				</td>
				<td class="bosimple_cattabr">
					<span id="result_1" style="display: none;"></span>&nbsp;
	    <span id="wait_2" style="display: none;">
	    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
	    </span>
				</td>
			</tr>
			<tr>
				<td width="100" height="30">
					Type
				</td>
				<td class="bosimple_cattabr">
					<span id="result_2" style="display: none;"></span>&nbsp;
	    <span id="wait_3" style="display: none;">
	    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
	    </span>
				</td>
			</tr>
			<tr>
				<td width="100" height="30">
					Nummer
				</td>
				<td class="bosimple_cattabr">
					<span id="result_3" style="display: none;"></span>
				</td>
			</tr>
		</table>
			
	</div>
	
	
	<hr />
	<br />

				<div class="bosimple_lefttab">
					Velg vogn:
				</div>
				<div class="bosimple_righttab">
					<select name="forum" id="forum" >
					    <option value="" selected="selected" disabled="disabled" >Velg vogn</option>
					    <option value="8" <?php if($forum1=="8") { echo 'selected="selected"'; }  ?>>Postvogna</option>
					    <option value="7" <?php if($forum1=="7") { echo 'selected="selected"'; }  ?>>Interrailvogna</option>
					</select>	
				</div>
				<div class="mobile">	
					<br />	
				</div>
				<div class="bosimple_lefttab">
					Emne til inlegget:
				</div>
				<div class="bosimple_righttab">
					<input type="text" name="forumhead" id="forumhead" class="bosimple_inputfield" />
				</div>	
				<div class="mobile">	
					<br />	
				</div>	
				<div class="bosimple_lefttab">
					Tekst til innlegget:
				</div>
				<div class="bosimple_righttab">
					<textarea name="forumbody" id="forumbody" rows="4" class="bosimple_inputfield"><?php echo $forumbody; ?></textarea>
				</div>
				
				<div class="bosimple_lefttab">
				</div>
				
				<div class="bosimple_righttab">
					<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
				</div>
				<div class="bosimple_lefttab">
				</div>
				<div class="bosimple_righttab">
					<div class="mobile">	
						<br />	
					</div>
					<input type="submit" value="Last opp og send inlegg !" class="bosimple_inputfield">
				</div>
			
	<br />
	 
	<br /><br />
	</form>
	
	
	<?php
	}
	?>
	</div>

</div>


<br /><br />

