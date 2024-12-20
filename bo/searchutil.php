<?php

function getarg($argname) {
    $val = "";
    if(isset($_POST[$argname])) { $val = $_POST[$argname]; } else { $val = ""; }
    if(isset($_GET[$argname]))  { $val = $_GET[$argname]; }
    return $val;
    
}

// splitt parameterstreng inn i komponenter og ta hensyn til "" og \" (escapede kommentartegn)
function split_parameter_string($param) {
    if(!$param) {
        return array();
    }
    trim($param);
    if(strlen($param)==0) {
        return array();
    }
    $matches = NULL;
    preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $param, $matches);
    //print("splitted string '".$param."' ---- ");
    //print_r($matches);
    $result = array();
    $i=0;
    foreach($matches[0] as $m) {
        $nq =  preg_replace('/(^(\\")|((?<!\\\\)\\")$)/', '', $m); // fjern "" hvis de finnes
        global $db;
        $result[$i] = $db->real_escape_string($nq);
        
        //print("'".$result[$i]."', ");
        $i++;
    }
    return $result;
}

?>
