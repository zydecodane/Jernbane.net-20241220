<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link type="text/css" href="../stylesheet.css" rel="stylesheet" >

<link type="text/css" href="../datepicker/jquery-ui-1.8.17.custom.css" rel="stylesheet" />

<script type="text/javascript" src="../datepicker/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../datepicker/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="../datepicker/jquery.ui.datepicker-no.js"></script>

<title></title>
</head>
<body style="margin-left: 40px;"> 
    
<?php 

 include ('configi.php');
 $url=$_GET['url'];
 $dir=$_GET['dir'];

$slashpos = strrpos($url, "/");
$newfile = substr($url, ($slashpos+1));

?>

<!-- script for select-boxes --!>
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
</script>

<!--  script for validating date input  --!>
<script type="Text/JavaScript">
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
     }
</script>

<!-- script for datepicker --!>
		<script type="text/javascript">
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



<br />
<br />


<a href="<?php echo $url; ?>"> <img src="<?php echo $url; ?>"  width="350" /></a>
<br /><br />

<form action="filelist_cat_set.php" method="post" name="pics" enctype="multipart/form-data" onsubmit="return validate();">

<table cellpadding="1" cellspacing ="0" border="0" class="selecttable">
<tr>
  <td width="110">
    <b>Filnavn</b>
  </td>
  <td>
   <?php echo $newfile; ?>
   <input type="hidden" name="newfile" value="<?php echo $newfile; ?>" />
  </td>
 </tr>
<tr>
  <td width="110">
    <b>Fotograf</b>
  </td>
  <td>
   <input type="text" name="fotograf" style="width:200px" />
  </td>
 </tr>
 <tr>
  <td width="110">
    <b>Tekst</b>
  </td>
  <td>
   <input type="text" name="tekst" style="width:300px" />
  </td>
 </tr>
 <tr>
  <td width="110">
    <b>Dato</b>
  </td>
  <td>
   <input type="text" name="date1" id="datepicker1" style="width:80px" />
  </td>
 </tr>
</table>
<br />


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
    <img alt="Please Wait" src="../graphics/load.gif"/>
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
    <img alt="Please Wait" src="../graphics/load.gif"/>
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
    <img alt="Please Wait" src="../graphics/load.gif"/>
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
   <br />
  </td>
</tr>
<tr>
 <td width="110">
 <br />
  <input type="hidden" name="url" value="<?php echo $url; ?>" />
  <input type="hidden" name="dir" value="<?php echo $dir; ?>" />
  <input type="submit" value="OK" style="width: 100px;" />
 </td>
 <td>
   
   <br />
  </td>
</tr>
</table> 
</form>






<br /><br />
</center>
</body>
</html>

