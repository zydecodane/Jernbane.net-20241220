<?php
$kgtime = microtime();
$kgtime = explode(' ', $kgtime);
$kgtime = $kgtime[1] + $kgtime[0];
$kgstart = $kgtime;
?>




<?php
$kgtime = microtime();
$kgtime = explode(' ', $kgtime);
$kgtime = $kgtime[1] + $kgtime[0];
$kgfinish = $kgtime;
$kgtotal_time = round(($kgfinish - $kgstart), 4);
echo 'Page generated in '.$kgtotal_time.' seconds.';
?>