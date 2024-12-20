<?php

function toFraction($number){ 
    $numerator = 1; 
    $denominator = 0; 
    for(; $numerator < 8000; $numerator++){ 
        $temp = $numerator / $number; 
        if(ceil($temp) - $temp == 0){ 
            $denominator = $temp; 
            break; 
        } 
    } 
    return ($denominator > 0) ? $numerator . '/' . $denominator : false; 
}  

function toDecimal($in){
    $length = strlen($in);
	$slashpos = strpos($in,'/');
	$left = substr($in,0,$slashpos);
	$right = substr($in,$slashpos+1,$length);
	$decimal = $left/$right;
	if ($decimal < 1) {$out = toFraction($decimal);}
	else {$out = $decimal;}
    return ($out); 
}  

function calcExposure($eexposuretime){
	$length = strlen($eexposuretime);
	$slashpos = strpos($eexposuretime,'/');
	$left = substr($eexposuretime,0,$slashpos);
	$right = substr($eexposuretime,$slashpos+1,$length);
	$decimal = $left/$right;
	if ($decimal < 1) {$exp = toFraction($decimal);}
	else {$exp = $decimal;}
    return ($exp);
}

//position-functions
function getGps($exifCoord, $hemi) {
    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;
    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}
function gps2Num($coordPart) {
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}
// end position

?>