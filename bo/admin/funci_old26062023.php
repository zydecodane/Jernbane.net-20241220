<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getTierOne()
{
	include ('../configi.php');
	
	$query = "select * from gal_nations order by 6";
	$result = $db->query($query);
	while ($tier = $result->fetch_array()) 
		{
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
    include('../configi.php');
    
    $query = "select * from gal_kategori where natID = '$drop_var' order by 4";
	$result = $db->query($query);
	
	echo '<select name="drop_2" id="drop_2">
	      <option value=" " disabled="disabled" selected="selected">Velg Kategori</option>';
			
		while ($drop_2 = $result->fetch_array())	
			{
			  echo '<option value="'.$drop_2[0].'">'.$drop_2[1].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_2').hide();
	$('#drop_2').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
      $.get(\"funci.php\", {
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
    include_once('../configi.php');
        
    $query = "select * from gal_type where katID='$drop_var' order by 6";    
    $result = $db->query($query);

	echo '<select name="drop_3" id="drop_3">
	      <option value=" " disabled="disabled" selected="selected">Velg Type/Bane</option>';

		   while ($drop_3 = $result->fetch_array()) 
			{
			  echo '<option value="'.$drop_3[0].'">'.$drop_3[1].'</option>';
			}
	
	echo '</select> ';
   echo "<script type=\"text/javascript\">
$('#wait_3').hide();
	$('#drop_3').change(function(){
	  $('#wait_3').show();
	  $('#result_3').hide();
      $.get(\"funci.php\", {
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
    include_once('../configi.php');
    $query = "select * from gal_unit where typeID='$drop_var' order by 4";
    $result = $db->query($query);
	
	echo '<select name="drop_4" id="drop_4">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
			
		   while ($drop_4 = $result->fetch_array()) 	
			{
			  echo '<option value="'.$drop_4[0].'">'.$drop_4[1].'</option>';
			}
	
	echo '</select> ';
	   echo "<script type=\"text/javascript\">
$('#wait_4').hide();
	$('#drop_4').change(function(){
	  $('#wait_4').show();
	  $('#result_4').hide();
      $.get(\"funci.php\", {
		func: \"drop_4\",
		drop_var: $('#drop_4').val()
      }, function(response){
        $('#result_4').fadeOut();
        setTimeout(\"finishAjax_tier_five('result_4', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
//**************************************
//     Forth selection results     //
//**************************************

if (isset($_GET['func'])) {
if($_GET['func'] == "drop_4" && isset($_GET['func'])) { 
   drop_4($_GET['drop_var']);
} 
}

function drop_4($drop_var)
{  
    include_once('../configi.php');
    $query = "select * from gal_unitdetail where numID='$drop_var' order by 5";
    $result = $db->query($query);
	
	echo '<select name="drop_5" id="drop_5">
	      <option value=" " disabled="disabled" selected="selected">Velg</option>';
			
		   while ($drop_5 = $result->fetch_array()) 	
			{
			  echo '<option value="'.$drop_5[0].'">'.$drop_5[1].'</option>';
			}
	
	echo '</select> ';
   // echo '<input type="submit" name="submit" value="Submit" />';   
   
}
?>