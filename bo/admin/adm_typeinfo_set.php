<?php
include ('configi.php');

include ('../info_utils.php');

if(isset($_POST['land'])) { $land = $_POST['land']; } else { $land = 0; }
if(isset($_POST['cat'])) { $cat = $_POST['cat']; } else { $cat = 0; }
if(isset($_POST['type'])) { $type = $_POST['type']; } else { $type = 0; }

if(isset($_POST['infotypeid'])) { $infotypeid = $_POST['infotypeid']; } else { $infotypeid=NULL; }
if(isset($_POST['typeinfo'])) { $typeinfo = $_POST['typeinfo']; } else { $typeinfo=NULL; }


//echo "Mottok: land=".$land." cat=".$cat." type=".$type." infotypeid=".$infotypeid." typeinfo=<xmp>".$typeinfo."</xmp><br>";

try {
    
    if(isset($infotypeid) && isset($typeinfo)) {
        $query ="SELECT infostruct FROM `gal_type` WHERE typeid = '$type'";
        $result = $db->query($query);
        if($result && ($obj = $result->fetch_object()) ) {
            $dbinfostruct = $obj->infostruct;
        }
        $infostruct = getInfoFromDbString($dbinfostruct);
        //echo "database infostruct=<xmp>".$infostruct."</xmp><br>";
        $ni = JSONToInfo($typeinfo);
        //echo "<br>decoded typeinfo=".var_dump($ni)."<br>";
        if(isset($ni)) {
            $infostruct[$infotypeid] = $ni;
            $newinfo = infoToEscapedDbString($infostruct);
            if(isset($newinfo)) {
                //echo "lagrer info=<xmp>".$newinfo."</xmp><br>";
                $query = "update gal_type set infostruct = '$newinfo' where typeid = '$type'";
                //$query = "replace into gal_type set infostruct = '$newinfo' where typeid = '$type'";
                //echo $query."<br>";
                $result = mysqli_query($db, $query);
                //echo "result = "; var_dump($result);
                
                // update modify_time
                $timenow = date('U');
                $query = "update gal_type set modify_time = $timenow where typeid = '$type'"; 
                $result = mysqli_query($db, $query);

                
            } else {
                echo '<script>alert("Feil i strukturen, kan ikke lagre");</script>';
            }
        }
    }

} catch (Exception $e) {
    echo '<script>alert("Caught exception: ',  $e->getMessage(),'");</script>';
}

// gammel info
//$typeinfo = addslashes($typeinfo); 

//$query = "update gal_type set info = '$typeinfo' where typeid = '$type'";
//$result = mysqli_query($db, $query);

//echo '<script>alert("Done");</script>';

echo "<script>parent.location.href='index.php?s=3&p=4&l=".$land."&c=".$cat."&t=".$type."'</script>";
?>