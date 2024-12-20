<?php

function recursePrint($node)
{
    if(!isset($node)) {
        return;
    }
    ///var_dump($node);
    //var_dump(property_exists($node, 'nodeType'));
    // echo "<br/>";
   
    if (!isset($node) || !property_exists($node, 'nodeType') || $node->nodeType !== XML_ELEMENT_NODE)
    {
        return;
    }

    echo $node->tagName;
    echo " = ";
    //echo $node->getAttribute('style');
    echo $node->nodeValue;
    echo "<br/>";

    if (property_exists($node, 'childNodes') ){
     foreach ($node->childNodes as $childNode)
      {
          recursePrint($childNode);
      }
    
    }
}

$html = "";
function htmlspectablerow($item, $key) {
    global $html;
    $html .= '<tr><td class="spectable_kat">'.tableCellToHtml($key).'</td><td class="spectable_info">'
            .tableCellToHtml($item).'</td></tr>';
}

function correctRelativeLinks($htmltext) {
    $relativepath = '../';
    $ret = preg_replace('@\b(src|href)\s*=\s*("|\')([A-Za-z]+:|)(\.\./|\./|[\w]+[\./]|[\w]+(?="|\'))@', '${1}=${2}${3}'.$relativepath.'${4}', $htmltext);
    return $ret;
}

function isRelativeURL($url) {
    //if(filter_var($url, FILTER_VALIDATE_URL) === false) {
     //   return false;
    //}
    if(strlen($url) < 2) {
        return false;
    }
    if( preg_match('@^([a-z]+:/|/)@',$url) ) {
        //echo $url." is absolute<br>";
        return false;
    }
    //echo $url." is relative<br>";
    return true;
}

function correctRelativeURL($url) {
    // antar at URL er relative (bruk isRelativeURL())
    return preg_replace('@^([A-Za-z]+:|)(\.\./|\./|\w)@', '${1}../${2}', $url, 1);
    //return preg_replace('/\.\.\//', '../../', $url, 1);
}

function tableCellToHtml($val) {
    if(!isset($val) || strlen($val)==0 ) {
        return "";
    }
    $ret = html_entity_decode($val,ENT_QUOTES, 'utf-8');
    //$ret = htmlentities($val,ENT_QUOTES, 'utf-8');
    $ret = str_replace('[br]','<br>',$ret);
    $ret = correctRelativeLinks($ret);
    return $ret;
}

function infoToHTMLTable($info) {
    //echo"spectable ";var_dump($info);echo"<br>";
    if(!isset($info)) {
        return "";
    }
    if(!array_key_exists("tabell", $info) && !array_key_exists("bilder", $info) && !array_key_exists("urls", $info)) {
        return "";
    }
    global $html;
    $html = '<table class="infotable">';
    
    if(array_key_exists("tabell", $info) && (count($info["tabell"])>0)) {
       if(array_key_exists("tittel",$info)) {
          $html .= '<tr><td class="infotable_title" colspan="2">'.tableCellToHtml($info["tittel"]).'</td></tr>';
       }

       array_walk($info["tabell"], "htmlspectablerow");
    }
    
    if(array_key_exists("bilder", $info) && (count($info["bilder"])>0)) {
       if(array_key_exists("tittel",$info)) {
          $html .= '<tr><td class="infotable_title" colspan="4">'.tableCellToHtml($info["tittel"]).'</td></tr>';
       }

       $html .= '<tr><td class="infotable_coltitle">Heading</td><td class="infotable_coltitle">URL</td><td class="infotable_coltitle">Thumb</td><td class="infotable_coltitle">Kommentar</td></tr>';

       foreach ($info["bilder"] as $bilde) {
            if(array_key_exists("url", $bilde) && array_key_exists("thumb", $bilde) && array_key_exists("kommentar", $bilde)) {
                $url = html_entity_decode($bilde['url'],ENT_QUOTES, 'utf-8');
                $thumb = html_entity_decode($bilde['thumb'],ENT_QUOTES, 'utf-8');
                if(isRelativeURL($url)) {
                    $url = correctRelativeURL($url); //"../".$url;
                }
                if(isRelativeURL($thumb)) {
                    $thumb = correctRelativeURL($thumb); //"../".$thumb;
                }
                $html .= '<tr><td class="pictable_heading">'.tableCellToHtml($bilde['heading']).'</td>';
                $html .= '<td class="pictable_cell"><img src="'.$url.'" alt="[bilde]" width="100" height="100" /></td>';
                $html .= '<td class="pictable_cell"><img src="'.$thumb.'" alt="[bilde]" width="100" height="100" /></td>';
                $html .= '<td class="pictable_kommentar">'.tableCellToHtml($bilde['kommentar']).'</td></tr>';
            }
       }    
       
    }
  
    if(array_key_exists("urls", $info) && (count($info["urls"])>0)) {
       if(array_key_exists("tittel",$info)) {
          $html .= '<tr><td class="infotable_title" colspan="2">'.tableCellToHtml($info["tittel"]).'</td></tr>';
       }

       $html .= '<tr><td class="infotable_coltitle">URL</td><td class="infotable_coltitle">Kommentar</td></tr>';

       foreach ($info["urls"] as $url) {
            if(array_key_exists("url", $url) && array_key_exists("kommentar", $url)) {
                $linkurl = $url['url'];
                if(isRelativeURL($linkurl)) {
                    $linkurl = correctRelativeURL($linkurl); //"../".$linkurl;
                }
                $html .= '<tr><td class="pictable_heading">'.tableCellToHtml($linkurl).'</td>';
                $html .= '<td class="pictable_kommentar">'.tableCellToHtml($url['kommentar']).'</td></tr>';
            }
       }    
       
    }

    $html .= '</table>';
    return $html;
}

function infoToHTMLText($info) {
    if(!isset($info)) {
        return "";
    }
    if(!array_key_exists("tekst", $info)) {
        return "";
    }    
    global $html;
    $html = '<div class="tekst_boks">';
    
    $html .= '<p class="tekst_tittel">'.html_entity_decode($info["tittel"],ENT_QUOTES, 'utf-8')."</p>\n";
    $html .= '<p class="tekst_body">'.html_entity_decode($info["tekst"],ENT_QUOTES, 'utf-8')."</p>\n";
    $html .= "</div>\n";
    
    $html = correctRelativeLinks($html);
    return $html;
}

function infoToEditableText($info) {
    if(!isset($info)) {
        return "";
    }
    if(!array_key_exists("tekst", $info)) {
        return "";
    }    
    
    global $text;
    $text = addslashes(html_entity_decode($info["tekst"],ENT_QUOTES, 'utf-8'));//$info["tekst"];
    return $text;
}

function jsonEncode($str) {
    $v = html_entity_decode($str,ENT_QUOTES, 'utf-8');
    $v = htmlspecialchars_decode($v,ENT_QUOTES | ENT_HTML401 );
    $v = json_encode($v);
    $v = preg_replace('/(^[\"\']|[\"\']$)/', '', $v);
    $v = preg_replace('/<(\w)/', '< $1', $v);
    $v = preg_replace('/<\/(\w)/', '< /$1', $v);
    $v = addslashes($v);//str_replace();
    return $v;
}

function infoToEditableGrid($info,$infotype) {
    if(!array_key_exists("tabell", $info) && !array_key_exists("bilder", $info) && !array_key_exists("urls", $info)) {
        return "";
    }
    
    global $json;
    $json = '';
    if(array_key_exists("tabell", $info) && (count($info["tabell"])>0)) {
        // dual kolonne tabell uten heading
        // 
        // metadata
        $json .= '{"metadata":[\n';
        $json .= '{"name":"kat","label":" ","datatype":"html","editable":true},\n';
        $json .= '{"name":"val","label":" ","datatype":"html","editable":true},\n';
        $json .= '{"name":"radover","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"radunder","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"slett","label":" ","datatype":"html","editable":false}\n';
        $json .= '],\n\n"data":[\n';

        // data
        $count = 1;
        foreach ($info["tabell"] as $key => $value) {
            //echo 'row '.$count.' k='.$key.' v='.$value.'<br>'; 
            if($count>1) {
                $json .= ',\n';
            }
            $json .= '{"id":'.$count.', "values":{"kat":"'.jsonEncode($key).'","val":"'.jsonEncode($value).'"}}';
            $count++;
            //if($count>2) break;
        }
        $json .= ']}\n';
     
    } 
    if(array_key_exists("bilder", $info) && (count($info["bilder"])>0)) {
        // tabell med 
        // 
        // metadata
        $json .= '{"metadata":[\n';
        $json .= '{"name":"heading","label":"Heading","datatype":"html","editable":true},\n';
        $json .= '{"name":"url","label":"URL","datatype":"string","editable":true},\n';
        $json .= '{"name":"thumb","label":"Thumb","datatype":"string","editable":true},\n';
        $json .= '{"name":"kommentar","label":"Kommentar","datatype":"html","editable":true},\n';
        $json .= '{"name":"radover","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"radunder","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"slett","label":" ","datatype":"html","editable":false}\n';
        $json .= '],\n\n"data":[\n';

        // data
        $count = 1;
        foreach ($info["bilder"] as $bilde) {
            if(array_key_exists("url", $bilde) && array_key_exists("thumb", $bilde) && array_key_exists("kommentar", $bilde)) {
                if($count>1) {
                    $json .= ',\n';
                }
                $json .= '{"id":'.$count.', "values":{"heading":"'.jsonEncode($bilde["heading"]).'", "url":"'.$bilde["url"].'", "thumb":"'.$bilde["thumb"].'","kommentar":"'.jsonEncode($bilde["kommentar"]).'"}}';
                $count++;
            }
            //if($count>2) break;
        }
        $json .= '\n]}\n';
     
    } 

    if(array_key_exists("urls", $info) && (count($info["urls"])>0)) {
        // tabell med 
        // 
        // metadata
        $json .= '{"metadata":[\n';
        $json .= '{"name":"url","label":"URL","datatype":"url","editable":true},\n';
        $json .= '{"name":"kommentar","label":"Kommentar","datatype":"html","editable":true},\n';
        $json .= '{"name":"radover","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"radunder","label":" ","datatype":"html","editable":false},\n';
        $json .= '{"name":"slett","label":" ","datatype":"html","editable":false}\n';
        $json .= '],\n\n"data":[\n';

        // data
        $count = 1;
        foreach ($info["urls"] as $url) {
            if(array_key_exists("url", $url) && array_key_exists("kommentar", $url)) {
                if($count>1) {
                    $json .= ',\n';
                }
                $json .= '{"id":'.$count.', "values":{"url":"'.$url["url"].'","kommentar":"'.jsonEncode($url["kommentar"]).'"}}';
                $count++;
            }
            //if($count>2) break;
        }
        $json .= '\n]}\n';
     
    } 

    return $json;
}

function hasChildNodeType($el,$nodetype) {
    if(strlen($el->localName)>0 && strcasecmp($el->localName,$nodetype)==0) {
        return true;
    }
    if($el->hasChildNodes()) {
        for($i=0;$i<$el->childNodes->length;$i++) {
            if(hasChildNodeType($el->childNodes->item($i),$nodetype)) {
                return true;
            }
        }
    }
    return false;
}

function decodeOldTypeInfo(&$infostruct,$info) {
    if(preg_match('/^\\s*<\\w+/',$info)) {
        // anta html kode
        //echo "html kode<br>";
        //echo "<xmp>$info</xmp>&lsquo; &rsquo; ´ &#96; &#180;<br>";
        $dom = new DOMDocument("1.0","utf-8");
        $dom->loadHTML('<?xml encoding="utf-8"?>' . $info);  //for aa sikre at info dekodes korrekt
        //$dom->loadHTML(mb_convert_encoding($info, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);
        $tablelist = $xpath->query("//table[(not(descendant::table))]/*");
        $i=0;
        $a = array();
        $infotable = @$a;
        $spectable = false;
        $first = TRUE;
        foreach($tablelist as $table ){
            $i++;
            $tdlist = $table->getElementsByTagName('td');
            //printf( "Table $i<br/>");
            //var_dump($table);echo"<br>";
            //recursePrint($table);
            for($j=0;$j<$tdlist->length;$j++) {
                $hasrowspan = $tdlist->item($j)->hasAttribute('rowspan');
                $hasimgs = hasChildNodeType($tdlist->item($j),'img');
                $key = $tdlist->item($j)->textContent;
                //printf("text %s hasrowspan %b hasimgs %b<br>",$key,$hasrowspan,$hasimgs);
                if(empty($key) || $hasrowspan || $hasimgs) {
                    continue;
                }
                $string = htmlentities($key, null, 'utf-8');
                $keymod = trim(str_ireplace("&nbsp;", "", $string)); 
                //$keymod = html_entity_decode($keymod);

                //$keymod = trim(str_ireplace('&nbsp;'," ",$key));
                //printf( "2 '$keymod' %d '$key' %d<br>", strlen($keymod), strlen($key));
                if($first && strlen(trim($keymod))==0) {
                    continue;
                }
                //printf( "3 '$key' ");
                //var_dump(stripos($key, "spesifikasjoner"));
                //echo"<br>";
                if(stripos($key, "spesifikasjoner") !== false ) {
                    // anta heading, skip
                    //echo "Spectabell funnet<br>";
                    @$spectable = true;
                    continue;
                }
                $first = FALSE;
                //printf("j %d tdlist %d strlen(keymod) %d item %d test %d<br>",$j,$tdlist->length,strlen($keymod), strlen($tdlist->item($j+1)->textContent),j<($tdlist->length-1));
                if($j<($tdlist->length-1)) {
                    if(strlen($keymod)>0) { // hopp over tomme key/value par
                        $val = $tdlist->item($j+1)->textContent;
                        //echo "Item $j: " . htmlentities($tdlist->item($j)->textContent,ENT_QUOTES, 'utf-8') . " = " . 
                        //     htmlentities($tdlist->item($j+1)->textContent,ENT_QUOTES, 'utf-8') . " $$$ ".$val."<br>";
                        $infotable[htmlentities($tdlist->item($j)->textContent,ENT_QUOTES, 'utf-8')] = htmlentities($tdlist->item($j+1)->textContent,ENT_QUOTES, 'utf-8');
                    }
                    $j++;
                }

            }
        }
        //echo"infotable ";var_dump($infotable);echo"<br>";
        //echo"spectable ";var_dump($spectable);echo"<br>";
        if($spectable && !array_key_exists("spectable", $infostruct)) {
            $infostruct["spectable"] = array("tittel"=>"Spesifikasjoner **dekodet fra gammel info, ikke lagret**", "tabell"=>$infotable);
            //echo "\n<br><br>\n";
            //echo infoToHTMLTable($infostruct["spectable"]);
            //echo "<br><br>\n";

        }
    } else {
        echo "ikke html kode<br>";                
    }
}


?>
