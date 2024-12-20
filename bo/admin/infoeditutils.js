
// verdier som brukes naar info oppdateres
var setting_infotype = "";  // settes ved dialog editor opprettelse
var setting_infotype_tittel = "";  // settes ved dialog editor opprettelse
var current_table_editor = null;  // settes ved opprettelse
var setting_land =  "";
var setting_kategori = "";
var setting_typeno = "";

var INFOEDITUTILS = INFOEDITUTILS || (function() {
    
    return { 
        init: function(l,k,t) {
            setting_land = l;
            setting_kategori = k;
            setting_typeno = t;
        }
    };
}());

$( "#dialog" ).dialog({
    autoOpen: false,
    width: 800,
    height: 400,
    buttons: [
            {
                text: "Cancel",
                click: function() {
                    $( this ).dialog( "close" );
                }
            },
            {
                text: "Ok",
                click: function() {
                    $( this ).dialog( "close" );
                    storeTableContents();
                }
            }
    ]
});

$( "#textdialog" ).dialog({
    autoOpen: false,
    width: 800,
    buttons: [
            {
                text: "Cancel",
                click: function() {
                    $( this ).dialog( "close" );
                }
            },
            {
                text: "Ok",
                click: function() {
                    $( this ).dialog( "close" );
                    storeTextContents();
                }
            }
    ]
});

function updateTypeInfo(jsonstring,infotype) {

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "adm_typeinfo_set.php");
    document.body.appendChild(form);

    var params = { land: setting_land, cat: setting_kategori, type: setting_typeno, infotypeid: infotype, typeinfo: jsonstring };

//alert(infotype + ":\n" + jsonstring);
    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    form.submit();
}


// infotype - type info f.eks. "beskrivelse"
//            ALLE_TYPEINFO = slett alle info data for denne typen
//            GAMMEL_INFO   = slett all gammel info for denne typen
function deleteTypeInfo(infotype,title) {

    infotype = infotype ? infotype : "ALLE_TYPEINFO";
    title = title ? title : "all informasjon om denne typen";

    var r = confirm("Dette vil slette '"+title+"'. Er dette OK?");
    if (r == false) {
        return;
    } 

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "adm_typeinfo_delete.php");
    document.body.appendChild(form);

    var params = { land: setting_land, cat: setting_kategori, type: setting_typeno, infotypeid: infotype };

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    form.submit();
}


// sletter gammel info 
function deleteOldTypeInfo() {
    deleteTypeInfo("GAMMEL_INFO","all gammel informasjon");
}

function previewInfo() {
    previewURL = 'typeinfo_preview.php?t='+setting_typeno;
    window.open(previewURL, '_blank', 'toolbar=0,location=0,menubar=0,scrollbars=yes,status=no,height=800,width=1100');
}

function isBlank(str) {
    return (!str || 0 === str.length || !str.trim());
}

// fjerner kommentarer som ((test data)) og ((automatisk dekodet)) fra tittel
function corrigerTittel(tittel) {
//    return tittel;
    return tittel.replace(/\s*\*\*.*\*\*\s*$/,"");
}

function htmlEscape(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function getTableValue(val) {
    if(!val || val.length==0) {
        return "";
    }
    val = val.replace(/<(\w)/,"< $1");    // fjern potensiell html kode, denne odelegger for tabelleditorenm
    val = val.replace(/<(\/\w)/,"< $1");  // fjern potensiell html kode, denne odelegger for tabelleditorenm
    return htmlEscape($('<div/>').text(val).html());
}


function storeTableContents() {
    //var editor = $("#tableeditor");
    var editor = current_table_editor;
    var infotype = setting_infotype;
    //alert(editor);
    //alert(JSON.stringify(editor));
    var d=  $('<div/>');
    var result;
    var info = {};
    var tittelel = document.getElementById("nytittel");
    var tittel = isBlank(tittelel.value) ? setting_infotype_tittel : tittelel.value;
    info["tittel"] = corrigerTittel(tittel);
    var tabell = {};
    var istabell = false;
    var bilder = [];
    var urls = [];
    for (i = 0; i < editor.getRowCount(); i++) {
        var row = editor.getRowValues(i);
        if( infotype=="spectable" ) {
            //tabell[htmlEscape(d.text(row['kat']).html())] = htmlEscape(d.text(row['val']).html());
            tabell[getTableValue(row['kat'])] = getTableValue(row['val']);
            istabell = true;
        } else if( infotype=="infobilder" || infotype=="tekntegn" || infotype=="designhist" || infotype=="bildeserie" || infotype=="divbilder" ) {
            var v = {};
            //console.log(row['heading']);
            //console.log(row['heading'].length);
            //v["heading"] = htmlEscape(d.text(d.text(row['heading']).html()));
            v["heading"] = getTableValue(row['heading']);
            v["url"] = d.text(row['url']).html();
            v["thumb"] = d.text(row['thumb']).html();
            //v["kommentar"] = htmlEscape(d.text(d.text(row['kommentar']).html()));
            v["kommentar"] = getTableValue(row['kommentar']);
            bilder.push(v);
        } else if( infotype=="relsider" ) {
            var v = {};
            v["url"] = d.text(row['url']).html();
            //v["kommentar"] = htmlEscape(d.text(d.text(row['kommentar']).html()));
            v["kommentar"] = getTableValue(row['kommentar']);
            urls.push(v);
        }
    }
    //alert("tabell " + istabell + " bilder " + bilder.length + " urls " + urls.length);
    if(istabell){
        info["tabell"] = tabell;
    }
    if(bilder.length>0){
        info["bilder"] = bilder;
    }
    if(urls.length>0){
        info["urls"] = urls;
    }
    updateTypeInfo(JSON.stringify(info),setting_infotype);

}

function storeTextContents() {
    var content = tinyMCE.get('texteditarea').getContent();
    var encoded = $('<div/>').text(content).html(); 
    //alert(encoded);
    var info = {};
    var tittelel = document.getElementById("tekstnytittel");
    var tittel = isBlank(tittelel.value) ? setting_infotype_tittel : tittelel.value;
    info["tittel"] = corrigerTittel(tittel);
    info["tekst"] = encoded;
    updateTypeInfo(JSON.stringify(info),setting_infotype);
}

function maketable() {
    //document.write('new EditableGrid<br>');
    editableGrid = new EditableGrid("DemoGridMinimal"); 
    //document.write('editableGrid.tableLoaded<br>');
    editableGrid.tableLoaded = function() { this.renderGrid("tablecontent", "editorgrid"); };
    //document.write('editableGrid.loadXML<br>');
    editableGrid.loadXML("editablegrid/examples/minimal/grid.xml");
    //document.appendChild(editableGrid);
    //editableGrid.renderGrid();
    return editableGrid;
} 

function addEditableTableRow(rowidx,before) {
    var newidx = current_table_editor.getRowCount()+1;
    if(before) {
        current_table_editor.insert(rowidx,newidx,[],null,false);
    } else {
        current_table_editor.insertAfter(rowidx,newidx,[],null,false);
    }
}

function makeEditableTable(jsonstring, infotype, title) {  
    setting_infotype = infotype;
    setting_infotype_tittel = title;
    
    var tittelel = document.getElementById("nytittel");
    tittelel.value = title;
    
    $('#dialog').dialog('option', 'title', 'Endre ' + title);
   
    //var x2 = xmlstring.replace(/(?:\\r\\n|\\r|\\n)/g,'\n');
    //alert(jsonstring);
    var decodedstr = $("<div />").html(jsonstring).text(); // TODO: FIX ikke godt nok for alle typer tekst.
    editableGrid = new EditableGrid("tableeditor"); 
    current_table_editor = editableGrid;

     //alert(decodedstr);
    editableGrid.loadJSONFromString(decodedstr);//($.parseJSON(xmlstring)); 
    
    // renderer for legg til og slett rad (knapper)
    editableGrid.setCellRenderer("slett", new CellRenderer({render: function(cell, value) { 
        cell.innerHTML = "<a onclick=\"if (confirm('&Oslash;nsker du virkelig &aring; slette denne raden? ')) editableGrid.remove(" + cell.rowIndex + ");\" style=\"cursor:pointer\">" +
                        "<img src=\"../img/delete.png\" border=\"0\" alt=\"slett\" title=\"Slett rad\"/></a>";
    }})); 
    editableGrid.setCellRenderer("radover", new CellRenderer({render: function(cell, value) { 
        cell.innerHTML = "<a onclick=\"addEditableTableRow(" + cell.rowIndex + ",true);\" style=\"cursor:pointer\">" +
                        "<img src=\"../img/document_insert_above.png\" border=\"0\" alt=\"radover\" title=\"Legg til rad over\"/></a>";
    }})); 
    editableGrid.setCellRenderer("radunder", new CellRenderer({render: function(cell, value) { 
        cell.innerHTML = "<a onclick=\"addEditableTableRow(" + cell.rowIndex + ",false);\" style=\"cursor:pointer\">" +
                        "<img src=\"../img/document_insert_below.png\" border=\"0\" alt=\"radunder\" title=\"Legg til rad under\"/></a>";
    }})); 
    
    editableGrid.renderGrid("editor", "editorgrid"); 
}

function makeEditableText(textstring, infotype, title) {
    setting_infotype = infotype;
    setting_infotype_tittel = title;
    
    var tittelel = document.getElementById("tekstnytittel");
    tittelel.value = title;
   
    //var decodedstr = $("<div />").html(textstring).text(); // TODO: FIX ikke godt nok for alle typer tekst.
    //alert(decodedstr);
//            oninit : "resizeTiny",
//            autoresize_min_height: 300,
//            autoresize_max_height: 700,

    tinyMCE.init({
            mode : "textareas",
            theme : "advanced",
            editor_selector : "texteditarea",
            plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            auto_focus : "texteditarea",
            resize: "both",
            
            //width: "600",
            //height: "800",
            //valid_elements : "i,sub,sup,b,u,p",
            //invalid_elements : "script, table",

            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
            theme_advanced_resizing_use_cookie : false,

            // Skin options
            skin : "o2k7",
            skin_variant : "silver",

            // Example content CSS (should be your site CSS)
            content_css : "infoedit.css",
            body_id: 'textinfo-tinymce-editor',
            
            // Replace values for the template plugin
            template_replace_values : {
                    username : "Some User",
                    staffid : "991234"
            }
    });
    tinyMCE.get('texteditarea').setContent(textstring, {format : 'raw'});
    tinyMCE.get('texteditarea').focus();
    tinyMCE.get('texteditarea').theme.resizeTo(780,400);
    $('#textdialog').dialog('option', 'title', 'Endre ' + title);
//    $( "#texteditarea" ).tinymce({
//		toolbar: 'link',
//		plugins: 'link'
//	});
}



