<?php
include('configi.php');

include('searchutil.php');

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$kat = getarg('kat');

$MAX_RESULTAT = 100;

//echo "kategori: ".$kat."<br/>";

//$kv = explode(" ", $kat );
$kv = split_parameter_string($kat);
$wherepar = "";
foreach($kv as $v) {
    if(strlen($wherepar)>0)
        $wherepar.= " AND ";
        
    $wherepar.= "((katname LIKE '%$v%') OR (natnavn LIKE '%$v%'))";
}

//echo "wherepar: ".$wherepar."<br/>";

if(strlen($wherepar) > 0 ) {
   $query = "select katname, natnavn from gal_kategori WHERE $wherepar";
   $result = $db->query($query);
   if($result) {
        $count = 0;
        while ( $res = $result->fetch_array() ) {
            if($count<$MAX_RESULTAT) {
                echo $res[0]." - ".$res[1]."<br/>";
            } else {
                break;
            }
            $count++;
        }
        $result->free();
   }
}
?>
