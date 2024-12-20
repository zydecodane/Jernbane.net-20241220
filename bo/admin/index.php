<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="../stylesheet.css" rel="stylesheet" />
<link type="text/css" href="style.css?v=3" rel="stylesheet" />
<link type="text/css" href="../datepicker/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../datepicker/jquery-1.7.1.min.js"></script>

<script type="text/javascript">
      function documentGoto(location) {
          document.location.hash = "#" + location;
      }

      // function called from document.ready()
      function documentGotoActive() {
          element = document.getElementById('aktivt_element');
          if(element!=null) {
              element.scrollIntoView();
          }
      }
</script>

<?php
// parametre:
//   s   - kategori
//   p   - side nummer
//   eg  - posthylle type
//   ae  - aktiv element (html flyttes til dette element ved loading)

$userid=0;
$isadmin=0;

if (isset($_COOKIE["phorum_session_v5"])) {
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);
}

$f='admin';


include('../topmenu.php');

if(isset($_GET['s'])) {$s=$_GET['s'];} else {$s=1;}

if($s==2) { $marginleft = "20px";}  else { $marginleft = "100px"; }

?>


<div style="width: 1280px; margin-left: auto; margin-right: auto; margin-top: 55px;">
	<div style="width: 200px; font-size: 20px; font-weight: bold; display: inline-block;">Jernbane.net</div>
	<div style="width: 230px; font-size: 12px; font-weight: bold; display: inline-block;">Administrasjon</div>
	<div style="width: 555px; text-align: right; font-size: 12px; display: inline-block;"><?php echo $username; ?></div>
</div>
	<br /><br />
<div class="wide_container">	      
	<?php
	if ($isadmin == 1) {

	// Test
	// echo '<p> admin er 1. $s er ' . $s . '</>';

	if ($s==1) { include('adm_posthylla.php'); }
	if ($s==2) { include('adm_ukens.php'); }
	if ($s==3) { include('adm_tabeller.php'); }
	if ($s==4) { include('adm_gal_delete.php'); }
	if ($s==5) { include('adm_comm_adm.php'); }
	if ($s==6) { include('adm_ph_cat.php'); }
	if ($s==7) { include('adm_ph_copy.php'); }
	if ($s==8) { include('adm_log_user_create.php'); }	
	if ($s==9) { include('konklist.php'); }
	if ($s==10) { include('adm_sponsor.php'); }
	if ($s==11) { include('adm_posthylla_auto_log.php'); }
	if ($s==12) { include('adm_betingelser.php'); }
	if ($s==13) { include('adm_folder.php'); }
	if ($s==14) { include('adm_log_gdpr.php'); }
	if ($s==15) { include('adm_retext.php'); }
	if ($s==99) { include('adm_tabeller.php'); }
    if ($s==101) { include('adm_posthylla_ny.php'); }
    if ($s==106) { include('adm_ph_cat_ny.php'); }  

	} 
	else 
	{
	echo "<br /><br />&nbsp;&nbsp;&nbsp;&nbsp; You are not allowed to access this page";
	}	
	?>

</div>
<br />
<?php
include('../footer.php');
?>
<br />
</body>
</html>

