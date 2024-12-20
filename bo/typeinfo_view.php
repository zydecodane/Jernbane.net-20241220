<?php
// variable used to correct include paths and image links when script used from admin directory
$relativepath = ''; 

$cwd =  getcwd();
if(preg_match("@bo/admin$@", $cwd)) {
    $relativepath = '../';
}
?>

<link href="<?php echo $relativepath;?>typeinfo.css" rel="stylesheet"/>

<?php

class TypeInfoViewSettings {
    var $gal_width;
    var $full_width;
    var $vertimglist_width;
    var $horimglist_width;
    var $narrow_width;


    function TypeInfoViewSettings() {
        $this->gal_width = 940;
        $this->full_width = $this->gal_width - 20;
        $this->vertimglist_width = floor($this->gal_width/3) - 10;
        $this->horimglist_width = $this->full_width;
        $this->narrow_width = $this->full_width - $this->vertimglist_width - 10;
    }
}

$viewSettings = new TypeInfoViewSettings;

  //printf('  <link rel="stylesheet" type="text/css" href="typeinfo_css.php?_width=%d," />',$gal_width);

// lag visualisering for type info

include_once ($relativepath.'info_utils.php');

// size of various info view parts in pixels
//Tilgjengelige info typer
//  spectable   - Tabell med spesifikasjoner
//  tekntegn    - liste av tekniske tegninger
//  infobilder  - liste av informasjonsbilder
//  beskrivelse - Tekstlig beskrivelse 
//  historikk   - Tekstlig historikk 
//  designhist  - Liste med design bilder 
//  bildeserie  - Liste med brukerdefinert bildeserie 
//  divbilder   - Liste av diverse bilder 
//  diverse     - Tekst med diverse info
//  relsider    - Liste med linker til relaterte sider

/*
 * $dbinfostruct - info struktur streng fra database
 * $dbinfo - alternativ gammel html info streng fra database
 */
function dbTypeInfoToHtml($dbinfostruct,$oldinfo = NULL ) {
    //echo "<xmp>$dbinfostruct</xmp><br>";
    if(isset($dbinfostruct) && strlen($dbinfostruct)>0) {
        $infostruct = getInfoFromDbString($dbinfostruct);
        $ret = infostructToHtml($infostruct,false);
        $ret .= "\n";
        $ret .= infostructToHtml($infostruct,true);
        $ret .= "\n";
        
        global $relativepath;
        if(strlen($relativepath) > 0 ) {
            $ret = correctRelativeLinks($ret);
            /*
            $ret .= correctRelativeLinks('<a href="a.html">link 1</a><a href="https:b.html">link 2</a><a href="http:/a.html">link 3</a>'
                    . '<a href="/a.html">link 4</a><a href="ftp://t.com/a.html">link 5</a><a href="ftp:a.html">link 6</a>'
                    . '<a href="../a.html">link 7</a><a href="http://t.com/web">link 8</a><a href="http:web">link 9</a><a href=\'ftp://t.com/a.html\'>link 13</a>'
                    . '<a href="web">link 10</a><a href="web/">link 11</a><a href="web/g.html">link 12</a><a href=\'web/g.html\'>link 12</a>'
                    . '<img src="../j.jpg" ></img><img src="./j.jpg" ></img><img src="j.jpg" ></img><img src="/j.jpg" ></img>'
                    . '<img src="http:j.jpg" ></img><img src="http:/j.jpg" ></img>  ');
            */
        }
        
        return $ret;
    } 
    
    if(isset($oldinfo)) {
        // bruker gammel html info tekst
        return $oldinfo;
    }
    return "";
}

//
// Helperfuncs
//

function correctRelativeLinks($htmltext) {
    global $relativepath;
    if(strlen($relativepath) == 0) {
        return $htmltext;
    }
    $ret = preg_replace('@\b(src|href)\s*=\s*("|\')([A-Za-z]+:|)(\.\./|\./|[\w]+[\./]|[\w]+(?="|\'))@', '${1}=${2}${3}'.$relativepath.'${4}', $htmltext);
    return $ret;
}

function hasInfotype(&$info,$type) {
    return array_key_exists($type, $info);
}
        
function infostructToHtml(&$info,$mobilever) {
    if($mobilever) {
        return infostructMobileHtml($info);
    } else {
        return infostructPCHtml($info);
    }
}

function infostructMobileHtml(&$info) {
    global $viewSettings;
    
    if(empty($info)) {
        return "";
    }
    
    $ret = "";
    
    $has_infobilder = hasInfotype($info, "infobilder");
    $has_beskrivelse = hasInfotype($info, "beskrivelse");
    $has_historikk = hasInfotype($info, "historikk");
    $has_tekntegn = hasInfotype($info, "tekntegn");
    $has_spectable = hasInfotype($info, "spectable");
    $has_diverse = hasInfotype($info, "diverse");
    $has_relsider = hasInfotype($info, "relsider");
    $has_designhist = hasInfotype($info, "designhist");
    $has_bildeserie = hasInfotype($info, "bildeserie");
    $has_divbilder = hasInfotype($info, "divbilder");
        
    $ret .= '<div class="mobile_show">';

    
    if($has_infobilder ) {
        $ret .= '<div class="mobile_info_block" >'.intoToVerticalImageTable($info["infobilder"], true).'</div>';
        $ret .= "\n";
    }

    if($has_beskrivelse ) {
        $ret .= '<div class="mobile_info_block">'.infoToHTMLText($info["beskrivelse"]).'</div>';
        $ret .= "\n";
    }
    
    if($has_historikk ) {
        $ret .= '<div class="mobile_info_block" >'.infoToHTMLText($info["historikk"]).'</div>';
        $ret .= "\n";
    }

    if($has_tekntegn ) {
        $ret .= '<div class="mobile_info_block" >'.intoToVerticalImageTable($info["tekntegn"], true).'</div>';
        $ret .= "\n";
    }

    if($has_spectable ) {
        $ret .= '<div class="mobile_info_block">'.infoToHTMLTable($info["spectable"],"100%").'</div>';
        $ret .= "\n";
    }

    if($has_diverse) {
        $ret .= '<div class="mobile_info_block" align="left">'.infoToHTMLText($info["diverse"],false).'</div>';
        $ret .= "\n";
    }

    if($has_relsider ) {
        $ret .= '<div class="mobile_info_block"><center>'.infoToRelatedPages($info["relsider"], "100%").'</center></div>';
        $ret .= "\n";
    }

    if($has_designhist ) {
        $ret .= '<div class="mobile_info_block" style="clear:both;" >'.infoToPictureList($info["designhist"],true).'</div>';
        $ret .= "\n";
    }

    if($has_bildeserie) {
        $ret .= '<div class="mobile_info_block" style="clear:left;" >'.infoToPictureList($info["bildeserie"],true).'</div>';
        $ret .= "\n";
    }
    if($has_divbilder) {
        $ret .= '<div class="mobile_info_block" style="clear:left;" >'.infoToFullImgList($info["divbilder"]).'</div>';
    }
    
    $ret .= '</div>';
    
    return $ret;
}

function infostructPCHtml(&$info) {
    global $viewSettings;
    
    if(empty($info)) {
        return "";
    }
    
    $ret = "";

    $has_infobilder = hasInfotype($info, "infobilder");
    $has_beskrivelse = hasInfotype($info, "beskrivelse");
    $has_historikk = hasInfotype($info, "historikk");
    $has_tekntegn = hasInfotype($info, "tekntegn");
    $has_spectable = hasInfotype($info, "spectable");
    $has_diverse = hasInfotype($info, "diverse");
    $has_relsider = hasInfotype($info, "relsider");
    $has_designhist = hasInfotype($info, "designhist");
    $has_bildeserie = hasInfotype($info, "bildeserie");
    $has_divbilder = hasInfotype($info, "divbilder");
    
    $ret .= '<div class="mobile">';

    if($has_infobilder ) {
        $ret .= '<div class="info_float_right info_vertical_imgtable info_block" >';
        if($has_relsider) {
            $ret .=  '<div style="margin: 0px 0px 15px 0px;">'.infoToRelatedPages($info["relsider"],"98%" /*$viewSettings->vertimglist_width*/).'</div>';
        }
        $ret .= intoToVerticalImageTable($info["infobilder"]);
        $ret .= '</div>';
        $ret .= "\n";
    }
    if($has_beskrivelse ) {
        $ret .= '<div class="info_block">'.infoToHTMLText($info["beskrivelse"]).'</div>';
        $ret .= "\n";
    }

    if($has_historikk ) {
        $ret .= '<div class="info_block" >'.infoToHTMLText($info["historikk"]).'</div>';
        $ret .= "\n";
    }
    
    if($has_tekntegn ) {
        $ret .= '<div class="info_float_left info_vertical_imgtable info_block" >';
        $ret .= intoToVerticalImageTable($info["tekntegn"]);
        $ret .= '</div>';
        $ret .= "\n";
    }

    if($has_spectable ) {
        $width = $has_tekntegn ? $viewSettings->narrow_width : $viewSettings->full_width;
        $ret .= '<div class="info_block">'.infoToHTMLTable($info["spectable"],$width).'</div>';
        $ret .= "\n";
    }

    if($has_diverse) {
        $ret .= '<div class="info_block">'.infoToHTMLText($info["diverse"],false).'</div>';
        $ret .= "\n";
    }

    if($has_relsider && !$has_infobilder ) {
        $width = "98.4%"; //$has_tekntegn ? $viewSettings->narrow_width : $viewSettings->full_width;
        //$ret .= '<div class="info_block" style="float:right; min-width: '. $viewSettings->narrow_width.'; max-width:'.$viewSettings->full_width.';" >'.infoToRelatedPages($info["relsider"], $width).'</div>';
        $ret .= '<div class="info_block" style="" >'.infoToRelatedPages($info["relsider"], $width).'</div>';
        $ret .= "\n";
    }

    if($has_designhist ) {
        $ret .= '<div class="info_block" style="clear:both;" >'.infoToPictureList($info["designhist"]).'</div>';
        $ret .= "\n";
    }

    if($has_bildeserie) {
        $ret .= '<div class="info_block" style="clear:left;" >'.infoToPictureList($info["bildeserie"]).'</div>';
        $ret .= "\n";
    }
    if($has_divbilder) {
        $ret .= '<div class="info_block" style="clear:left;" >'.infoToFullImgList($info["divbilder"]).'</div>';
    }

    $ret .= '</div>';

    return $ret;
}

?>

<script type="text/javascript" >
function makeImageViewString(image) {
    return '<img class="info_fullimgview" src="'+image+'"  />';
}

function showImage(image) {    
    $.fancybox.open( { 
        href: makeImageViewString(image), 
        type: 'html', 
        maxWidth: 1200, 
        maxHeight: 1000, 
        autoCenter: true, 
        aspectRatio: true, 
        fitToView: true, 
        padding: 0 } );
}

</script>


<?php

$html = "";

// . 
/*
 * generates a <a><img> link with thumbsize as specified
 * $url - picture URL
 * $thumb - thumbnail url
 * $thumbsize - width of thumbnail
 * $thumbheight - (optional) height of thumbnail (if different from thumbsize)
 */
 

function imageThumbAndLink($url,$thumb,$thumbsize,$thumbheight = NULL) {
    global $relativepath;
    if(empty($url) || strlen($url)==0) {
        $url = $thumb;
    }
    if(empty($thumb) || strlen($thumb)==0) {
        $thumb = $url;
    }
    //$url = addParentDirIfRelativePath($url);
    //$thumb = addParentDirIfRelativePath($thumb);

	
	// Rensning af URL - uanset hvad URL er bliver den renset så den starter med /whatever...
    if (substr($thumb,0,4) == 'http') {
            $thumb = substr($thumb,strpos($thumb,'jernbane.net')+12);
    }
	if (substr($url,0,4) == 'http') {
            $url = substr($url,strpos($url,'jernbane.net')+12);
    }	
			

    if(!$thumbsize ) {
        $thumbsize = 100; // default thumbnail size
    }
    //$height = $thumbheight ? $thumbheight : $thumbsize;
    $heightstr = $thumbheight ? 'height="'.$thumbheight.'"' : "";
    
    return '<img class="infotable_thumb" width="'.$thumbsize.'" '.$heightstr.' src="'.$thumb.'" alt="[bilde]" style="cursor: pointer;"
        onclick="showImage(\''.$url.'\')"/>';
}

function tableCellToHtml($val) {
    if(!isset($val) || strlen($val)==0 ) {
        return "";
    }
    $ret = html_entity_decode($val,ENT_QUOTES, 'utf-8');
    $ret = str_replace('[br]','<br>',$ret);
    return $ret;
}


function intoToVerticalImageTable($info, $mobilever = false ) {
    global $viewSettings;
	
    $antbilder = count($info["bilder"]);
    /*$thumbsize = floor($viewSettings->vertimglist_width/2);
    switch($antbilder) {
        case 1: $thumbsize = $viewSettings->vertimglist_width; break;
        case 2: $thumbsize = floor($viewSettings->vertimglist_width*0.75); break;
    }*/
    $thumbsize = $mobilever ? "66%" : "250";   // samme som galleriets thumbs
    $tabwidth = $mobilever ? "100%" : $viewSettings->vertimglist_width;
    $ret = "";
    if($antbilder>0) {
        $ret .= '<table width="'.$tabwidth.'">';
        foreach ($info["bilder"] as $bilde) {
            if(array_key_exists("url", $bilde)) {
                $heading = tableCellToHtml($bilde['heading']);
                $kommentar = tableCellToHtml($bilde['kommentar']);
                $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
                $thumb = html_entity_decode($bilde['thumb'],ENT_QUOTES, 'utf-8');
                if(strlen($heading)>0) {
                    $ret .= '<tr><td class="infotable_heading">'.$heading.'</td></tr>';
                }
                $ret .= '<tr><td class="pictable_cell">'.imageThumbAndLink($url, $thumb, $thumbsize).'</td></tr>';
                if(strlen($kommentar)>0) {
                    $ret .= '<tr><td class="pictable_kommentar">'.$kommentar.'</td></tr>';
                }
            }
        }    
        $ret .= '</table>';
    }
    return $ret;
}

function infoToPictureList($info,$mobilever = false) {
    global $viewSettings;
    global $html;
    if(!array_key_exists("bilder", $info)) {
        return "";
    }
    
    $html = '';
    //if(array_key_exists("tittel",$info)) {
    //    $html .= '<p class="infotype_tittel" style="width:930;" >'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8').'</p>';
    //}    
    $npics = count($info["bilder"]);
    $n = $mobilever ? 3 : 8;
    $nperline = intval(ceil($npics/intval(ceil($npics/$n))));

    //$html .= '<p>count '.$npics.' nperline '.$nperline.'</p>';
    
    $width = $mobilever ? "100%" : $viewSettings->full_width;
    
    $html .= '<table class="infotable" width="'.$width.'">';
    $html .= '<caption class="infotable_caption">'.tableCellToHtml($info["tittel"]).'</caption>';

    for($i = 0; $i < $npics; $i += $nperline) {
    
        // foerst tittel linje
        $html .= "<tr>";
        $kommentar_eksisterer = false;
        //foreach ($info["bilder"] as $bilde) {
        //for($j=$i ;$j<$npics && (($j+1) % $nperline) != 0; $j++) {
        $j = $i;
        do {
            $bilde = $info["bilder"][$j];
            $v = "";
            if(array_key_exists("heading", $bilde)) {
                $v = tableCellToHtml($bilde['heading']);
            } else {

            }
            $html .= '<td class="pictable_title">'.$v.'</td>';
            if(array_key_exists("kommentar", $bilde)) {
                $kommentar_eksisterer = true;
            }
            $j++;
        } while($j<$npics && ($j % $nperline) != 0);
        if(($j % $nperline) != 0) {
            $na = $nperline - ($j % $nperline);
            for($k=0; $k<$na; $k++) {
                $html .= '<td class="pictable_title"></td>';
            }
        }
        $html .= "</tr><tr>";
        //foreach ($info["bilder"] as $bilde) {
        //for($j=$i ;$j<$npics && (($j+1) % $nperline) != 0; $j++) {
        $j = $i;
        do {
            $bilde = $info["bilder"][$j];
            if(array_key_exists("url", $bilde) && array_key_exists("thumb", $bilde) && array_key_exists("kommentar", $bilde)) {
                $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
                $thumb = html_entity_decode($bilde['thumb'],ENT_QUOTES, 'utf-8');
                $thumbsize = $mobilever ? "80%" : 100;
                $html .= '<td class="pictable_cell">'.imageThumbAndLink($url,$thumb,$thumbsize).'</td>'; 
            }
            $j++;
        } while($j<$npics && ($j % $nperline) != 0);
        if(($j % $nperline) != 0) {
            $na = $nperline - ($j % $nperline);
            for($k=0; $k<$na; $k++) {
                $html .= '<td class="pictable_cell"></td>';
            }
        }
        $html .= "</tr>";
        if($kommentar_eksisterer) {
            $html .= "<tr>";
            //foreach ($info["bilder"] as $bilde) {
            //for($j=$i ;$j<$npics && (($j+1) % $nperline) != 0; $j++) {
            $j = $i;
            do {
                $bilde = $info["bilder"][$j];
                if(array_key_exists("kommentar", $bilde)) {
                    $v = tableCellToHtml($bilde['kommentar']);
                } else {

                }
                $html .= '<td class="pictable_kommentar">'.$v.'</td>';
                $j++;
            } while($j<$npics && ($j % $nperline) != 0);
            if(($j % $nperline) != 0) {
                $na = $nperline - ($j % $nperline);
                for($k=0; $k<$na; $k++) {
                    $html .= '<td class="pictable_kommentar"></td>';
                }
            }
            $html .= '</tr>';
        }
    }
    $html .= '</table>';
    return $html;
}

function infoToRelatedPages($info,$width) {
    global $html;
    $html = "";
    if(count($info["urls"])>0) {
        $html .= '<table class="rellinkstable" width="'.$width.'">';            
        if(array_key_exists("tittel",$info)) {
             $html .= '<tr><td class="rellink_title">'.tableCellToHtml($info["tittel"]).'</td></tr>';
        }
        foreach ($info["urls"] as $url) {
            if(array_key_exists("url", $url)) {
                $komm = tableCellToHtml($url['kommentar']);
                $url = html_entity_decode($url['url'],ENT_QUOTES, 'utf-8');
                if(strlen($komm)==0) {
                    $komm = $url;
                }
                $html .= '<tr><td class="rel_link" width="100%" ><a href="'.$url.'" target="_blank" >'.$komm.'</a></td></tr>';                
            }
        } 
        $html .= '</table>';
    }
    return $html;
}


function htmlspectablerow($item, $key) {
    global $html;
    $html .= '<tr><td class="spectable_kat" width="33%" >'.tableCellToHtml($key).'</td><td class="spectable_info" width="67%" >'.tableCellToHtml($item).'</td></tr>';
}

function isRelativeURL($url) {
    if( preg_match('#^([a-z]+:/|/)#',$url) ) {
        return false;
    }
    return true;
}

function addParentDirIfRelativePath($path) {
    global $relativepath;
    if(isRelativeURL($path)) {
        $path = $relativepath.$path;
    }
    return $path;
}

/*
 * $info - Info structure to be parsed
 * $pathCorrection - (Optional) correction function to be applied to the urls 
 */
function infoToHTMLTable($info, $width, $pathCorrection = NULL ) {
    //echo"spectable ";var_dump($info);echo"<br>";
    if(!array_key_exists("tabell", $info) && !array_key_exists("bilder", $info) && !array_key_exists("urls", $info)) {
        return "";
    }
    global $html;
    $html = '<table class="infotable" width="'.$width.'">';
    
    if(array_key_exists("tabell", $info) && (count($info["tabell"])>0)) {
       if(array_key_exists("tittel",$info)) {
          $html .= '<tr><td class="infotable_title" colspan="2">'.tableCellToHtml($info["tittel"]).'</td></tr>';
       }

       array_walk($info["tabell"], "htmlspectablerow");
    }
    
    $html .= '</table>';
    return $html;
}

function infoToHTMLText($info,$incl_title = true) {
    if(!array_key_exists("tekst", $info)) {
        return "";
    }    
    global $html;
    $html = '<div class="tekst_boks">';
    
    if($incl_title && !empty($info["tittel"])) {
        $html .= '<p class="tekst_tittel">'.tableCellToHtml($info["tittel"])."</p>\n";
    }
    $html .= '<span class="tekst_body">'.tableCellToHtml($info["tekst"])."</span>\n";
    $html .= "</div>\n";
    return $html;
}

function infoToFullImgList($info) {
    global $html;
    
    $html="";
    foreach ($info["bilder"] as $bilde) {
        if(array_key_exists("url", $bilde) && array_key_exists("kommentar", $bilde)) {
            $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
            //$url = addParentDirIfRelativePath($url);
            $html .= '<img class="info_fullsize" alt="[bilde]" src="'.$url.'" style="cursor: pointer;"
              onclick="showImage(\''.$url.'\')"/>';
            $kommentar = tableCellToHtml($bilde['kommentar']);
            if(strlen($kommentar)>0) {
                $html .= '<center>'.$kommentar.'</center>';
            }
        }
    }    
    $html .= "\n";
    return $html;
}



?>
