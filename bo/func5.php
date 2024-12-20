<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierSeventeen()
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
if($_GET['func'] == "drop_17" && isset($_GET['func'])) { 
   drop_17($_GET['drop_var']);
  
 
     
   }
} 


function drop_17($drop_var)
{  
    echo '<select name="drop_18" id="drop_18">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';

    include('configi.php');
    
	$query = "SELECT * FROM gal_kategori WHERE natID = '$drop_var' ORDER BY 4";
	$result = $db->query($query);
	while ( $drop_18 = $result->fetch_array() ) {
			  echo '<option value="'.$drop_18[0].'">'.$drop_18[1].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_18').hide();
	$('#drop_18').change(function(){
	  $('#wait_18').show();
	  $('#result_18').hide();
      $.get(\"func5.php\", {
		func: \"drop_18\",
		drop_var: $('#drop_18').val()
      }, function(response){
        $('#result_18').fadeOut();
        setTimeout(\"finishAjax_tier_nineteen('result_18', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_18" && isset($_GET['func'])) { 
   drop_18($_GET['drop_var']);
      
} 
}

function drop_18($drop_var)
{  
    echo '<select name="drop_19" id="drop_19">
	      <option value=" " disabled="disabled" selected="selected">Velg type</option>';     
	      
	include_once('configi.php');
	
	$query = "SELECT * FROM gal_type WHERE katID='$drop_var' ORDER BY 6";
	$result = $db->query($query);	      
	while ( $drop_19 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_19[0].'">'.$drop_19[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_19').hide();
	$('#drop_19').change(function(){
	  $('#wait_19').show();
	  $('#result_19').hide();
      $.get(\"func5.php\", {
		func: \"drop_19\",
		drop_var: $('#drop_19').val()
      }, function(response){
        $('#result_19').fadeOut();
        setTimeout(\"finishAjax_tier_twenty('result_19', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}  
   
   
//**************************************
//     Third selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_19" && isset($_GET['func'])) { 
   drop_19($_GET['drop_var']);
} 
}

function drop_19($drop_var)
{  
    echo '<select name="drop_20" id="drop_20">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unit WHERE typeID='$drop_var' ORDER BY 4";
	$result = $db->query($query);
	
	while ( $drop_20 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_20[0].'">'.$drop_20[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   echo "<script type=\"text/javascript\">
$('#wait_20').hide();
	$('#drop_20').change(function(){
	  $('#wait_20').show();
	  $('#result_20').hide();
      $.get(\"func5.php\", {
		func: \"drop_20\",
		drop_var: $('#drop_20').val()
      }, function(response){
        $('#result_20').fadeOut();
        setTimeout(\"finishAjax_tier_twentyone('result_20', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";   
}

//**************************************
//     Fourth selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_20" && isset($_GET['func'])) { 
   drop_20($_GET['drop_var']);
} 
}

function drop_20($drop_var)
{  
    echo '<select name="drop_20_1" id="drop_20_1">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unitdetail WHERE numID='$drop_var' ORDER BY 5";
	$result = $db->query($query);
	
	while ( $drop_21 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_21[0].'">'.$drop_21[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>