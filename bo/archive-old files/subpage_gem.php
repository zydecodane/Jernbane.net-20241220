<title>Jernbane.net</title><link rel="stylesheet" type="text/css" href="http://jernbane.net/phorum/css.php?0,css" media="screen" /><link rel="stylesheet" type="text/css" href="http://jernbane.net/phorum/css.php?0,css_print" media="print" /><script type="text/javascript" src="http://jernbane.net/phorum/javascript.php"></script><script type="text/javascript" src="../bo/tinybox.js"></script><link rel="alternate" type="application/rss+xml" title="RSS (tråder)" href="http://jernbane.net/phorum/feed.php?0,type=rss" /><link rel="alternate" type="application/rss+xml" title="RSS (tråder + svar)" href="http://jernbane.net/phorum/feed.php?0,replies=1,type=rss" /><meta name="description" content="POSTVOGNA er Norges eneste uavhengige diskusjonsside for jernbanevenner og kritikere! Postvogna er til for alle som har en mening om jernbane - sporvogner - busser - båter. Du må være registrert bruker og innlogget for å kunne delta aktivt i Postvogna.Ikke aktive brukerkontoer, slettes etter ca 120 dager. Postvogna ist Norwegens einziges unabhängiges Forum für Freunde und Kritiker der Eisenbahn. Postvogna ist für alle da, die etwas zum Thema Eisenbahn, Strassenbahn, Busse und Schiffe zu sagen haben. Derzeit ist es notwendig, dass Sie als registrierter Nutzer angemeldet sind, um am Forum Postvogna aktiv teilnehmen zu können. Nicht aktive Nutzerkonten werden nach Ablauf von ca. 120 Tagen gelöscht. Postvogna is the only independent forum for railway enthusiasts and critics in Norway.Welcome to all who want to contribute about railway, tramway, buses and vessels. Discussion of all aspects of railway service, locomotive workings etc. in Europe in general, and in Norway, Sweden and Denmark in particular. Currently only registered users logged in are able to participate in the Postvogna forum. Non-active user accounts will be erased after about 120 days. Før du registrerer deg på www.jernbane.net ber vi om at du leser HER Registrer deg på www.jernbane.net" /><!--[if lte IE 6]>
<style type="text/css">
#phorum {
width: expression(document.body.clientWidth > 1280
? '1280px': 'auto' );
margin-left: expression(document.body.clientWidth > 1280
? parseInt((document.body.clientWidth-1280)/2) : 0 );
}
</style>
<![endif]-->
<!--
Some Icons courtesy of:
FAMFAMFAM - http://www.famfamfam.com/lab/icons/silk/
Tango Project - http://tango-project.org/
--><link rel="stylesheet" type="text/css" href="http://www.jernbane.net/menustyle.css"></head>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="no" xml:lang="no" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
if (isset($_GET['s'])) { $subpage = $_GET['s']; }
if (isset($_POST['s'])) { $subpage = $_POST['s']; }


if (isset($_GET['u'])) { $unitid = $_GET['u']; }
if (isset($_GET['t'])) { $typeid = $_GET['t']; }
if (isset($_GET['k'])) { $katid = $_GET['k']; }
include('config.php');
if (isset($unitid)){
	$getlok=mysql_query("SELECT enhet FROM `gal_unit` WHERE numid = '$unitid'");
	$tekst=mysql_result($getlok,0);
}
if (isset($typeid)){
	$gettype=mysql_query("SELECT typename FROM gal_type WHERE typeid = '$typeid'");
	$tekst=mysql_result($gettype,0);
}
if (isset($katid)){
	$getkat=mysql_query("SELECT katname, natnavn FROM gal_kategori WHERE katid = '$katid'");
	$kat=mysql_fetch_row($getkat);
	$tekst=$kat[1].' - '.$kat[0];
}
?>
<title><?php if (isset($tekst)) { echo $tekst; echo " - "; } ?>Jernbane.net</title>


 
        <link type="text/css" href="stylesheet.css" rel="stylesheet" />
 		<link type="text/css" href="datepicker/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="datepicker/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="datepicker/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="datepicker/jquery.ui.datepicker-no.js"></script>
</head>
<body>

<?php
$f='';

//include ('config.php');


include ('topmenu.php');
//include('bo_header.php');




if ($subpage=='0')  { include('show_img.php'); }
if ($subpage=='1')  { include('gal_catlist.php'); }
if ($subpage=='2')  { include('gal_typelist.php'); }
if ($subpage=='3')  { include('gal_unitlist.php'); }
if ($subpage=='4')  { include('gal_unit.php'); }
if ($subpage=='5')  { include('gal_ukens.php'); }
if ($subpage=='6')  { include('gal_geomap.php'); }
if ($subpage=='7')  { include('gal_main.php'); }
if ($subpage=='9')  { include('gal_geomap_le.php'); }


if ($subpage=='10')  { include('regler.php'); }
if ($subpage=='11')  { include('about.php'); }
if ($subpage=='12')  { include('copyright.php'); }
if ($subpage=='13')  { include('stoett.php'); }

if ($subpage=='40')  { include('fotograf_list.php'); }
if ($subpage=='41')  { include('fotograf_result.php'); }

if ($subpage=='50')  { include('posthylla.php'); }
if ($subpage=='51')  { include('bo.php'); }
if ($subpage=='52')  { include('bo_receipt.php'); }
if ($subpage=='53')  { include('bo_geoset.php'); }

if ($subpage=='60')  { include('bo_mypics.php'); }

if ($subpage=='70')  { include('../norge/typetegninger/index.php'); }

if ($subpage=='99')  { include('page0.php'); }


if ($subpage=='999')  { include('pagesetup.php'); }

echo "<br />";

include('footer.php');
?>
</body>
</html>