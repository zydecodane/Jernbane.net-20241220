<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierFive()
{
	include('configi.php');
	 $query = "SELECT * FROM gal_nations ORDER BY 6";
	 $result = $db->query($query);
	 
	while ( $tier = $result->fetch_array() ) {
		   echo '<option value="'.$tier[0].'">'.$tier[2].'</option>';
		}

}

//**************************************
//     First selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_5" && isset($_GET['func'])) { 
   drop_5($_GET['drop_var']);
  
 
     
   }
} 


function drop_5($drop_var)
{  
    echo '<select name="drop_6" id="drop_6">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';

    include('configi.php');
    
	$query = "SELECT * FROM gal_kategori WHERE natID = '$drop_var' ORDER BY 4";
	$result = $db->query($query);
	while ( $drop_6 = $result->fetch_array() ) {
			  echo '<option value="'.$drop_6[0].'">'.$drop_6[1].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_6').hide();
	$('#drop_6').change(function(){
	  $('#wait_6').show();
	  $('#result_6').hide();
      $.get(\"func2.php\", {
		func: \"drop_6\",
		drop_var: $('#drop_6').val()
      }, function(response){
        $('#result_6').fadeOut();
        setTimeout(\"finishAjax_tier_seven('result_6', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_6" && isset($_GET['func'])) { 
   drop_6($_GET['drop_var']);
      
} 
}

function drop_6($drop_var)
{  
    echo '<select name="drop_7" id="drop_7">
	      <option value=" " disabled="disabled" selected="selected">Velg type</option>';     
	      
	include_once('configi.php');
	
	$query = "SELECT * FROM gal_type WHERE katID='$drop_var' ORDER BY 6";
	$result = $db->query($query);	      
	while ( $drop_7 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_7[0].'">'.$drop_7[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_7').hide();
	$('#drop_7').change(function(){
	  $('#wait_7').show();
	  $('#result_7').hide();
      $.get(\"func2.php\", {
		func: \"drop_7\",
		drop_var: $('#drop_7').val()
      }, function(response){
        $('#result_7').fadeOut();
        setTimeout(\"finishAjax_tier_eight('result_7', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}  
   
   
//**************************************
//     Third selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_7" && isset($_GET['func'])) { 
   drop_7($_GET['drop_var']);
} 
}

function drop_7($drop_var)
{  
   echo '<select name="drop_8" id="drop_8">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unit WHERE typeID='$drop_var' ORDER BY 4";
	$result = $db->query($query);
	
	while ( $drop_8 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_8[0].'">'.$drop_8[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   echo "<script type=\"text/javascript\">
$('#wait_8').hide();
	$('#drop_8').change(function(){
	  $('#wait_8').show();
	  $('#result_8').hide();
      $.get(\"func2.php\", {
		func: \"drop_8\",
		drop_var: $('#drop_8').val()
      }, function(response){
        $('#result_8').fadeOut();
        setTimeout(\"finishAjax_tier_nine('result_8', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";   
}

//**************************************
//     Fourth selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_8" && isset($_GET['func'])) { 
   drop_8($_GET['drop_var']);
} 
}

function drop_8($drop_var)
{  
   echo '<select name="drop_8_1" id="drop_8_1">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unitdetail WHERE numID='$drop_var' ORDER BY 5";
	$result = $db->query($query);
	
	while ( $drop_9 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_9[0].'">'.$drop_9[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>