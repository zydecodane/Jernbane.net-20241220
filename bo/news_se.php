<?php

/*  --- herfra

// LOGIN authenticationkey='2586c35eb583414abe50c2c386916f10' 
// http://api.trafikinfo.trafikverket.se/v1.1/data.xml
// http://api.trafikinfo.trafikverket.se/v1.1/data.xml';

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

mb_internal_encoding("UTF-8");
	
for ($c = 0 ; $c<$n ; $c++) {
	$message[$c] = $vals[$messageid[$c]]['value']; 
	$reason[$c] = $vals[$reasonid[$c]]['value'];
	$dato[$c] = $vals[$datoid[$c]]['value'];
	$disp_mess[$c] = mb_substr($vals[$messageid[$c]]['value'],0,130).'...';
	}

@array_multisort($dato,$reason,$message);



<div class="description_header">
 Trafikinformation fra Trafikverket (SE)
</div>
<div class="description_content">
<?php
/*
for($d=$n-1; $d>=$n-5; $d=$d-1) {
	$unixday[$d] = mktime(substr($dato[$d],11,2), substr($dato[$d],14,2), substr($dato[$d],17,2), substr($dato[$d],5,2), substr($dato[$d],8,2), substr($dato[$d],0,4)); ?>
	<a href="#" class="gal" onclick="TINY.box.show({url:'../bo/news_se_detail.php?id=<?php echo $d; ?>',width:800,height:410,opacity:40,close:1})" style="cursor:pointer"><?php echo ucfirst($reason[$d]).' - '.$disp_mess[$d]; ?></a>
	<br />
	<small style="line-height: 16px;"><?php echo $ugedag[date('w',$unixday[$d])].", ".date('d.m.Y - H:i:s',$unixday[$d]); ?></small><br>
<?php } 

ingen informasjon for øyeblikket
</div>

*/
?>





