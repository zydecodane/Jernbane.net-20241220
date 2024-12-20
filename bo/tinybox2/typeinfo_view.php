<?php
// vriable used to correct include paths and image links when script used from admin directory
$relativepath = ''; 

$cwd =  getcwd();
if(preg_match("@bo/admin$@", $cwd)) {
    $relativepath = '../';
}
?>

<link href="<?php echo $relativepath;?>typeinfo.css" rel="stylesheet"/>

<script type="text/javascript" src="<?php echo $relativepath;?>../bo/tinybox2/packed.js" ></script>


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
function dbTypeInfoToHtml($dbinfostruct,$oldinfo = NULL) {
    //echo "<xmp>$dbinfostruct</xmp><br>";
    if(isset($dbinfostruct) && strlen($dbinfostruct)>0) {
        $infostruct = getInfoFromDbString($dbinfostruct);
        return infostructToHtml($infostruct);
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

function hasInfotype(&$info,$type) {
    return array_key_exists($type, $info);
}
        
function infostructToHtml(&$info) {
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
    
    if($has_infobilder ) {
        $ret .= '<div class="info_float_right info_vertical_imgtable info_block" >';
        if($has_relsider) {
            $ret .=  '<div style="margin: 0px 0px 15px 0px;">'.infoToRelatedPages($info["relsider"],$viewSettings->vertimglist_width).'</div>';
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
        $width = $has_tekntegn ? $viewSettings->narrow_width : $viewSettings->full_width;
        $ret .= '<div class="info_block"><center>'.infoToRelatedPages($info["relsider"], $width).'</center></div>';
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
    return $ret;
}

?>

<script type="text/javascript" >
function makeImageViewString(image) {
    return '<img class="info_fullimgview" src="'+image+'"  />';
}
</script>


<?php

$html = "";

// . 
/*
 * generates a <a><img> link with thumbsize as specified
 * $url - picture URL
 * $thumb - thumbnail url
 * $thumbsize - size of thumbnail (both width and height unless $thumbheight is specified)
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
    $url = addParentDirIfRelativePath($url);
    $thumb = addParentDirIfRelativePath($thumb);

    if(!$thumbsize ) {
        $thumbsize = 100; // default thumbnail size
    }
    //$height = $thumbheight ? $thumbheight : $thumbsize;
    $heightstr = $thumbheight ? 'height="'.$thumbheight.'"' : "";
    
    return '<img class="infotable_thumb" width="'.$thumbsize.'" '.$heightstr.' src="'.$thumb.'" alt="[bilde]" style="cursor: pointer;"
        onclick="TINY.box.show({html:makeImageViewString(\''.$url.'\'),opacity:50,fixed:false,boxid:\'frameless\',animate:true})"/>';
        //onclick="TINY.box.show({url:\'visbilde.php?img='.$url.'\',opacity:50,fixed:false,boxid:\'frameless\',animate:true})"/>';
        //onclick="TINY.box.show({image:\''.$url.'\',opacity:50,fixed:false,boxid:\'frameless\',animate:true})"/>';
}



function intoToVerticalImageTable($info) {
    global $viewSettings;

    $antbilder = count($info["bilder"]);
    $thumbsize = floor($viewSettings->vertimglist_width/2);
    switch($antbilder) {
        case 1: $thumbsize = $viewSettings->vertimglist_width; break;
        case 2: $thumbsize = floor($viewSettings->vertimglist_width*0.75); break;
    }
    $ret = "";
    if($antbilder>0) {
        $ret .= '<table width="'.$viewSettings->vertimglist_width.'">';
        foreach ($info["bilder"] as $bilde) {
            if(array_key_exists("url", $bilde)) {
                $heading = html_entity_decode($bilde['heading'],ENT_QUOTES, 'utf-8');
                $kommentar = html_entity_decode($bilde['kommentar'],ENT_QUOTES, 'utf-8');
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

function infoToPictureList($info) {
    global $viewSettings;
    global $html;
    if(!array_key_exists("bilder", $info)) {
        return "";
    }
    
    $html = '';
    //if(array_key_exists("tittel",$info)) {
    //    $html .= '<p class="infotype_tittel" style="width:930;" >'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8').'</p>';
    //}
    $html .= '<table class="infotable" width="'.$viewSettings->full_width.'">';
    $html .= '<caption class="infotable_caption">'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8').'</caption>';
    
    // foerst tittel linje
    $html .= "<tr>";
    $kommentar_eksisterer = false;
    foreach ($info["bilder"] as $bilde) {
        $v = "";
        if(array_key_exists("heading", $bilde)) {
            $v = html_entity_decode($bilde['heading'],ENT_QUOTES, 'utf-8');
        } else {
            
        }
        $html .= '<td class="pictable_title">'.$v.'</td>';
        if(array_key_exists("kommentar", $bilde)) {
            $kommentar_eksisterer = true;
        }
    }    
    $html .= "</tr><tr>";
    foreach ($info["bilder"] as $bilde) {
        if(array_key_exists("url", $bilde) && array_key_exists("thumb", $bilde) && array_key_exists("kommentar", $bilde)) {
            $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
            $thumb = html_entity_decode($bilde['thumb'],ENT_QUOTES, 'utf-8');
            $html .= '<td class="pictable_cell">'.imageThumbAndLink($url,$thumb,100).'</td>'; 
        }
    }    
    $html .= "</tr>";
    if($kommentar_eksisterer) {
        $html .= "<tr>";
        foreach ($info["bilder"] as $bilde) {
            if(array_key_exists("kommentar", $bilde)) {
                $v = html_entity_decode($bilde['kommentar'],ENT_QUOTES, 'utf-8');
            } else {

            }
            $html .= '<td class="pictable_kommentar">'.$v.'</td>';
        }    
        $html .= '</tr>';
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
             $html .= '<tr><td class="pictable_title">'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8').'</td></tr>';
        }
        foreach ($info["urls"] as $url) {
            if(array_key_exists("url", $url)) {
                $komm = html_entity_decode($url['kommentar'],ENT_QUOTES, 'utf-8');
                $url = html_entity_decode($url['url'],ENT_QUOTES, 'utf-8');
                if(strlen($komm)==0) {
                    $komm = $url;
                }
                $html .= '<tr><td class="infotable_heading"><a href="'.$url.'" target="_blank" >'.$komm.'</a></td></tr>';                
            }
        } 
        $html .= '</table>';
    }
    return $html;
}


function htmlspectablerow($item, $key) {
    global $html;
    $html .= '<tr><td class="spectable_kat" width="200" >'.html_entity_decode($key,ENT_QUOTES, 'utf-8').'</td><td class="spectable_info" width="400" >'.html_entity_decode($item,ENT_QUOTES, 'utf-8').'</td></tr>';
}

function isRelativeURL($url) {
    //if(filter_var($url, FILTER_VALIDATE_URL) === false) {
     //   return false;
    //}
    if( preg_match('#^([a-z]+://|//)#',$url) ) {
        return false;
    }
    return true;
}

function addParentDirIfRelativePath($path) {
    if(isRelativeURL($path)) {
        $path = "../".$path;
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
          $html .= '<tr><td class="infotable_title" colspan="2">'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8').'</td></tr>';
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
        $html .= '<p class="tekst_tittel">'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8')."</p>\n";
    }
    $html .= '<span class="tekst_body">'.html_entity_decode($info["tekst"],ENT_QUOTES, 'utf-8')."</span>\n";
    $html .= "</div>\n";
    return $html;
}

function infoToFullImgList($info) {
    global $html;
    
    $html="";
    foreach ($info["bilder"] as $bilde) {
        if(array_key_exists("url", $bilde) && array_key_exists("kommentar", $bilde)) {
            $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
            $url = addParentDirIfRelativePath($url);
            $html .= '<img class="info_fullsize" alt="[bilde]" src="'.$url.'" style="cursor: pointer;"
    onclick="TINY.box.show({html:makeImageViewString(\''.$url.'\'),opacity:50,fixed:false,boxid:\'frameless\',animate:true})"/>';
            $kommentar = html_entity_decode($bilde['kommentar'],ENT_QUOTES, 'utf-8');
            if(strlen($kommentar)>0) {
                $html .= '<center>'.$kommentar.'</center>';
            }
        }
    }    
    $html .= "\n";
    return $html;
}



?>
