<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


include('../admin/configi.php');
$query = "select search_text from phorum_search where forum_id = 11 ";
$result = $db->query($query);
$f=0; $m=0;
while ( $fliste = $result->fetch_array() ) {
    $forumtext[$f] = $fliste[0]; 
    $f++;
     } 
     
for ($n = 0 ; $n<$f ; $n++)
{
	$needle = "[img]";
	$lastPos = 0;
	$positions = array();
	
	while (($lastPos = strpos($forumtext[$n], $needle, $lastPos))!== false) {
	    $positions[] = $lastPos;
	    $lastPos = $lastPos + strlen($needle);
	}

foreach ($positions as $istart) {
	$islut = strpos($forumtext[$n],'[/img]',$istart);	
	$istreng[$m] = substr($forumtext[$n],($istart+5),($islut-$istart-5));
	$m++;
	}
}

// ------------------------------
$l=0;

/*
for ($n = 0 ; $n<$m ; $n++)
{
	
	//echo $istreng[$n]; echo "<br />";
	
	
	$query2 = "select url, thumb, sum(poeng) as sumpoeng, sum(stemmer) as sumstememr from gal_images where url = '$istreng[$n]' group by url";
	$result2 = $db->query($query2);
	while ( $img = $result2->fetch_array() ) {
			
        $url1[$l] = $img[0];	
		$l++;
    //	echo $img[0]; echo " - "; echo $img[2]; echo " - "; echo $img[3]; echo "<br />";
     } 		
	
}

*/

echo "<br />";
echo $l;

// -----------------------

echo "<hr />";


$k=0;
$query1 = "select typeid from gal_type where katid = 1018";
		$result1 = $db->query($query1);
		while ( $img1 = $result1->fetch_array() ) {
                  
                  $typeid[$k] = $img1[0];
                  $k++;
  }
  
  








$p=0;
for ($n = 0 ; $n<$k ; $n++)
{
$query2 = "select url, id, thumb, sum(poeng) as sumpoeng, sum(stemmer) as sumstememr, type, fotograf from gal_images where type = '$typeid[$n]' group by url";
	$result2 = $db->query($query2);
	while ( $img2 = $result2->fetch_array() ) {

        

        echo '$img['.$n.'] = "'.$img2[0].'";<br/>';
        
        
        
        //$query4 = "insert into misc_konkurranse (imgid, thumb, poeng, stemmer, fotograf) values ('$img2[1]', '$img2[2]', '$img2[3]', '$img2[4]','$img2[6]')"; 
		// $result4 = mysqli_query($db, $query4);
        
        
        
        
        
        
        
        
        
        $p++;
     }


}

echo "<br />"; echo $p;




for ($a = 0 ; $a<$l ; $a++) {
  
 // echo '"';;echo $url1[$a]; echo '";"'; echo $url2[$a]; echo '"<br />';






}








?>