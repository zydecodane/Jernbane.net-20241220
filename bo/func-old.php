<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierOne()
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
if($_GET['func'] == "drop_1" && isset($_GET['func'])) { 
   drop_1($_GET['drop_var']);
  
 
     
   }
} 


function drop_1($drop_var)
{  
	echo '<select name="drop_2" id="drop_2">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';

    include('configi.php');
    
	$query = "SELECT * FROM gal_kategori WHERE natID = '$drop_var' ORDER BY 4";
	$result = $db->query($query);
	while ( $drop_2 = $result->fetch_array() ) {
			  echo '<option value="'.$drop_2[0].'">'.$drop_2[1].'</option>';
			}    

	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_2').hide();
	$('#drop_2').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
      $.get(\"func.php\", {
		func: \"drop_2\",
		drop_var: $('#drop_2').val()
      }, function(response){
        $('#result_2').fadeOut();
        setTimeout(\"finishAjax_tier_three('result_2', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_2" && isset($_GET['func'])) { 
   drop_2($_GET['drop_var']);
      
} 
}

function drop_2($drop_var)
{  
    echo '<select name="drop_3" id="drop_3">
	      <option value=" " disabled="disabled" selected="selected">Velg type</option>';     
	      
	include_once('configi.php');
	
	$query = "SELECT * FROM gal_type WHERE katID='$drop_var' ORDER BY 6";
	$result = $db->query($query);	      
	while ( $drop_3 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_3[0].'">'.$drop_3[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_3').hide();
	$('#drop_3').change(function(){
	  $('#wait_3').show();
	  $('#result_3').hide();
      $.get(\"func.php\", {
		func: \"drop_3\",
		drop_var: $('#drop_3').val()
      }, function(response){
        $('#result_3').fadeOut();
        setTimeout(\"finishAjax_tier_four('result_3', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}  
   
   
//**************************************
//     Third selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_3" && isset($_GET['func'])) { 
   drop_3($_GET['drop_var']);
} 
}

function drop_3($drop_var)
{  
    echo '<select name="drop_4" id="drop_4">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
	      
	include_once('configi.php');

	$query = "SELECT * FROM gal_unit WHERE typeID='$drop_var' ORDER BY 4";
	$result = $db->query($query);
	
	while ( $drop_4 = $result->fetch_array() ) { 
			  echo '<option value="'.$drop_4[0].'">'.$drop_4[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>