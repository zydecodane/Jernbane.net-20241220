<?php
//error_reporting(E_ERROR | E_PARSE);
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

ini_set("include_path", '/var/www/jernbane.net/php:' . ini_get("include_path") );

require_once 'HTML/Table.php';

$land='0';	
if (isset($_POST["land"])) { $land=$_POST["land"]; }
if (isset($_GET["l"])) { $land=$_GET["l"]; }
	
$cat='0';	
if (isset($_POST["cat"])) { $cat=$_POST["cat"]; }	
if (isset($_GET["c"])) { $cat=$_GET["c"]; }	
	
$type='0';	
if (isset($_POST["type"])) { $type=$_POST["type"]; }	
if (isset($_GET["t"])) { $type=$_GET["t"]; }	

$query = "SELECT * FROM gal_nations ORDER BY plass ASC";
$result = $db->query($query);
?>   

<link href="jquery/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">

<script src="jquery/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui-1.11.4/jquery-ui.js"></script>
<style>
	body{
		font: 62.5% "Trebuchet MS", sans-serif;
		//margin: 50px;
	}
	.demoHeaders {
		margin-top: 2em;
	}
        a.dialog-link-class {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	a.dialog-link-class span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
        
.anchor {
    display: block;
    padding-top: 60px;
    margin-top: -60px;
}
        
</style>
        
<!-- Editable grid setup -->
<script type="text/javascript" src="editablegrid/editablegrid.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_validators.js"></script> 
<script type="text/javascript" src="editablegrid/editablegrid_renderers.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_editors.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_utils.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_charts.js"></script>

<link rel="stylesheet" href="editablegrid/editablegrid.css" type="text/css" media="screen">

<style>
        body { font-family:'lucida grande', tahoma, verdana, arial, sans-serif; font-size:11px; }
        h1 { font-size: 15px; }
        a { color: #548dc4; text-decoration: none; }
        a:hover { text-decoration: underline; }
        table.editorgrid { border-collapse: collapse; border: 1px solid #aaa; width: 780px; }
        table.editorgrid td, table.editorgrid th { padding: 5px; border: 1px solid #a0a0a0; }
        table.editorgrid th { background: #f0f0f0; text-align: left; }
        table.editorgrid td { background: #f0f0f0; }
        table.editorgrid tr { border-bottom: 1px solid #a0a0a0; }
        input.invalid { background: red; color: #FDFDFD; }
</style>

<style>
    h1.info_heading { color: #548dc4; text-align: left; margin: 20px 40px 20px 0px; text-decoration: underline; font-size:20px; display: inline;  }
    h2.info_type_heading { color: #548dc4;  margin: 20px 0px 5px 20px; }
    div.info_type_content { margin: 0px 0px 0px 20px; }
    p.tekst_tittel { font-size:12px; font-weight: bold; margin-bottom: -7px; margin-top: 0px;}
    p.tekst_body { font-weight: normal; margin-bottom: 0px; }
    div.tekst_boks { padding: 3px 10px 3px 10px; border-collapse: collapse; border: 1px solid #CCB; width: 800px;   
                      -moz-box-shadow: 3px 3px 4px #888; -webkit-box-shadow: 3px 3px 4px #888; box-shadow: 3px 3px 4px #888;}
    table.infotable { border-collapse: collapse; border: 1px solid #CCB; width: 800px;   
                      -moz-box-shadow: 3px 3px 4px #888; -webkit-box-shadow: 3px 3px 4px #888; box-shadow: 3px 3px 4px #888; }
    td.infotable_title {  background: #990000; text-align: left; color: #FDFDFD; padding: 2px; font-size:13px;  }
    td.infotable_coltitle { text-decoration: none; text-align: center; font-weight: bold; background: #dddddd; }
    td.pictable_cell { text-decoration: none; text-align: center; width: 200px; padding: 3px; }
    td.pictable_kommentar { text-decoration: none; text-align: center; padding: 3px; }
    td.pictable_heading { text-decoration: none; text-align: center; padding: 3px; font-weight: bold; }
    td.spectable_kat { text-decoration: none; text-align: left; font-weight: bold; }
    td.spectable_info { text-decoration: none; text-align: left; }
    textarea.texteditclass { width:750 !important; }
</style>

<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" >

/*
// korriger image paths hvis de er relative
$('.large-image > img').each(function(){
     var msrc=$(this).attr('src');
     var isAbsolute = new RegExp('^([a-z]+://|//)');

    if (! isAbsolute.test(msrc)) {
        // add a ../ to the path
        msrc = "../" + msrc;
        $(this).attr('src', msrc);
    }
})
*/
</script>
<form name="add" method="post" action="index.php?s=3&p=4">
<TABLE class="admtable1">
			<TR>
			      <td WIDTH="90">
			         <select name="land" onChange="this.form.submit()">
			         <option>Velg land</option>
	<?php while ( $liste = $result->fetch_array() ) {	         
             echo '<option value="'; echo $liste[0]; echo '"'; if ($liste[0]==$land) {echo ' selected';} echo '>'; echo $liste[2]; 
             echo '</option>';
							}  ?>
			         </select> <br>&nbsp;
			      </td>
			      <td width="40" align="center">
			        
			      </td>
			      <td WIDTH="250">
	<?php
	if ($land != 0) {
		$query ="SELECT * FROM gal_kategori WHERE natid = '$land' ORDER BY plass ASC";
		$result = $db->query($query);	      
	?>		      
			         <select name="cat" onChange="this.form.submit()">
			         <option>Velg kategori</option>
	<?php while ( $liste1 = $result->fetch_array() ) {		         
             echo '<option value="'; echo $liste1[0]; echo '"'; if ($liste1[0]==$cat) {echo ' selected';} echo '>'; echo $liste1[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=2&amp;l=<?php echo $land; ?>">rediger</a> 
			         <?php }  ?>
			      </td>
			      <td>
	<?php
	if ($cat != 0) {
		$query ="SELECT * FROM gal_type WHERE katid = '$cat' ORDER BY plass ASC";
		$result = $db->query($query);	      
	?>		      
			         <select name="type" onChange="this.form.submit()">
			         <option>Velg type</option>
	<?php while ( $liste2 = $result->fetch_array() ) {			         
             echo '<option value="'; echo $liste2[0]; echo '"'; if ($liste2[0]==$type) {echo ' selected';} echo '>'; echo $liste2[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=3&amp;l=<?php echo $land; ?>&amp;c=<?php echo $cat; ?>">rediger</a> 
			         <?php }  ?>
					 
			      </td>
			 </TR>
</table>
</form>
<?php
 if ($land!=0 && $cat!=0 && $type!=0) {
?>
<?php
if (isset($type)) {
$typenavn = $db->query("select typename from gal_type where typeid = '$type'")->fetch_object()->typename;
echo "<h2>",$typenavn."</h2>";
}
?>


<form name="add" method="post" action="adm_unit_add.php">
<table cellpadding="3" cellspacing="0" class="admtable1">
			<TR>
			      <td WIDTH="350" >
			         <input type="text" name="nyunit" style="width:340px;" value="nyt nummer" />
			      </td>
			      <td WIDTH="90">
			         plasser etter nr. 
			      </td>
			      <td width="40" align="center">
			        <input type="text" name="seq" style="width: 30px;" />
			      </td>
			      <td >
			         <input type="submit" value="legg til" />
			      </td>
			 </TR>
</table>
<input type="hidden" name="land" value="<?php echo $land; ?>" />
<input type="hidden" name="cat" value="<?php echo $cat; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
</form> 	
<br />



<!-- lag dialoger for endring av information -->
<!-- Tabell dialog -->
<div id="dialog" title="Endre informasjon" style="display: none">
    <div id="endre_tittel">Ny tittel:  <input type="text" id="nytittel" name="nytittel" value=""> (blank endrer ikke tittel)<br></div>
    <div id="editor"><p>Tom dialog</p></div>

</div>

<!-- Tekst dialog -->
<div id="textdialog" title="Endre tekst" style="display: none">
    <div id="endre_tittel_tekst">Endre tittel:  <input type="text" id="tekstnytittel" name="tekstnytittel" value=""> (blank endrer ikke tittel)<br></div>
    <textarea id="texteditarea" name="texteditarea" class="texteditclass" rows="10" cols="20" tyle="width:100%; height:200px"></textarea>
</div>


<script type="text/javascript"  src="infoeditutils.js"></script>
<script type="text/javascript" > 
    INFOEDITUTILS.init("<?php echo $land; ?>","<?php echo $cat; ?>","<?php echo $type; ?>");
</script>

<?php

include 'infoeditutils.php';
include ('../info_utils.php');

// forhaandsdefinerte verdier som kan brukes som startpunkt naar info lages
$DEFS = array(
    "techspectype"    => array( "tittel"=>"Spesifikasjoner", "tabell"=>array( "Bygget av"=>"", "Bygget antall"=>"", "Nummer"=>"", "Byggeår"=>"", "Største hastighet"=>"", "Motor"=>"", "Ytelse"=>"","Lengde o.b."=>"","Adhesjonsvekt"=>"","Akselanordning"=>"","Akseltrykk"=>"","Anmerkning/bevart"=>"","EVN-typenummer"=>"")),  
    "techspecunit"    => array( "tittel"=>"Tekniske Spesifikasjoner", "tabell"=>array( "Bygget av"=>"", "Bygget antall"=>"", "Byggeår"=>"", "Største hastighet"=>"", "Banemotorer"=>"", "Ytelse"=>"","Trekkkraft"=>"","Lengde o.b."=>"","Vekt"=>"","Akselanordning"=>"","Akseltrykk"=>"","Annet"=>"")),  
    "beskrivelse" => array( "tittel"=>"Beskrivelse", "tekst" => ""),
    "tekntegn"     => array( "tittel"=>"Tekniske tegninger", "bilder" => array( array( "heading"=>"", "url" => "", "thumb"=>"", "kommentar"=>"") ) ),
    "relsider" => array( "tittel"=>"Relaterte sider", "urls" => array( array( "url"=>"", "kommentar"=>""))),
);

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

// dette er informasjonsstrukturen som vises, lastes fra db og modifiseres av bruker
$infostruct = array();

//
//  makeInfoType
//

abstract class EditorType {
    const EDITOR_TABLE = 1;
    const EDITOR_TEXT = 2;
}

function makeDefaultInfoStruct($type) {
    global $DEFS;
    switch($type) {
        case "spectable":
            $info = $DEFS["techspectype"];
            return $info;
            break;
        case "tekntegn":
            $info = $DEFS["tekntegn"];
            return $info;
            break;
        case "infobilder":
            $info = $DEFS["tekntegn"];
            $info["tittel"] = "Informasjonsbilder";
            return $info;
            break;
        case "beskrivelse":
            $info = $DEFS["beskrivelse"];
            return $info;
            break;
        case "historikk":
            $info = $DEFS["beskrivelse"];
            $info["tittel"] = "Historikk";
            $info["tekst"] = "";
            return $info;
            break;
        case "designhist":
            $info = $DEFS["tekntegn"];
            $info["tittel"] = "Designhistorie";
            return $info;
            break;
        case "bildeserie":
            $info = $DEFS["tekntegn"];
            $info["tittel"] = "Bildeserie";
            return $info;
            break;
        case "divbilder":
            $info = $DEFS["tekntegn"];
            $info["tittel"] = "Diverse bilder";
            return $info;
            break;
        case "diverse":
            $info = $DEFS["beskrivelse"];
            $info["tittel"] = "Diverse";
            $info["tekst"] = "";
            return $info;
            break;
        case "relsider":
            $info = $DEFS["relsider"];
            return $info;
            break;
    }
}

function makeInfoType($infostruct, $type, $title, $editortype ) {

    if(isset($infostruct[$type])) { //array_key_exists($type,$infostruct)) {
        $title = $infostruct[$type]["tittel"];
        $info = $infostruct[$type];
    } else {
        $info = makeDefaultInfoStruct($type);
    }
    
    echo '<h2 class="info_type_heading">'.$title."</h2>\n\n";

    if($editortype!=EditorType::EDITOR_TABLE && $editortype!=EditorType::EDITOR_TEXT) {
        echo "Illegal editor type ".$editortype."<br>";
    }
    
    //var_dump($info);echo "<br>";
    //var_dump($infostruct[$type]);echo "<br>";
    //echo "<br>info $type = ".$info["tittel"]." <br>";
    
    try { 
        echo '<div class="info_type_content">';
        if(isset($infostruct[$type])) {
            if($editortype==EditorType::EDITOR_TABLE) {
                echo infoToHTMLTable($infostruct[$type]);
            } else if($editortype==EditorType::EDITOR_TEXT) {
                echo infoToHTMLText($infostruct[$type]);
            } 
        }
        echo "\n";
        printf( '<p style="margin: 15px 0px 10px 0px;" ><a href="#" id="dialog-link-%s" class="ui-state-default ui-corner-all dialog-link-class"><span class="ui-icon ui-icon-newwin"></span>Endre</a>',$type);
        echo "\n&nbsp;&nbsp;&nbsp;&nbsp;\n";
        printf( '<a href="#" id="dialog-link-delete-%s" class="ui-state-default ui-corner-all dialog-link-class"><span class="ui-icon ui-icon-closethick"></span>Slett</a></p>',$type);

        echo "</div>";
        
        echo '<script type="text/javascript">
    
$( "#dialog-link-';
        echo $type;
        echo '" ).click(function( event ) {
    try {
';
        echo "        var infotype = \"".$type."\";\n";
        echo "        var title = \"".addslashes($title)."\";\n";
        if($editortype==EditorType::EDITOR_TABLE) {
            echo '        var x = \'';
            echo str_replace("\n","",infoToEditableGrid($info,$type));
            echo '\'; 
        makeEditableTable(x,infotype,title);
        ';
            
        } else if($editortype==EditorType::EDITOR_TEXT) {
            echo '         var x = \'';
            echo str_replace("\n","",infoToEditableText($info));
            echo '\';
        makeEditableText(x,infotype,title);
         ';
       } 

        echo '
    } catch(err) {
        alert(err.toString());
    }
';
    
    if($editortype==EditorType::EDITOR_TABLE) {        
        echo '    $( "#dialog" ).dialog( "open" );'."\n";
    } else if($editortype==EditorType::EDITOR_TEXT) {
        echo '    $( "#textdialog" ).dialog( "open" );'."\n";
    } 
        
    echo '    event.preventDefault();
});
';
        
        echo '
$( "#dialog-link-delete-';
        echo $type;
        echo '" ).click(function( event ) {
';
        echo "   var infotype = \"".$type."\";\n";
        echo "   var title = \"".addslashes($title)."\";\n";
        echo '   deleteTypeInfo(infotype,title);
   event.preventDefault();
}); 
    
</script>';
    echo "<br/>\n";
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

}

//
//   MAIN
//        
	$query ="SELECT info, infostruct, info_deleted FROM `gal_type` WHERE typeid = '$type'";
        
        // gammel info tekst
	$info = $db->query($query)->fetch_object()->info;
        $info_deleted = $db->query($query)->fetch_object()->info_deleted;
        
        // ny JSON formatert infostruct
	$dbinfostruct = $db->query($query)->fetch_object()->infostruct;
        $dbi = getInfoFromDbString($dbinfostruct);
        if(isset($dbi)) {
            //echo "<xmp style=\"white-space:pre-wrap; word-wrap:break-word;\">$dbinfostruct</xmp><br>";
            //var_dump($dbi);
            //echo "<br>";
            //echo "json error code: " .json_last_error();
            //echo "<br>";
            $infostruct = $dbi;
        } else {
            //echo json_last_error_msg();
            //echo "<br>";
            $infostruct = array();
        }

        
        //echo "<xmp>$info</xmp><br>";
        //echo "<xmp>Info deleted $info_deleted</xmp><br>";
                
        if($info_deleted) {
            unset($info);
        }
        
        if(isset($info)) {
            decodeOldTypeInfo($infostruct,$info);                
        }

/*
        // testdata
        if(!array_key_exists("beskrivelse", $infostruct)) {
            $infostruct["beskrivelse"] = $DEFS["beskrivelse"];
            $infostruct["beskrivelse"]["tittel"] = "Beskrivelse **test data, ikke lagret**";
        }
        if(!array_key_exists("tekntegn", $infostruct)) {
            $infostruct["tekntegn"] = $DEFS["tekntegn"];
            $infostruct["tekntegn"]["tittel"] = "Tekniske tegninger **test data, ikke lagret**";
            $infostruct["tekntegn"]["bilder"][0]["heading"] = "F&oslash;rste";
            $infostruct["tekntegn"]["bilder"][0]["url"] = "../norge/136-3686_IMG.JPG";
            $infostruct["tekntegn"]["bilder"][0]["thumb"] = "../norge/thumb_136-3686_IMG.JPG";
            $infostruct["tekntegn"]["bilder"][0]["kommentar"] = "Test bilde";
            $infostruct["tekntegn"]["bilder"][1]["heading"] = "Andre";
            $infostruct["tekntegn"]["bilder"][1]["url"] = "../norge/137-3764_IMG.JPG";
            $infostruct["tekntegn"]["bilder"][1]["thumb"] = "../norge/thumb_137-3764_IMG.JPG";
            $infostruct["tekntegn"]["bilder"][1]["kommentar"] = "Test bilde 2 (C) 2011";
        }
        if(!array_key_exists("relsider", $infostruct)) {
            $infostruct["relsider"] = $DEFS["relsider"];
            $infostruct["relsider"]["tittel"] = "Relaterte sider **test data, ikke lagret**";
            $infostruct["relsider"]["urls"][0]["url"] = "http://info.sider.com/tog.html";
            $infostruct["relsider"]["urls"][0]["kommentar"] = "Her finner du mye mer info";
        }
 */       
        //echo "Json encoded: ".json_encode($infostruct,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_QUOT)."<br>";
        //$json_infostruct = json_encode($infostruct,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_QUOT);

// lag liste over forskjellige tilgjengelige info opsjoner
        //echo '<div style="float:right; margin: 40px 0px 0px 0px;">';
        //echo '<input type="button" value="Slett all informasjon" onClick="deleteTypeInfo()" style="font-weight: bold; color: red; padding: 3px 10px 3px 10px; " />';
        //echo '</div>';
        echo '<h1 class="info_heading">Typeinformasjon</h1>'."\n\n";
        
        // TODO: Fix disse knappene, ser ikke bra ut
        echo '<input type="button" value="Forh&aring;ndsvisning" onClick="previewInfo()" 
            style="font-weight: bold; color: black; padding: 3px 10px 3px 10px; margin: 40px 0px 0px 230px" />'."\n";
        echo '<input type="button" value="Slett all informasjon" onClick="deleteTypeInfo()" 
            style="font-weight: bold; color: red; padding: 3px 10px 3px 10px; margin: 40px 0px 0px 40px" />'."\n";

        
        global $infostruct;

        makeInfoType($infostruct, "spectable", "Spesifikasjon", EditorType::EDITOR_TABLE );

        makeInfoType($infostruct, "infobilder", "Informasjonsbilder", EditorType::EDITOR_TABLE );
        
        makeInfoType($infostruct, "tekntegn", "Teknisk tegning", EditorType::EDITOR_TABLE );

        makeInfoType($infostruct, "beskrivelse", "Beskrivelse", EditorType::EDITOR_TEXT );
        
        makeInfoType($infostruct, "historikk", "Historikk", EditorType::EDITOR_TEXT );
        
        makeInfoType($infostruct, "designhist", "Designhistorie", EditorType::EDITOR_TABLE );

        makeInfoType($infostruct, "bildeserie", "Bildeserie", EditorType::EDITOR_TABLE );

        makeInfoType($infostruct, "diverse", "Diverse", EditorType::EDITOR_TEXT );
        
        makeInfoType($infostruct, "divbilder", "Diverse bilder", EditorType::EDITOR_TABLE );

        makeInfoType($infostruct, "relsider", "Relaterte sider", EditorType::EDITOR_TABLE );
  
?>        
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        selector : "typeinfo",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
<?php

        if(!empty($info) && strlen($info)>0 ) {
?>
  
<br/>
<br/>
                
<input type="button" value="Slett gammel info/beskrivelse (nedenfor)" onClick="deleteOldTypeInfo()" style="font-weight: bold; color: red; padding: 3px 10px 3px 10px; " />
<br/>
<br/>

<p><b>Gammel beskrivelse (kan ikke lenger endres, og kan fjernes n&aring;r den er kopiert over i ny struktur (over)):</b></p>
<?php
  // tiny-mce start
?>

<?php
 // tinymce ned - the textarea name has to be typeinfo
?>
<form name="typeinfoform" method="post" action="adm_typeinfo_set.php">

<textarea rows="20" cols="20" name="typeinfo" style="width:100%; height:550px"><?php echo $info; ?></textarea>

<input type="hidden" name="land" value="<?php echo $land; ?>" />
<input type="hidden" name="cat" value="<?php echo $cat; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />

</form>
<br />

<input type="button" value="Slett gammel type info/beskrivelse (ovenfor)" onClick="deleteOldTypeInfo()" style="font-weight: bold; color: red; padding: 3px 10px 3px 10px; " />
<br />
<br />

<?php 
        } // end if(!empty($info) && strlen($info)>0 )

?>

<form name="updateform" action="adm_unit_update.php" method="post">
<table cellpadding="3" cellspacing="0" class="admtable">
   <tr>
      <td width="40" valign=top>
         <b>plass</b>
      </td>
      <td width="400" valign=top>
         <b>Nummer</b>
      </td>
      <td valign="top" width="40" >
         <b>Info</b>
      </td>
      <td valign="top" width="40" >
         <b>slette</b>
      </td>
 </tr>

<script type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=400px,width=820px');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>



<?PHP
$n=1;
$query = "SELECT * FROM `gal_unit` WHERE typeid = '$type' ORDER BY plass";
$result = $db->query($query);
while ( $liste3 = $result->fetch_array() ) {
?>



<tr id="<?php echo $liste3[0]; ?>" class="anchor">

  <td width="40">
	 <input type="text" name="s<?PHP echo $n; ?>" style="width: 30px; border: 0px;" value="<?PHP echo $liste3[3]; ?>" />
  </td>
  <td width="250">
    <input type="text" name="t<?PHP echo $n; ?>" style="width: 390px; border: 0px;" value="<?PHP echo $liste3[1]; ?>" />
    <input type="hidden" name="i<?PHP echo $n; ?>" value="<?PHP echo $liste3[0]; ?>" />
  </td>
  <td width="40">
     <a href="#" onClick="popitup('adm_unitinfo.php?l=<?php echo $land; ?>&c=<?php echo $cat; ?>&t=<?php echo $type; ?>&u=<?php echo $liste3[0]; ?>')" style="color: blue;">info</a>
  </td>
  <td width="40">
     <a href="#" onClick="window.location.href='adm_unit_delcheck.php?l=<?php echo $land; ?>&c=<?php echo $cat; ?>&t=<?php echo $type; ?>&u=<?php echo $liste3[0]; ?>&u=<?php echo $liste3[0];?>'" style="color: blue;">slett</a>

  </td>

</tr>	 

<?PHP
$n=$n+1;
}
?>	
</TABLE>
<br>
<input type="HIDDEN" name="land" value="<?php echo $land; ?>" />
<input type="hidden" name="cat" value="<?php echo $cat; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<input type="hidden" name="antal" value="<?php echo $n; ?>" />
<input type="submit" value="  oppdatere endringer  " />
</form>

<br><br>
 	
<?php 	
 	}   // slut if begge variable er sat
?>
