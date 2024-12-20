<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierNine()
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
if($_GET['func'] == "drop_9" && isset($_GET['func'])) { 
   drop_9($_GET['drop_var']);
  
 
     
   }
} 


function drop_9($drop_var)
{  
    echo '<select name="drop_10" id="drop_10">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';

    include('configi.php');
    
	$query = "SELECT * FROM gal_kategori WHERE natID = '$drop_var' ORDER BY 4";
	$result = $db->query($query);
	while ( $drop_10 = $result->fetch_array() ) {
			  echo '<option value="'.$drop_10[0].'">'.$drop_10[1].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_10').hide();
	$('#drop_10').change(function(){
	  $('#wait_10').show();
	  $('#result_10').hide();
      $.get(\"func3.php\", {
		func: \"drop_10\",
		drop_var: $('#drop_10').val()
      }, function(response){
        $('#result_10').fadeOut();
        setTimeout(\"finishAjax_tier_eleven('result_10', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_10" && isset($_GET['func'])) { 
   drop_10($_GET['drop_var']);
      
} 
}

function drop_10($drop_var)
{  
    echo '<select name="drop_11" id="drop_11">
	      <option value=" " disabled="disabled" selected="selected">Velg type</option>';     
	      
	include_once('configi.php');
	
	$query = "SELECT * FROM gal_type WHERE katID='$drop_var' ORDER BY 6";
	$result = $db->query($query);	      
	while ( $drop_11 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_11[0].'">'.$drop_11[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_11').hide();
	$('#drop_11').change(function(){
	  $('#wait_11').show();
	  $('#result_11').hide();
      $.get(\"func3.php\", {
		func: \"drop_11\",
		drop_var: $('#drop_11').val()
      }, function(response){
        $('#result_11').fadeOut();
        setTimeout(\"finishAjax_tier_twelve('result_11', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}  
   
   
//**************************************
//     Third selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_11" && isset($_GET['func'])) { 
   drop_11($_GET['drop_var']);
} 
}

function drop_11($drop_var)
{  
    echo '<select name="drop_12" id="drop_12">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unit WHERE typeID='$drop_var' ORDER BY 4";
	$result = $db->query($query);
	
	while ( $drop_12 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_12[0].'">'.$drop_12[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>