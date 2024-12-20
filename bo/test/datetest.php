<?php
$date1 = '17.01.2015';

$dd = substr($date1,0,2);
$dm = substr($date1,3,2);
$dy = substr($date1,6,4);

echo $dd; echo " - ";
echo $dm; echo " - ";
echo $dy; 

echo "<br />";
$udate = mktime(12, 0, 0, $dm, $dd, $dy);


echo $udate;
?>