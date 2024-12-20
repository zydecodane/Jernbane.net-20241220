<html>

<body style="background: #ffffff !important;">
<?php


@$id = $_GET['id'];

$ugedag=array('Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag');

$xml = '<REQUEST>
      <LOGIN authenticationkey="2586c35eb583414abe50c2c386916f10" />
      <QUERY objecttype="TrainMessage">
      	<INCLUDE>ExternalDescription</INCLUDE>
      	<INCLUDE>ReasonCodeText</INCLUDE>
      	<INCLUDE>ModifiedTime</INCLUDE>
            <FILTER>
            	<EXISTS name="ExternalDescription" value="true" />
            </FILTER>
      </QUERY>
      
      2016-01-15T08:20:02
</REQUEST>';

// $xml = file_get_contents('data.xml');
$URL = 'http://api.trafikinfo.trafikverket.se/v1.1/data.xml';

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
  
$p = xml_parser_create();
xml_parse_into_struct($p, $output, $vals, $index);
xml_parser_free($p); 
 
$n = count ($index['EXTERNALDESCRIPTION']);

for ($b = 0 ; $b<$n ; $b++) {
	$messageid[$b] = $index['EXTERNALDESCRIPTION'][$b];
	$reasonid[$b] = $index['REASONCODETEXT'][$b];
	$datoid[$b] = $index['MODIFIEDTIME'][$b];
	}
	
for ($c = 0 ; $c<$n ; $c++) {
	$message[$c] = $vals[$messageid[$c]]['value']; 
	$reason[$c] = $vals[$reasonid[$c]]['value'];
	$dato[$c] = $vals[$datoid[$c]]['value'];
	}

	$unixday[$id] = mktime(substr($dato[$id],11,2), substr($dato[$id],14,2), substr($dato[$id],17,2), substr($dato[$id],5,2), substr($dato[$id],8,2), substr($dato[$id],0,4)); ?>
<div style="margin: 40px; font-size: 14px; color: #000000;">	
	<b><?php echo ucfirst($reason[$id]).'</b><br /><br />'.$message[$id]; ?></a>
	<br />
	<br />
	<small style="line-height: 16px;"><?php echo $ugedag[date('w',$unixday[$id])].", ".date('d.m.Y - H:i:s',$unixday[$id]); ?></small><br>
</div>
<div style="margin-left: 40px; margin-top: 200px;">
<form action="index.php">
<input type="submit" value="OK">
</form>
</div>

</body>
</html>

