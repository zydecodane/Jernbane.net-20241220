<?php

include('searchutil.php');

// *** Parameter decoding
$kat = getarg('kat');
$kateksakt = intval(getarg('kateksakt'));  // ==1 hvis kategori er eksakt lik teksten i db
$tu = getarg('tu');
$tueksakt = intval(getarg('tueksakt')); // ==1 hvis type/unit er eksakt lik teksten i db
$search = getarg('search');

?>
<script type="text/javascript" src="suggestlist.js"></script>

<!--
<script type="text/javascript" src="suggest/suggest.js"></script>
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jquery/jquery.contextMenu.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery.contextMenu.css" />
-->

<style type="text/css">
                    
        #suggest_kat {
          position: absolute;
          background-color: #FFFFFF;
          border: 1px solid #CCCCFF;
          width: 252px;
          margin-left:100px
        }
        #suggest_kat div {
          padding: 1px;
          display: block;
          width: 250px;
          overflow: hidden;
          white-space: nowrap;
        }
        #suggest_kat div.select{
          color: #FFFFFF;
          background-color: #3366FF;
        }
        #suggest_kat div.over{
          background-color: #99CCFF;
        }
        
        #suggest_tu {
          position: absolute;
          background-color: #FFFFFF;
          border: 1px solid #CCCCFF;
          width: 252px;
          margin-left:100px
       }
        #suggest_tu div {
          padding: 1px;
          display: block;
          width: 250px;
          overflow: hidden;
          white-space: nowrap;
        }
        #suggest_tu div.select{
          color: #FFFFFF;
          background-color: #3366FF;
        }
        #suggest_tu div.over{
          background-color: #99CCFF;
        }
        div.inputheader { 
            float: left; 
            width: 100px; 
            color:black; 
            font-weight:bold;
            color: #333333;
            margin: 4px 0px 0px 0px;
        }
        div.sokeform { 
            width: 920px; 
            color:black; 
            margin: 0px 0px 0px 0px;
        }
        p.sokinfo {
            width: 600px; 
            margin-left: 0px
          
        }
        table.sokeksempel {
            margin: 0px 0px 0px 0px; 
            border-collapse:collapse; 
            color: #333333;
        }
        table.sokeksempel td {
            color: #666666;
        }
        
</style>

<script type="text/javascript">
    
    var doneTypingInterval = 3000;  //time in ms, 1 second for example
    var max_disp = 30;
    var katTypingTimer;                //timer identifier
    var kat_forslag = null;
    var kat_resultat = [];
    var tuTypingTimer;                //timer identifier
    var tu_forslag = null;
    var tu_resultat = [];
<?php
    // verdi valgt av bruker fra forslagliste
    if($kateksakt==1) {
        echo '    var kat_value_selected = "'.$kat.'";'.PHP_EOL;  
    } else {
        echo '    var kat_value_selected = "";'.PHP_EOL;
    }

    // verdi valgt av bruker fra forslagliste
    if($tueksakt==1) {
        echo '    var tu_value_selected = "'.$tu.'";'.PHP_EOL;  
    } else {
        echo '    var tu_value_selected = "";'.PHP_EOL;
    }
?>

    var kat_gml_val = '';
    var tu_gml_val = '';
    function kat_handler() {
        //document.getElementById("freetext").value = "kat_handler ";
        var val = document.getElementById("kategori").value
        kat_gml_val = val;
        clearTimeout(katTypingTimer);
        katTypingTimer = setTimeout(kat_typing_done, doneTypingInterval);
    }
    
    function tu_handler() {
        //document.getElementById("freetext").value = "tu_handler ";
        var val = document.getElementById("tu").value
        tu_gml_val = val;
        clearTimeout(tuTypingTimer);
        tuTypingTimer = setTimeout(tu_typing_done, doneTypingInterval);
    }
 
   function kat_valselect(value) {
       kat_value_selected = value;
   }
   
   function tu_valselect(value) {
       tu_value_selected = value; 
       //alert("Verdi valgt '" + value + "'");
   }
   
   function typing_done( element, searchtype, searchcmd, forslag, resultat, inputid, suggestid, setval_callback) {
        if(element != document.activeElement) {
             //document.getElementById("freetext").value = searchtype + " ikke lenger aktiv element";
             return;
        }
        
        var val = element.value;
        
        if(!val || !val.trim() ) {
           //document.getElementById("freetext").value = searchtype + " tom";
           return; // empty string
        }
        
        val = val.trim();
        
        //alert("The value of the input field was changed - " + val);  
        //document.getElementById("freetext").value = "henter " + searchtype + " for " + val;
        
        $.get(searchcmd + encodeURIComponent(val), function(data) {
           //alert(data);
           
           if(forslag!=null) {
               forslag.remove();
               forslag = null;
           }
           
           resultat = data.split("<br/>");

           //document.getElementById("freetext").value = "resultat mottatt";
  
          if(resultat.length==0) {
             return; 
          }
            
          forslag = new SuggestList.Local(
            inputid,    // input element id.
            suggestid, // suggestion area id.
            resultat,      // suggest candidates list
            {dispMax: max_disp, callbackSetVal: setval_callback}); // options
         
        });
       
   }
   
    function kat_typing_done() {
        typing_done(document.getElementById("kategori"),"kategori",'search_cat.php?kat=',kat_forslag,kat_resultat,"kategori","suggest_kat",kat_valselect);
    }
    
    function tu_typing_done() {
        typing_done(document.getElementById("tu"),"type/enhet",'search_typeunit.php?tu=',tu_forslag,tu_resultat,"tu","suggest_tu",tu_valselect);
    }
    
    function performSearch() {
       //document.getElementById("freetext").value = "utfører søk";
       var kat = document.getElementById("kategori").value;
       var tu = document.getElementById("tu").value;
       var searchtxt = document.getElementById("freetext").value;
       var param = "";
       
       // Merk at noen felt har mellomrom foerst eller sist i navnet, saa trim() kan  ikke brukes for valgte verdier
       if(kat && kat.trim()) {
           if(kat==kat_value_selected) {
               param += "&kat=" + encodeURIComponent(kat) + "&kateksakt=1";
           } else {
               param += "&kat=" + encodeURIComponent(kat.trim());
           }
       }
       if(tu && tu.trim()) {
           if(tu==tu_value_selected) {
               param += "&tu=" + encodeURIComponent(tu) + "&tueksakt=1";
           } else {
               param += "&tu=" + encodeURIComponent(tu.trim());
           }
       }
       if(searchtxt && searchtxt.trim()) {
           param += "&search=" + encodeURIComponent(searchtxt.trim());
       }
       if(param=="") {
           alert("Du må skrive inn noen søkeparametre først");
           return;
       }
       document.location = "subpage.php?s=15" + param;
    }
    
    function resetForm() {
        document.getElementById("kategori").value = "";
        document.getElementById("tu").value = "";
        document.getElementById("freetext").value = "";
        kat_value_selected="";
        tu_value_selected="";
    }
    
</script>


<div id="gal_breadcrum">
<a href="../phorum/index.php" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Hjem</a> > <a href="<?php echo $path; ?>subpage.php?s=14" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Bildesøk</a>
<hr />
<a href="../bo/subpage.php?s=13" target="_parent"><img src="../bo/graphics/stoett.png" title="Støtt oss" alt="Støtt oss" /></a>
</div>

<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
		?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			Bildesøk
		</div>
		<div class="gal_content_white">





<div style="width:900px; margin: 0px 0px 0px 30px; " > 

<h1>S&oslash;k etter bilde</h1>

<p>Skriv inn s&oslash;keparametre i Kategori, Type/enhet og/eller S&oslash;ketekst feltene. En eller to parametre kan v&aelig;re tomme.</p>

<p>For eksempel: Kategori=<u>diesel nor</u>, Type/enhet=<u>di 3</u>, S&oslash;ketekst: <u>kongsvinger</u> 
    (s&oslash;k i alle norsk diesel kategorier etter bilder av Di3 lokomotiver p&aring; Kongsvinger). 
</p>
   
<br/>

<div align="right">
<!-- <input type="button" name="submit" value="T&oslash;m skjema" onclick="resetForm();"  style="width: 100px; text-align: center; margin: -10px 75px -10px 120px"/> -->
<input type="button" name="submit" value="T&oslash;m skjema" onclick="resetForm();"  class="button15cancel"/>
</div>

<br/>
<form action="subpage.php?s=2" method="post" name="searching" enctype="multipart/form-data">
    <div class="sokeform">
        <form name="forum" method="post" >
         <div  class="inputheader" >Kategori:</div> 
              <input type="text" id="kategori" name="kat" placeholder="Kategori (tom=alle kategorier)" 
                     style="width:790px;" value="<?php echo $kat; ?>" oninput="kat_handler();" onpropertychange="this.oninput();" autocomplete="off" /> <br/> <br/>
         <div id="suggest_kat" style="display:none;"></div>
         <div  class="inputheader" >Type/enhet:</div>  
              <input type="text" id="tu" name="tu" placeholder="Type/enhet (tom=alle typer/enheter)" 
                     value="<?php echo $tu; ?>" style="width:790px;"  oninput="tu_handler();" onpropertychange="this.oninput();" autocomplete="off" /> <br/> <br/>
         <div id="suggest_tu" style="display:none;"></div>
         <div  class="inputheader" >S&oslash;ketekst:</div>  
              <input type="text" id="freetext" name="freetext" placeholder="Text for s&oslash;k i alle felt (tom=alle bilder)" 
                     value="<?php echo $search; ?>" style="width:790px;" autocomplete="off" /> <br/>
         <br/>
         <center>
             <input type="button" name="submit" value="S&oslash;k" onclick="performSearch();" class="button15" />
         </center>
    </div>

</form> 
	<br/>
	<br/>
        <hr/>
        
        <p class="sokinfo">S&oslash;ket vil gj&oslash;res gjennom hele bildedatabasen.</p>
        
        <p class="sokinfo">Skriv et s&oslash;kekriterium inn i Kategori eller Type/enhet feltet, og vent noen sekunder. Kriteriet vil sjekker mot databasen, og et sett med valg vil 
            dukke opp. Velg et av dem hvis du &oslash;nsker &aring; s&oslash;ke etter en spesifikk kategori eller type/enhet, eller la det opprinnelige kriteriet st&aring; 
            dersom du vil s&oslash;ke p&aring; alle. Merk at kun de f&oslash;rste 30 treffene vil vises i popuplisten. (S&oslash;ket vil likevel gj&oslash;res mot alle matchende kategorier 
            og typer/enheter.)</p>
    
    <p class="sokinfo">Hvis du velger fra listen med forslag m&aring; Kategori eller Type/enhet eksakt matche den valgte verdien.</p>

    <p class="sokinfo">S&oslash;ketekst-feltet vil testes mot alle relevante felt i databasen, som fotograf navn, kamera modell, filnavn, jernbane.net brukernavn, info text osv. For eksempel "hansen arendal" 
        vil matche bilder som fotograf Hansen har tatt i Arendal.</p>
    
    <!--
    <p class="sokinfo">S&oslash;k skiller ikke mellom store og sm&aring; bokstaver</p>

    <p class="sokinfo">S&oslash;k vil matche alle tekststrenger, for eksempel <b>diesel norsk</b> vil s&oslash;ke etter strenger med b&aring;de diesel og norsk i seg. </p>

    <p class="sokinfo">For &aring; s&oslash;ke etter strenger med mellomrom m&aring; de puttes i kommentartegn ("), f.eks. <b>"norges statsbaner"</b></p>

    <p class="sokinfo">For &aring; s&oslash;ke etter strenger med kommentartegn (") i seg, m&aring; du bruke \", f.eks. <b>a=\"12\"</b> eller <b>"\"streng med mellomrom i kommentartegn\""</b></p>
    -->
    <p class="sokinfo"><b><i><u>Eksempler:</u></i></b></p>

    <table  class="sokeksempel" cellspacing="0" cellpadding="2" border="0" width="800px" >
        <tr style="border-bottom: 1px solid #000;">
            <td width="250px"><b>S&oslash;kestreng</b></td>
            <td><b>Resultat</b></td>
        </tr>
        
        <tr>
            <td valign="top">a</td>
            <td>Bilder som inneholder strengen <u>a</u> eller <u>A</u> (s&oslash;k skiller ikke mellom store og sm&aring; bokstaver)</td>
        </tr>

        <tr>
            <td valign="top">diesel danmark</td>
            <td>Bilder som inneholder b&aring;de strengen <u>diesel</u> og <u>danmark</u> (s&oslash;k m&aring; treffe p&aring; alle tekststrenger)</td>
        </tr>

        <tr>
            <td valign="top">"norges statsbaner"</td>
            <td>Bilder som inneholder strengen <u>Norges Statsbaner</u>. Tekst mellom "" (anf&oslash;rselstegn) tolkes som en streng, og "" m&aring; brukes 
                for &aring; s&oslash;ke etter strenger med mellomrom i.</td>
        </tr>
        
        <tr>
            <td valign="top">02.03.2006</td>
            <td>Bilder som er tatt <u>2.3.2006</u>. S&oslash;kestrengen matches ogs&aring; mot bilders dato felt. F&oslash;lgende datoformater er st&oslash;ttet: 
                <i>2.3.2014, 02.03.2014, 02032014</i> og <i>20140302</i>. Merk at bruk av enkeltnummer dager/m&aring;neder vil kunne f&aring; falske treff, f.eks. 2.3.2014 vil treffe 22.3.2014.</td>
            
        </tr>
        
        <tr>
            <td valign="top">bredde=\"1000\"</td>
            <td>Bilder som inneholder strengen <u>bredde="1000"</u>. For &aring; s&oslash;ke etter strenger med " (anf&oslash;rselstegn) i m&aring; <b>\</b> brukes.</td>
        </tr>

        <tr>
            <td valign="top">"norges statsbaner" "Maschinenbau Kiel" \"1600001\"</td>
            <td>Bilder som inneholder strengene <u>Norges Statsbaner</u>, <u>Maschinenbau Kiel</u> og <u>"1600001"</u>. Kombinasjoner av forskjellige 
                typer s&oslash;kestrenger er st&oslash;ttet.</td>
        </tr>

        <tr style="border-bottom: 1px solid #000;">
            <td valign="top"></td>
            <td></td>
        </tr>

    </table>

        <p class="sokinfo"><i>Eksemplene kan brukes i alle s&oslash;kefelt (Kategori, Type/enhet og S&oslash;ketekst)</i></p>

    </div>
<?php

?>


</div>
</div>
<br />
