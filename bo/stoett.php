<br />
<div id="bo_heading">

   <span style="font-size: 20px;"><b>Vil du støtte driften av Jernbane.Net ?</b></span>
   <img src="graphics/filler.gif" width="10px" height="23px" />
   
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<div class="bo_intro">
  <br />

<span style="font-size: 20px;"><b>Jernbane.Net i korthet! </b><br /></span>
  <p></p>
<span style="font-size: 16px;">
Helt siden <b>Jernbane.Net</b> ble startet i 1998 har nettstedet blitt drevet ved frivillig innsats på varierende nivåer.
Noen arbeider mer eller mindre daglig med teknikk, bildesortering og utvikling av galleriene.<br />
<br />

<b>Vi ønsker å gi deg en så bra opplevelse som mulig innenfor våre økonomiske begrensninger.<br />
For at vi stadig skal kunne utvikle Jernbane.Net til ett bra og holdbart galleri og forum for jernbaneinteresserte, er vi avhengig av din økonomiske støtte.</b><br />
<br />
Om du ønsker å hjelpe oss til videre utvikling av nettstedet, kan du gjøre det ved å gi et lite personlig bidrag til driften.<br />
<br />
Du kan bruke "Donasjonknappen" for å benytte VISA / PayPal eller annet bankkort.<br />
Alle donasjoner går uavkortet til driften av ditt nettsted.<br />
<br />
<span style="font-size: 20px;">
  <b>Fra og med 1 februar 2022 har Jernbane.Net innført en medlemsavgift.</b><br /></span>
  <p></p>
Medlemskap tegnes og betales når du gjør din registrering. Dette løper for ett år av gangen, fra den dato du melder deg inn.<br />
Ditt medlemskap fornyes automatisk etter 365 dager.<br />
For å melde deg inn som medlem på Jernbane.Net <a href="https://jernbane.net/forum/">går du videre til denne siden for å gjøre en ny registrering.</a> 
<br />
<center>
  <p></p>
Dersom du ønsker å gi et bidrag, men ikke ønsker å bli medlem, kan du med fordel benytte PAYPAL knappen.<br /></span>
<p></p>
<form action="https://www.paypal.com/donate" method="post" target="_top">
<input type="hidden" name="hosted_button_id" value="DDHM3649UZC74" />
<input type="image" src="https://www.paypalobjects.com/no_NO/NO/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Doner med PayPal-knappen" />
<img alt="" border="0" src="https://www.paypal.com/no_NO/i/scr/pixel.gif" width="1" height="1" />
</form>

<br />
  </center>
<span style="font-size: 16px;">
Vi setter stor pris på alle ekstra bidrag vi mottar, store eller små!<br />
Vi gleder oss ektra mye, dersom du velger medlemskap på Jernbane.Net for bli et aktivt medlem hos oss! <br />
<br />
Alle tidligere bidragsytere er presentert med navn på denne siden.<br />
Medlemslistene og framtidige bidragsytere vil være anonymisert i henhold til GDPR<br />
<br />
Hilsen oss i Jernbane.Net<br /></span>
<br />
<hr>
<br />

<span style="font-size: 20px;"><b>Disse har støttet oss gjennom årene !</b></span>
<br><b>Stort takk til dere alle for bidragene !</b> <br />

<?php

$query = "select * from misc_sponsor order by navn";
$result = $db->query($query);


$ns=0;
while ( $sponsor = $result->fetch_array() ) {
    // echo $sponsor[0]; echo " - "; echo $sponsor[1]; echo "<br />";
     $sponsorer[$ns] = $sponsor[1];
     $ns++;
     }


$var = array_count_values($sponsorer);

$out = print_r($var, true);

$out = str_replace('(','',$out);
$out = str_replace(')','',$out);
$out = str_replace('Array','',$out);
$out = str_replace('[','<li>',$out);
$out = str_replace(']','',$out);
$out = str_replace(' => 1','</li>',$out);
$out = str_replace(' => 2',', flere bidrag</li>',$out);
$out = str_replace(' => 3',', flere bidrag</li>',$out);
$out = str_replace(' => 4',', flere bidrag</li>',$out);
$out = str_replace(' => 5',', flere bidrag</li>',$out);
$out = str_replace(' => 6',', flere bidrag</li>',$out);
$out = str_replace(' => 7',', flere bidrag</li>',$out);
$out = str_replace(' => 8',', flere bidrag</li>',$out);
$out = str_replace(' => 9',', flere bidrag</li>',$out);



echo "<ul>";
echo $out;
echo "</ul>";

?>
    
<br /><br /><br /><br />


</div>
<br /><br />
