<?php

function infoToJSON($info) {
    return json_encode($info);//,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT);//|JSON_HEX_AMP);
}

function infoToDbString($info) {
    return infoToJSON($info);
}

// bruk denne for aa lagre i databasen
function infoToEscapedDbString($info) {
    $newinfo = infoToDbString($info);
    if(isset($newinfo)) {
        if(function_exists('mysqli_real_escape_string')) {
            global $db;
            $newinfo = mysqli_real_escape_string ($db, $newinfo);
            //$newinfo = $db->real_escape_string ($newinfo);
        } else if(function_exists('mysql_real_escape_string')){
            $newinfo = mysql_real_escape_string ($newinfo);
            if(!bool($newinfo)) {
                $newinfo = NULL;
            }
        } else {
            echo '<script>alert("Finner ingen mysql string escape funksjon");</script>';
            $newinfo = NULL;
        }
    
       //$newinfo = mysql_real_escape_string ($newinfo); // deprecated, replace with mysqli_real_escape_string
       //$newinfo = mysqli_real_escape_string ($db,$newinfo);
       return $newinfo;
    }
    return NULL;
}

//
// return NULL hvis det ikke er en OK JSON streng med innhold 
function JSONToInfo($jsonstring) {
    if(!isset($jsonstring) || empty($jsonstring)) {
        return NULL;
    }
    $i = json_decode($jsonstring,true);
    if(isset($i) ) { //&& is_array($i)) {   // alle infostruct (og infostruct deler) er arrays
        return $i;
    }
    /*
    $err = json_last_error_msg();
    if($err !== "No Error" ) {
        //echo 'alert("JSON decode error: '.$err.'");<br>';
    }*/
    return NULL;
}

// returns tomt array hvis JSON strengen er ikke OK
// for bruk med hel infostruct
function getInfoFromDbString($dbstring) {
    $infostruct = array();
    $i = JSONToInfo($dbstring);
    if(isset($i) ) { //&& is_array($i) ) {
        $infostruct = $i;
    }
    return $infostruct;
}

?>
