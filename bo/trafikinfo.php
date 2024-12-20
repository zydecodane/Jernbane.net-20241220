<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>File Upload</title>
    <style type="text/css">
    html, body {
        margin:0;
        padding:0;
        display:table;
    }
    </style>
    <script type="text/javascript">
    window.onload = function()
    {
        parent.document.getElementById('fileUploadIframe').style.height = document.body.clientHeight+5+'px';
        parent.document.getElementById('fileUploadIframe').style.width = document.body.clientWidth+18+'px';
    };
    </script>
</head>
<body>
<!-- Norge -->
<?php

// check if website is up - funktion
function url_test( $url ) {
  $timeout = 1;
  $ch = curl_init();
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
  $http_respond = curl_exec($ch);
  $http_respond = trim( strip_tags( $http_respond ) );
  $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
  if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
    return true;
  } else {
    // return $http_code;, possible too
    return false;
  }
  curl_close( $ch );
}

$ugedag=array('Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag');	
?>

<style>
	.description_header {
		font-family: Arial;
		font-size: 11pt;	
		font-weight: bold;
	}
	.description_content {
		font-family: Arial;
		font-size: 11pt;
	}	
	a:visited { color: #800000;  text-decoration: underline; }
	a:active { color: #800000;  text-decoration: underline; }
	a:link	{ color: #800000;  text-decoration: underline; }
	a:hover	{ color: #800000;  text-decoration: underline; } 	
</style>
<div class="description_header">
 Trafikkmeldinger fra Bane NOR (NO)
</div>
<div class="description_content">
<?php
// check if banenor is up
$website = "https://www.banenor.no";
if( !url_test( $website ) ) {
  echo "Ingen data fra Bane NOR for øyeblikket";
}
else { 

$url = "https://www.banenor.no/trafikkmeldinger/?rss=true";
//$url = "http://www.banenor.no/Nyheter/Trafikkmeldinger/?rss=true";
$xml = simplexml_load_file($url);

$n=count($xml->channel->item);

if ($n > 5) { $til = 8;} else { $til = $n; }
for ($m = 0 ; $m<$n ; $m++)
{ 
// <?php echo $xml->channel->item[$m]->guid; ?>

	<a href="https://www.banenor.no/trafikkmeldinger" target="_blank"><?php echo $xml->channel->item[$m]->title; ?></a>
	<br />
	<?php $timestamp = strtotime($xml->channel->item[$m]->pubDate); ?>
	<small style="line-height: 16px;"><?php echo $ugedag[date('w',$timestamp)].", ".date('d.m.Y - H:i:s',$timestamp); ?><br /></small>	
<?php } 

}
?>	
</div>
<!-- Danmark -->
<br />
<div class="description_header">
 Trafikinformation fra DSB (DK)
</div>
<div class="description_content">
<?php
// check if DSB is up

$website = "https://www.dsb.dk";
if( !url_test( $website ) ) {
  echo "Ingen data fra DSB for øyeblikket";
}
else { 

$url = "http://www.dsb.dk/rss-feeds/samlet-trafikinformation";
$xml = simplexml_load_file($url);
$n=count($xml->channel->item);

$l=0;
for ($m = 0 ; $m<$n ; $m++)
{ 
	$titel[$l] = $xml->channel->item[$m]->title;
	$dato[$l] = strtotime($xml->channel->item[$m]->pubDate);
	$link[$l] = $xml->channel->item[$m]->guid;
	$l++;
}

array_multisort($dato,$titel,$link);

for($m=$l-1; $m>$n-5; $m=$m-1)
{ ?>
		<a href="<?php echo $link[$m]; ?>" target="_blank"><?php echo $titel[$m]; ?></a>
		<br />
		<?php $timestamp = $dato[$m]; ?>
		<small style="line-height: 16px;"><?php echo $ugedag[date('w',$timestamp)].", ".date('d.m.Y - H:i:s',$timestamp); ?><br /></small>
<?php } 
}	
?>
</div>
<br />
<div class="description_header">
 Trafikinformation från Trafikverket (SE)
</div>
<div class="description_content">
<?php
// LOGIN authenticationkey='2586c35eb583414abe50c2c386916f10' 

$ugedag=array('Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag');

$xml = '<REQUEST>
  <LOGIN authenticationkey="2586c35eb583414abe50c2c386916f10" />
  <QUERY objecttype="TrainMessage" schemaversion="1.7">
    <INCLUDE>Header</INCLUDE>
    <INCLUDE>LastUpdateDateTime</INCLUDE>
    <INCLUDE>ExternalDescription</INCLUDE>
  </QUERY>
</REQUEST>';

$URL = 'https://api.trafikinfo.trafikverket.se/v2/data.xml';

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($output);
$con = json_encode($xml);
// Convert into associative array
$arr = json_decode($con, true);
  
for ($n = 0 ; $n<sizeof($arr['RESULT']['TrainMessage']) ; $n++) {
	$datetime[$n] = $arr['RESULT']['TrainMessage'][$n]['LastUpdateDateTime'];
	$header[$n] = $arr['RESULT']['TrainMessage'][$n]['Header'];
	$message[$n] = $arr['RESULT']['TrainMessage'][$n]['ExternalDescription'];
	$disp_mess[$n] = mb_substr($message[$n],0,100).'...';
} 
  
for($d=$n-1; $d>=$n-4; $d=$d-1) {
	$unixday[$d] = mktime(substr($datetime[$d],11,2), substr($datetime[$d],14,2), substr($datetime[$d],17,2), substr($datetime[$d],5,2), substr($datetime[$d],8,2), substr($datetime[$d],0,4)); ?>
	<a href="https://trafikverket.se" class="gal" target="_blank" alt="<?php echo $message[$d]; ?>" title="<?php echo $message[$d]; ?>"><?php echo $header[$d].' - '.ucfirst($disp_mess[$d]); ?></a>
	<br />
	<small style="line-height: 16px;"><?php echo $ugedag[date('w',$unixday[$d])].", ".date('d.m.Y - H:i:s',$unixday[$d]); ?></small><br>
<?php }
if ($n == 0) {
?>
ingen informasjon for øyeblikket
</div>
<?php
}
?>
</div>
</body>
</html>