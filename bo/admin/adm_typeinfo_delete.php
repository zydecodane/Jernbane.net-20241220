<?php
include ('configi.php');

include ('../info_utils.php');

if(isset($_POST['land'])) { $land = $_POST['land']; } else { $land = 0; }
if(isset($_POST['cat'])) { $cat = $_POST['cat']; } else { $cat = 0; }
if(isset($_POST['type'])) { $type = $_POST['type']; } else { $type = 0; }

if(isset($_POST['infotypeid'])) { $infotypeid = $_POST['infotypeid']; } else { $infotypeid=NULL; }

// spesielle typeinfo som godkjennes
//   ALLE_TYPEINFO   - Slett all info for spesifisert type (infostruct db felt)
//   GAMMEL_INFO     - Slett all gammel info (info db felt)

echo "Slett typeinfo mottok: land=".$land." cat=".$cat." type=".$type." infotypeid=".$infotypeid." <br>";

//$typeinfo = addslashes($typeinfo); 

try { 

    if(!isset($infotypeid)) {
        // gjoer ingenting
    } else if($infotypeid === "GAMMEL_INFO") {
        //echo '<script>alert("Sletting av gammel info ikke implementert enda");</script>';
        //$query = "update gal_type set info = '' where typeid = '$type'";
        //$result = mysqli_query($db, $query);
        $query = "update gal_type set info_deleted = 1 where typeid = '$type'";
        $result = mysqli_query($db, $query);
    } else if($infotypeid === "ALLE_TYPEINFO") {
        //echo '<script>alert("Sletting av all info ikke implementert enda");</script>';
        $query = "update gal_type set infostruct = '' where typeid = '$type'";
        $result = mysqli_query($db, $query);    
    } else {
        $query ="SELECT infostruct FROM `gal_type` WHERE typeid = '$type'";
        $result = $db->query($query);
        if($result && ($obj = $result->fetch_object()) ) {
            $dbinfostruct = $obj->infostruct;
        }
        echo "leste fra db: $dbinfostruct <br>";
        $infostruct = getInfoFromDbString($dbinfostruct);
        unset($infostruct[$infotypeid]);
        $newinfo = infoToEscapedDbString($infostruct);
        echo "lagrer info=<xmp>".$newinfo."</xmp><br>";
        $query = "update gal_type set infostruct = '$newinfo' where typeid = '$type'";
        $result = mysqli_query($db, $query);

    }
    
    // update modify_time
    $timenow = date('U');
    $query = "update gal_type set modify_time = $timenow where typeid = '$type'"; 
    $result = mysqli_query($db, $query);

} catch (Exception $e) {
    echo '<script>alert("Caught exception: ',  $e->getMessage(),'");</script>';
}

//echo '<script>alert("Done");</script>';
echo "<script>parent.location.href='index.php?s=3&p=4&l=".$land."&c=".$cat."&t=".$type."'</script>";
?>

