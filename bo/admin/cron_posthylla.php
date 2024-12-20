<?php
/*
Midl. deaktiveret pfa. Ronny 17.11.2020

include ('configi.php');

$logarray = "";

$now = date('U');
$start = ($now - 432000);

$query = "select id, url, thumb, tekst, fotograf, dato, type, nummer, timestamp from gal_images where posthylla = 0 and timestamp < '$start'";
$result = $db->query($query);

while ( $phlist = $result->fetch_array() ) {
    
	$query1 = "select numid, enhet from gal_unit where numid = '$phlist[7]'";
	$result1 = $db->query($query1);
	$unit = $result1->fetch_array();
	
	$query2 = "select typeid, typename, katid from gal_type where typeid = '$phlist[6]'";
	$result2 = $db->query($query2);
	$type = $result2->fetch_array();
	        
	$query3 = "select katid, katname, natid from gal_kategori where katid = '$type[2]'";
	$result3 = $db->query($query3);
	$kat = $result3->fetch_array();
	
	$query4 = "select natid, natnavn from gal_nations where natid = '$kat[2]'";
	$result4 = $db->query($query4);
	$land = $result4->fetch_array();
	
	$check=0;        
    
    if ($land[1]!='') { $check=$check+1; }
    if ($kat[1]!='') { $check=$check+1; }
    if ($type[1]!='') { $check=$check+1; }
    if ($unit[1]!='') { $check=$check+1; }
    
    // vi eleminerer 'andre'
    
    $query6 = "select nummer from gal_images where id = '$phlist[0]'";
	$phnummer = $db->query($query6)->fetch_object()->nummer;
	
	if ($phnummer > 0) {
		$query7 = "select enhet from gal_unit where numid = '$phnummer'";	
		$phenhet = $db->query($query7)->fetch_object()->enhet;
		
		if ($phenhet == 'andre') {
			$check = $check-1;
			}		
		}
	
 
    if ( $check == 4) {  // kategorisering er gennemført -> vi gør billedet synligt i gallerierne og opdaterer gal_images 
    
	    $query5 = "update gal_images set posthylla = 1 where id='$phlist[0]'"; 
		$result5 = mysqli_query($db, $query5);
	
		$logarray .= $phlist[0].';';				
    }  
 }  
$logarray = substr($logarray, 0,-1); 
 
// skriv til logfil   

if ($logarray !="") {

$timestamp = date('U');  

$query6 = "insert into log_cron_posthylla (timestamp,img) values ('$timestamp','$logarray')"; 
$result6 = mysqli_query($db, $query6);
}
     
$db->close();


/*
?>