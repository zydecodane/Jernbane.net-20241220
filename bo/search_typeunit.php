<?php
include('configi.php');

include('searchutil.php');

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$tu = getarg('tu');

$MAX_RESULTAT = 30;

//echo "typeunit: ".$tu."<br/>";

//$tuv = explode(" ", $tu );
$tuv = split_parameter_string($tu);

//$wherepar = "";
$wherepartype = "";
$whereparunit = "";
foreach($tuv as $v) {
    if(strlen($v)<=0) {
        continue;
    }
//    if(strlen($wherepar)>0)
//        $wherepar.= " AND ";    
//    $wherepar.= "((gal_type.typename LIKE '%$v%') OR (gal_unit.enhet LIKE '%$v%'))"; // fungerer ikke
    
    if(strlen($wherepartype)>0)
        $wherepartype.= " AND ";    
    $wherepartype.= "(gal_type.typename LIKE '%$v%')";

    if(strlen($whereparunit)>0)
        $whereparunit.= " AND ";    
    $whereparunit.= "(gal_unit.enhet LIKE '%$v%')";
}

if(strlen($wherepartype) > 0 ) {
   $skiptype =  "and typename <>'Ute av bruk for tilfellet'";

   $query = "select typename FROM gal_type WHERE $wherepartype $skiptype";
   $result_t = $db->query($query);
}

if(strlen($whereparunit) > 0 ) {
   $query = "select enhet FROM gal_unit WHERE $whereparunit";
   $result_u = $db->query($query);  
}

$nrest = 0;
$nresu = 0;
if(isset($result_t)) $nrest = $result_t->num_rows;
if(isset($result_u)) $nresu = $result_u->num_rows;

if(($nrest+$nresu) > $MAX_RESULTAT) {
    $M2 = $MAX_RESULTAT/2;
    if($nrest>$M2) {
        $nrest = $nresu>=$M2 ? $M2 : $MAX_RESULTAT-$nresu;
    }
    if($nresu>$M2) {
        $nresu = $nrest>=$M2 ? $M2 : $MAX_RESULTAT-$nrest;
    }
}


//echo "nres t=".$nrest." u=".$nresu."<br/>";


for($i=0; $i<$nrest; $i++) {
     $res = $result_t->fetch_array();
     if(isset($res)) {
         echo $res[0]."<br/>";
     }
}

for($i=0; $i<$nresu; $i++) {
     $res = $result_u->fetch_array();
     if(isset($res)) {
         echo $res[0]."<br/>";
     }
}

if($result_t) $result_t->free();
if($result_u) $result_u->free();


/* fungerer ikke, db join f*ed up
if(strlen($wherepar) > 0 ) {
   $query = "select gal_type.typename, gal_unit.enhet FROM gal_type, gal_unit WHERE $wherepar";
   $result = $db->query($query);

   $count = 0;
   while ( $res = $result->fetch_array() ) {
       echo "res[0] ".$res[0]."<br/>";
       echo "res[1] ".$res[1]."<br/>";
       if($count>=$MAX_RESULTAT) {         
           break;
       }

       
       if($count<$MAX_RESULTAT) {
           echo $res[0]." - ".$res[1]."<br/>";
       } else {
           break;
       }
       $count++;
   }

}
*/

?>
