<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierThirteen()
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
if($_GET['func'] == "drop_13" && isset($_GET['func'])) { 
   drop_13($_GET['drop_var']);
  
 
     
   }
} 


function drop_13($drop_var)
{  
    echo '<select name="drop_14" id="drop_14">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';

    include('configi.php');
    
	$query = "SELECT * FROM gal_kategori WHERE natID = '$drop_var' ORDER BY 4";
	$result = $db->query($query);
	while ( $drop_14 = $result->fetch_array() ) {
			  echo '<option value="'.$drop_14[0].'">'.$drop_14[1].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_14').hide();
	$('#drop_14').change(function(){
	  $('#wait_14').show();
	  $('#result_14').hide();
      $.get(\"func4.php\", {
		func: \"drop_14\",
		drop_var: $('#drop_14').val()
      }, function(response){
        $('#result_14').fadeOut();
        setTimeout(\"finishAjax_tier_fifteen('result_14', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_14" && isset($_GET['func'])) { 
   drop_14($_GET['drop_var']);
      
} 
}

function drop_14($drop_var)
{  
    echo '<select name="drop_15" id="drop_15">
	      <option value=" " disabled="disabled" selected="selected">Velg type</option>';     
	      
	include_once('configi.php');
	
	$query = "SELECT * FROM gal_type WHERE katID='$drop_var' ORDER BY 6";
	$result = $db->query($query);	      
	while ( $drop_15 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_15[0].'">'.$drop_15[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_15').hide();
	$('#drop_15').change(function(){
	  $('#wait_15').show();
	  $('#result_15').hide();
      $.get(\"func4.php\", {
		func: \"drop_15\",
		drop_var: $('#drop_15').val()
      }, function(response){
        $('#result_15').fadeOut();
        setTimeout(\"finishAjax_tier_sixteen('result_15', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}  
   
   
//**************************************
//     Third selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_15" && isset($_GET['func'])) { 
   drop_15($_GET['drop_var']);
} 
}

function drop_15($drop_var)
{  
    echo '<select name="drop_16" id="drop_16">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unit WHERE typeID='$drop_var' ORDER BY 4";
	$result = $db->query($query);
	
	while ( $drop_16 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_16[0].'">'.$drop_16[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>