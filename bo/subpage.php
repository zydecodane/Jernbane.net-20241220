<?php
if( isset( $_COOKIE['first'])) { 
	$first = 0;
	}
else {
	$first = 1;
	@setcookie('first', '1', time() + 60, "/");
	$_COOKIE['first'] = 1;
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta name="viewport" content="width=device-width, initial-scale=0.8">
<html>
<head>
<?php
if (isset($_GET['s'])) { $subpage = $_GET['s']; }
if (isset($_POST['s'])) { $subpage = $_POST['s']; }

if (isset($_GET['u'])) { $unitid = $_GET['u']; }
if (isset($_GET['t'])) { $typeid = $_GET['t']; }
if (isset($_GET['k'])) { $katid = $_GET['k']; }
if (isset($_GET['l'])) { $natid = $_GET['l']; }

include('configi.php');

if (isset($unitid)){
	$query7 = "select enhet, typeid from gal_unit where numid = '$unitid'";
	$renhet7 = $db->query($query7)->fetch_object()->enhet;
	$rtype7 = $db->query($query7)->fetch_object()->typeid;

	$query8 = "select typename, katid from gal_type where typeid = '$rtype7'";
	$rtype8 = $db->query($query8)->fetch_object()->typename;
	$rkat8 = $db->query($query8)->fetch_object()->katid;
	
	$query9 = "select katname, natnavn from gal_kategori where katid = '$rkat8'";
	$rnat9 = $db->query($query9)->fetch_object()->natnavn;
	$rtypenavn9 = $db->query($query9)->fetch_object()->katname;

	$flitekst = $rnat9.' -> '.$rtypenavn9.' -> '.$rtype8.' -> '.$renhet7;
}
if (isset($typeid)){
	$query8 = "select typename, katid from gal_type where typeid = '$typeid'";
	$rtype8 = $db->query($query8)->fetch_object()->typename;
	$rkat8 = $db->query($query8)->fetch_object()->katid;
	
	$query9 = "select katname, natnavn from gal_kategori where katid = '$rkat8'";
	$rnat9 = $db->query($query9)->fetch_object()->natnavn;
	$rtypenavn9 = $db->query($query9)->fetch_object()->katname;
	
	$flitekst = $rnat9.' -> '.$rtypenavn9.' -> '.$rtype8;	
}
if (isset($katid)){
	$query9 = "select katname, natnavn from gal_kategori where katid = '$katid'";
	$rnat9 = $db->query($query9)->fetch_object()->natnavn;
	$rtypenavn9 = $db->query($query9)->fetch_object()->katname;
	
	$flitekst = $rnat9.' -> '.$rtypenavn9;
}
if (isset($natid)){
	$query9 = "select natnavn from gal_nations where natid = '$natid'";
	@$rnat9 = $db->query($query9)->fetch_object()->natnavn;
	
	$flitekst = $rnat9;
}
?>
<title><?php if (isset($flitekst)) { echo $flitekst; echo " &#124; "; } ?>Jernbane.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link type="text/css" href="stylesheet.css?v=357" rel="stylesheet" />
 		<link type="text/css" href="datepicker/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
</head>
<body>
<?php
    /*
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1&appId=233382680033778";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    */
?>    
    
<?php
$f='';
//include ('config.php');
?>
<div class="mobile">
<?php
include('../bo/topmenu.php');
?>
</div>
<div id="mobile_top">
	<?php include('../bo/mobiltop.php'); 
	?>
</div>
<?php
//include ('topmenu.php');
//include('bo_header.php');
?>
<div style="width: 100%; height: 52px;">
</div>
<?php

if ($subpage=='0')  { include('show_img.php'); }
if ($subpage=='1')  { include('gal_catlist.php'); }
if ($subpage=='2')  { include('gal_typelist.php'); }
if ($subpage=='3')  { include('gal_unitlist.php'); }
if ($subpage=='4')  { include('gal_unit.php'); }
if ($subpage=='5')  { include('gal_ukens.php'); }
if ($subpage=='6')  { include('gal_geomap.php'); }
if ($subpage=='7')  { include('gal_main.php'); }
if ($subpage=='8')  { include('gal_unitdetail.php'); }
if ($subpage=='9')  { include('gal_geomap_le.php'); }


if ($subpage=='10')  { include('regler.php'); }
if ($subpage=='11')  { include('about.php'); }
if ($subpage=='12')  { include('copyright.php'); }
if ($subpage=='13')  { include('stoett.php'); }

if ($subpage=='14')  { include('img_search.php'); }
if ($subpage=='15')  { include('do_img_search.php'); }
if ($subpage=='16')  { include('regler1.php'); }
if ($subpage=='17')  { include('gal_tidl_dagens.php'); }

if ($subpage=='20')  { include('../norge/typetegninger/index.php'); }
if ($subpage=='21')  { include('gal_europa.php'); }

if ($subpage=='40')  { include('fotograf_list.php'); }
if ($subpage=='41')  { include('fotograf_result.php'); }

if ($subpage=='42')  { include('top100.php'); }

if ($subpage=='50')  { include('posthylla_ny.php'); }
if ($subpage=='51')  { include('bo_temp.php'); }
if ($subpage=='52')  { include('bo_receipt.php'); }
if ($subpage=='53')  { include('bo_geoset.php'); }

if ($subpage=='54')  { include('bo_simple.php'); }
if ($subpage=='55')  { include('bo_old.php'); }
if ($subpage=='56')  { include('openrailwaymap_frame.php'); }
    
if ($subpage=='60')  { include('bo_mypics.php'); }
if ($subpage=='61')  { include('bo2.php'); }

if ($subpage=='65')  { include('konklist.php'); }
if ($subpage=='70')  { include('../norge/typetegninger/index.php'); }
if ($subpage=='99')  { include('page0.php'); }
if ($subpage=='100')  { include('startside.php'); }
if ($subpage=='200')  { include('frontpage.php'); }
if ($subpage=='999')  { include('pagesetup.php'); }
?>

<?php
include('footer.php');
?>
</body>
</html>