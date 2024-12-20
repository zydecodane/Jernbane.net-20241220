<?php	

$land='0';	
if (isset($_POST["land"])) { $land=$_POST["land"]; }
if (isset($_GET["l"])) { $land=$_GET["l"]; }	

$query = "SELECT * FROM `gal_nations` ORDER BY plass ASC";	
$result = $db->query($query);
?>   
<form name="add" method="post" action="index.php?s=3&p=2">
<table class="admtable1">
	<tr>
		<td WIDTH="90">
		    <select name="land" onChange="this.form.submit()">
		        <option>Velg land</option>
	<?php while ( $liste = $result->fetch_array() ) {		         
             echo '<option value="'; echo $liste[0]; echo '"'; if ($liste[0]==$land) {echo ' selected';} echo '>'; echo $liste[2]; 
             echo '</option>';
							}  ?>
		    </select> 
		</td>
		<td width="40" align="center">
		</td>
		<td WIDTH="250">
		</td>
	</tr>
</table>
</form>
<?php
 if ($land!=0) {
?> 
<br>	
<form name="add" method="post" action="adm_kategori_add.php">
<table cellspacing="3" cellpadding="0"  class="admtable1">
			<tr>
			      <td WIDTH="350" >
			         <input type="text" name="nykat" style="width:340px;" value="ny kategori">
			      </td>
			      <td WIDTH="90">
			         plasser etter nr. 
			      </td>
			      <td width="40" align="center">
			        <input type="text" name="seq" style="width: 30px;">
			      </td>
			      <td>
			         <input type="hidden" name="land" value="<?php echo $land ?>">
			         <input type="submit" value="legg til">
			      </td>
			 </Ttr>
</table>
<input type="hidden" name="land" value="<?php echo $land ?>">

</form> 	
 	
<br>
<form name="update" action="adm_kategori_update.php" method="post">
<table cellpadding="3" cellspacing="0" class="admtable">
   <tr>
      <td width="40" valign=top>
         <b>plass</b>
      </td>
      <td width="400" valign=top>
         <b>kategori</b>
      </td>
      <td valign="top" width="200" style="background-color: #FFFFFF;">
         &nbsp;&nbsp;<input type="submit" value="  oppdatere endringer  ">
      </td>
              
 </tr>
 <br />
<?PHP
$n=1;
$query = "SELECT * FROM `gal_kategori` WHERE natid='$land' ORDER BY plass";
$result = $db->query($query);
while ( $liste2 = $result->fetch_array() ) {
?>
<tr>
  <td width="40">
	 <input type="text" name="p<?PHP echo $n; ?>" value="<?PHP echo $liste2[3]; ?>" style="width: 30px; border: 0px;">
  </td>
  <td width="250">
    <input type="text" name="t<?PHP echo $n; ?>" style="width: 390px; border: 0px;" value="<?PHP echo $liste2[1]; ?>">
    <input type="hidden" name="i<?PHP echo $n; ?>" value="<?PHP echo $liste2[0]; ?>">
  </td>
  <td valign="top" width="200" style="background-color: #FFFFFF;">
  </td>
</tr>	 
<?PHP
$n=$n+1;
}
?>	
</table>
<br>
<input type="hidden" name="land" value="<?php echo $land ?>">

<input type="hidden" name="antal" value="<?php echo $n; ?>">

</form>

<br><br><br>






 	
<?php 	
 	}   // slut if land er sat
?>


