<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;

$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);
// get users real name from database
$query = "select real_name, admin from phorum_users where user_id='$userid'";
$username = $db->query($query)->fetch_object()->real_name;
$isadmin = $db->query($query)->fetch_object()->admin;

$query2 = "select datetime from misc_user where user_id = '$userid'";
$datetime = $db->query($query2)->fetch_object()->datetime;
}
?>
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
  	<form name="lan" action="subpage.php?s=16" method="POST">
  		<select name="language" onchange="this.form.submit()">
  	  	  <option value="norsk" <?php if ($language=='norsk'){echo "selected";} ?>>norsk</option>
  	  	<option value="english" <?php if ($language=='english'){echo "selected";} ?>>english</option>
  		</select>  
  	</form>	
  </div>
  <div style="display:inline-block;margin-left:50px;">
	  <?php
	  if ($loggedin == 1) {
	  	  echo $username; if ($language=='norsk'){echo " har godkjent brukerrettigheter og regler ";echo date("d.m.Y, H:i",$datetime);} else {echo " has accepted rules and regulations "; echo date("F j, Y, g:i a",$datetime);}
		  		
	  }
	  	
		
	  ?>
  </div>
  <hr />
  <?php
  if ($language == 'norsk') {$id = 1;}
  if ($language == 'english') {$id = 2;}

  $query = "select tekst from misc_betingelser where id = '$id'";	
  $tekst = $db->query($query)->fetch_object()->tekst;
echo"<br /><br />";
echo $tekst;
?>




</div>
<br /><br />



