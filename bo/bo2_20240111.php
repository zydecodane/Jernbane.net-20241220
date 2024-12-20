<?php
$language='no';
if(isset($_GET['l'])) {$language=$_GET['l'];}   
?>
<br />
<div id="bo_heading" style="line-height:30px;">
   <span style="font-size: 16px;"><b>Bildeopplasting med selvsortering</b></span>
   <span class="version_no"><img src="graphics/filler.gif" width="20px" height="1px">v3.0</span>
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<?php
// check if user is logged in - find user in cookie
// if (isset($_COOKIE["bbuserid"]))
if (isset($_COOKIE['xf_user']))
{ $loggedin = 1;} else {$loggedin = 0;} 



//$userid = $_COOKIE["bbuserid"];

$usersession = $_COOKIE['xf_user'];
$slutpunkt = strpos($usersession, ',');
$userid=substr($usersession,0,$slutpunkt);

include ('configi.php');

$dbase2 =  'jernbane_net_db_xf';		
$db2 = new mysqli($dbserver, $dbuserid, $dbpw, $dbase2);
$db2->set_charset("utf8");
$username = $db2->query("select username from xf_user where user_id = '$userid'")->fetch_object()->username;
$premium = $db2->query("select user_id from xf_user WHERE `secondary_group_ids` like '%14%' and user_id = '$userid'")->fetch_object()->user_id;
 
if ($loggedin == 0)
{ // user is not logged in
?>
<div class="bo_intro">
  <br /><br />
  	<div style="font-size: 15pt; text-align: center;">
  	  Du er ikke innlogget. Du m&aring; v&aelig;re innlogget for &aring; kunne laste opp bilder. Log inn <a href="../forum/index.php">her</a>
	</div>
  <br /><br /><br />
</div>
<?php
}
elseif (!isset($premium)) { ?>
    <br /><br /> 
	<div style="font-size: 15pt; text-align: center;">
    Du er ikke Premium-bruker. Du m&aring; v&aelig;re Premium-bruker for &aring; kunne laste opp bilder. Registrer deg som bruker <a href="../forum/index.php">her</a>
	</div>
	<br /><br /><br />
<?php 
}
	 // user IS logged in  
else {
	
?>
<div class="bo_intro">
<br />
<?php

if ($language=='no') {  include ('howto_no.php'); }
else
{ include ('howto_en.php');  }

echo $tekst; ?>
<br /><br />
<?php
if ($language=='no') { ?><a href='subpage.php?s=61&amp;l=en'>English version</a> <?php }
else { ?><a href='subpage.php?s=61&amp;l=no'>norwegian version</a><?php }
?>
<br /><br />
</div>
<!--  script for validating date input  -->
<script>
           function isValidDate(sText) {
            var reDate = /(?:0[1-9]|[12][0-9]|3[01])\.(?:0[1-9]|1[0-2])\.(?:19|20\d{2})/;
           return reDate.test(sText);
    		}   		
          function validate() {
          if(document.getElementById('datepicker1').value != ''){
            var oInput1 = document.getElementById("datepicker1");
            if (isValidDate(oInput1.value)) {
           } else {
           if (document.getElementById('datepicker1').value != '')
            alert("Feil i datoformat - bilde 1"); return false;
            }
        }
            if(document.getElementById('datepicker2').value != ''){
            var oInput2 = document.getElementById("datepicker2");
            if (isValidDate(oInput2.value)) {
           } else {
           if (document.getElementById('datepicker2').value != '')
            alert("Feil i datoformat - bilde 2"); return false;
            }
        }
            if(document.getElementById('datepicker3').value != ''){
            var oInput3 = document.getElementById("datepicker3");
            if (isValidDate(oInput3.value)) {
           } else {
           if (document.getElementById('datepicker3').value != '')
            alert("Feil i datoformat - bilde 3"); return false;
            }
        }      
        	if(document.getElementById('datepicker4').value != ''){
            var oInput4 = document.getElementById("datepicker4");
            if (isValidDate(oInput4.value)) {
           } else {
           if (document.getElementById('datepicker4').value != '')
            alert("Feil i datoformat - bilde 4"); return false;
            }
        }
			if(document.getElementById('datepicker5').value != ''){
            var oInput5 = document.getElementById("datepicker5");
            if (isValidDate(oInput5.value)) {
           } else {
           if (document.getElementById('datepicker5').value != '')
            alert("Feil i datoformat - bilde 5"); return false;
            }
        }              
     }
</script>
<!-- script for datepicker --> 
		<script>
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker1" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker1" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		</script>	
<!--  datepicker 2 -->
<script>
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker2" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker2" ).datepicker( "option", "yearRange", '1960:ty' );
			});
</script>	
<!--  datepicker 3 -->
<script>
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker3" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker3" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		</script>
<!--  datepicker 4 -->
<script>
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker4" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker4" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		</script>		
<!--  datepicker 5 -->
<script>
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker5" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker5" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		</script>						
<!-- script for select-boxes -->
<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
      $.get("func.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

$(document).ready(function() {
	$('#wait_5').hide();
	$('#drop_5').change(function(){
	  $('#wait_5').show();
	  $('#result_5').hide();
      $.get("func2.php", {
		func: "drop_5",
		drop_var: $('#drop_5').val()
      }, function(response){
        $('#result_5').fadeOut();
        setTimeout("finishAjax5('result_5', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

$(document).ready(function() {
	$('#wait_9').hide();
	$('#drop_9').change(function(){
	  $('#wait_9').show();
	  $('#result_9').hide();
      $.get("func3.php", {
		func: "drop_9",
		drop_var: $('#drop_9').val()
      }, function(response){
        $('#result_9').fadeOut();
        setTimeout("finishAjax9('result_9', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

$(document).ready(function() {
	$('#wait_13').hide();
	$('#drop_13').change(function(){
	  $('#wait_13').show();
	  $('#result_13').hide();
      $.get("func4.php", {
		func: "drop_13",
		drop_var: $('#drop_13').val()
      }, function(response){
        $('#result_13').fadeOut();
        setTimeout("finishAjax13('result_13', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

$(document).ready(function() {
	$('#wait_17').hide();
	$('#drop_17').change(function(){
	  $('#wait_17').show();
	  $('#result_17').hide();
      $.get("func5.php", {
		func: "drop_17",
		drop_var: $('#drop_17').val()
      }, function(response){
        $('#result_17').fadeOut();
        setTimeout("finishAjax17('result_17', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_four(id, response) {
  $('#wait_3').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_five(id, response) {
  $('#wait_4').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax5(id, response) {
  $('#wait_5').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_seven(id, response) {
  $('#wait_6').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_eight(id, response) {
  $('#wait_7').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_nine(id, response) {
  $('#wait_8').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}

function finishAjax9(id, response) {
  $('#wait_9').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_eleven(id, response) {
  $('#wait_10').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_twelve(id, response) {
  $('#wait_11').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_thirteen(id, response) {
  $('#wait_12').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}

function finishAjax13(id, response) {
  $('#wait_13').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_fifteen(id, response) {
  $('#wait_14').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_sixteen(id, response) {
  $('#wait_15').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_seventeen(id, response) {
  $('#wait_16').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax17(id, response) {
  $('#wait_17').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_nineteen(id, response) {
  $('#wait_18').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_twenty(id, response) {
  $('#wait_19').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_twentyone(id, response) {
  $('#wait_20').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
</script>
</head>
<body>
<?php
// <iOS-detector>
$user_agent = getenv("HTTP_USER_AGENT");
if(strpos($user_agent, "iPhone") !== FALSE)
	{ $os = "iOS"; }
elseif(strpos($user_agent, "iPad") !== FALSE)
	{ $os = "iOS"; }
else
	{ $os = "other"; }
if ($os == "iOS")
{
?>	
	<script>
	 alert('Det ser ut som om du bes\370ker jernbane.net fra en iPhone eller iPad.\nLast derfor opp, kun et bilde av gangen.');
	</script>	
<?php	
}
// </iOS-detector>
?>
<br />

<script> 
<!-- 
function showMe (it, box) { 
var vis = (box.checked) ? "block" : "none"; 
document.getElementById(it).style.display = vis;
} 
//--> 
</script>

<form action="bo_process.php" method="post" name="pics" enctype="multipart/form-data" onsubmit="return validate();">

<div class="bo_frames">
<br />
	<input type="checkbox" name="gallery" value="0" onclick="{ showMe('div1', this);showMe('div2', this);showMe('div3', this);showMe('div4', this);showMe('div5', this) }" checked="checked"/>&nbsp;&nbsp;<b>Jeg vil gjerne ha bildene overført til galleriet</b>
	<br /><br />
</div>
<br />
<div class="bo_frames">
<br />

<!-- image 1 -->
<div class="bo_opplast_left">
<table cellspacing="0" cellpadding="1" border="0" width="530" class="selecttable">
<tr>
 <td width="100">
  <b>Bilde 1:</b>
 </td>
 <td>
   <input type="file" name="img[]" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Fotograf:</b>
 </td>
 <td>
   <input type="text" name="photographer1" value="<?php echo $username; ?>" style="width:130px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Bildetekst:</b>
 </td>
 <td>
   <input type="text" name="tekst1" style="width:380px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Dato for bilde:</b>
 </td>
 <td>
  <input type="text" name="date1" id="datepicker1" style="width:80px" />
 </td>
</tr>
</table> 
<br />
</div>


<div class="bo_opplast_right" >
	<div id="div1">

<table cellspacing="0" cellpadding="1" border="0" width="525" class="selecttable">
<tr>
 <td width="110">
 <b>Land:</b> 
 </td>
 <td>
  <select name="drop_1" id="drop_1">
    <option value="" selected="selected" disabled="disabled">Velg Land</option>
     <?php
     include('func.php'); 
     getTierOne(); 
     ?>
 </select>&nbsp;<span id="wait_1" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
  </td>
</tr>
<tr>
 <td width="110">
 <b>Kategori:</b> 
 </td>
 <td>
   <span id="result_1" style="display: none;"></span>&nbsp;
    <span id="wait_2" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>    <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Type/bane:</b> 
 </td>
 <td>
    <span id="result_2" style="display: none;"></span>&nbsp; 
    <span id="wait_3" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Nummer/sted:</b> 
 </td>
 <td>
   <span id="result_3" style="display: none;"></span>
    <span id="wait_4" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Detaljer:</b> 
 </td>
 <td>
   <span id="result_4" style="display: none;"></span>
   <br />
  </td>
</tr>
</table> 
	</div>
</div>
<br />
  <hr>
<br />
<!-- image 2 -->
<div class="bo_opplast_left">
<table cellspacing="0" cellpadding="1" border="0" width="530" class="selecttable">
<tr>
 <td width="100">
  <b>Bilde 2:</b>
 </td>
 <td>
   <input type="file" name="img[]" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Fotograf:</b>
 </td>
 <td>
   <input type="text" name="photographer2" value="<?php echo $username; ?>" style="width:130px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Bildetekst:</b>
 </td>
 <td>
   <input type="text" name="tekst2" style="width:380px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Dato for bilde:</b>
 </td>
 <td>
  <input type="text" name="date2" id="datepicker2" style="width:80px" />
 </td>
</tr>
</table> 
<br />
</div>

<div class="bo_opplast_right">
	<div id="div2">
<table cellspacing="0" cellpadding="1" border="0" width="525" class="selecttable" >
<tr>
 <td width="110">
 <b>Land:</b> 
 </td>
 <td>
  <select name="drop_5" id="drop_5">
    <option value="" selected="selected" disabled="disabled">Velg Land</option>
     <?php
     include('func2.php'); 
     getTierFive(); 
     ?>
 </select>&nbsp;<span id="wait_5" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
  </td>
</tr>
<tr>
 <td width="110">
 <b>Kategori:</b> 
 </td>
 <td>
   <span id="result_5" style="display: none;"></span>&nbsp;
    <span id="wait_6" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>    <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Type/bane:</b> 
 </td>
 <td>
    <span id="result_6" style="display: none;"></span>&nbsp; 
    <span id="wait_7" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Nummer/sted:</b> 
 </td>
 <td>
   <span id="result_7" style="display: none;"></span>
    <span id="wait_8" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Detaljer:</b> 
 </td>
 <td>
   <span id="result_8" style="display: none;"></span>
   <br />
  </td>
</tr>
</table>
	</div>
</div>
<br />
  <hr>
<br />
<!-- image 3 -->
<div class="bo_opplast_left">
<table cellspacing="0" cellpadding="1" border="0" width="530" class="selecttable">
<tr>
 <td width="100">
  <b>Bilde 3:</b>
 </td>
 <td>
   <input type="file" name="img[]" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Fotograf:</b>
 </td>
 <td>
   <input type="text" name="photographer3" value="<?php echo $username; ?>" style="width:130px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Bildetekst:</b>
 </td>
 <td>
   <input type="text" name="tekst3" style="width:380px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Dato for bilde:</b>
 </td>
 <td>
  <input type="text" name="date3" id="datepicker3" style="width:80px" />
 </td>
</tr>
</table> 
<br />
</div>

<div class="bo_opplast_right">
	<div id="div3">
<table cellspacing="0" cellpadding="1" border="0" width="525" class="selecttable">
<tr>
 <td width="110">
 <b>Land:</b> 
 </td>
 <td>
  <select name="drop_9" id="drop_9">
    <option value="" selected="selected" disabled="disabled">Velg Land</option>
     <?php
     include('func3.php'); 
     getTierNine(); 
     ?>
 </select>&nbsp;<span id="wait_9" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
  </td>
</tr>
<tr>
 <td width="110">
 <b>Kategori:</b> 
 </td>
 <td>
   <span id="result_9" style="display: none;"></span>&nbsp;
    <span id="wait_10" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>    <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Type/bane:</b> 
 </td>
 <td>
    <span id="result_10" style="display: none;"></span>&nbsp; 
    <span id="wait_11" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Nummer/sted:</b> 
 </td>
 <td>
   <span id="result_11" style="display: none;"></span>
    <span id="wait_12" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Detaljer:</b> 
 </td>
 <td>
   <span id="result_12" style="display: none;"></span>
   <br />
  </td>
</tr>
</table>
	</div>
</div>
<br />
  <hr>
<br />
<!-- image 4 -->
<div class="bo_opplast_left">
<table cellspacing="0" cellpadding="1" border="0" width="530" class="selecttable">
<tr>
 <td width="100">
  <b>Bilde 4:</b>
 </td>
 <td>
   <input type="file" name="img[]" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Fotograf:</b>
 </td>
 <td>
   <input type="text" name="photographer4" value="<?php echo $username; ?>" style="width:130px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Bildetekst:</b>
 </td>
 <td>
   <input type="text" name="tekst4" style="width:380px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Dato for bilde:</b>
 </td>
 <td>
  <input type="text" name="date4" id="datepicker4" style="width:80px" />
 </td>
</tr>
</table> 
<br />
</div>

<div class="bo_opplast_right">
	<div id="div4">
<table cellspacing="0" cellpadding="1" border="0" width="525" class="selecttable" />
<tr>
 <td width="110">
 <b>Land:</b> 
 </td>
 <td>
  <select name="drop_13" id="drop_13">
    <option value="" selected="selected" disabled="disabled">Velg Land</option>
     <?php
     include('func4.php'); 
     getTierThirteen(); 
     ?>
 </select>&nbsp;<span id="wait_13" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
  </td>
</tr>
<tr>
 <td width="110">
 <b>Kategori:</b> 
 </td>
 <td>
   <span id="result_13" style="display: none;"></span>&nbsp;
    <span id="wait_14" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>    <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Type/bane:</b> 
 </td>
 <td>
    <span id="result_14" style="display: none;"></span>&nbsp; 
    <span id="wait_15" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Nummer/sted:</b> 
 </td>
 <td>
   <span id="result_15" style="display: none;"></span>
    <span id="wait_16" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Detaljer:</b> 
 </td>
 <td>
   <span id="result_16" style="display: none;"></span>
   <br />
  </td>
</tr>

</table>
	</div>
</div>
<br />
  <hr>
<br />
<!-- image 5 -->
<div class="bo_opplast_left">
<table cellspacing="0" cellpadding="1" border="0" width="530" class="selecttable">
<tr>
 <td width="100">
  <b>Bilde 5:</b>
 </td>
 <td>
   <input type="file" name="img[]" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Fotograf:</b>
 </td>
 <td>
   <input type="text" name="photographer5" value="<?php echo $username; ?>" style="width:130px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Bildetekst:</b>
 </td>
 <td>
   <input type="text" name="tekst5" style="width:380px" />
 </td>
</tr>
<tr>
 <td width="100">
  <b>Dato for bilde:</b>
 </td>
 <td>
  <input type="text" name="date5" id="datepicker5" style="width:80px" />
 </td>
</tr>
</table> 
<br />
</div>

<div class="bo_opplast_right">
	<div id="div5">
<table cellspacing="0" cellpadding="1" border="0" width="525" class="selecttable" />
<tr>
 <td width="110">
 <b>Land:</b> 
 </td>
 <td>
  <select name="drop_17" id="drop_17">
    <option value="" selected="selected" disabled="disabled">Velg Land</option>
     <?php
     include('func5.php'); 
     getTierThirteen(); 
     ?>
 </select>&nbsp;<span id="wait_17" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
  </td>
</tr>
<tr>
 <td width="110">
 <b>Kategori:</b> 
 </td>
 <td>
   <span id="result_17" style="display: none;"></span>&nbsp;
    <span id="wait_18" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>    <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Type/bane:</b> 
 </td>
 <td>
    <span id="result_18" style="display: none;"></span>&nbsp; 
    <span id="wait_19" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Nummer/sted:</b> 
 </td>
 <td>
   <span id="result_19" style="display: none;"></span>
    <span id="wait_20" style="display: none;">
    <img alt="Please Wait" src="graphics/ajax-loader.gif"/>
    </span>
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <b>Detaljer:</b> 
 </td>
 <td>
   <span id="result_20" style="display: none;"></span>
   <br />
  </td>
</tr>

</table>
	</div>
</div>
<br />
  <hr>
<br />

<table callpadding="0" cellspacing="0" border="0" width="100%">
 <tr>
  <td width="100">
  </td>
  <td>
    <input type="hidden" name="user" value="<?php echo $userid; echo ' - '; echo $username; ?>" />
    <input type="submit" value="Last opp !" style="width: 200px;" />
  </td>
 </tr>
 </table> 
<br /><br />

</form>
<?php
}
?>
</div>
<br /><br />
