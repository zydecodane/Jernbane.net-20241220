<?php
$land='0';	
if (isset($_POST["land"])) { $land=$_POST["land"]; }
if (isset($_GET["l"])) { $land=$_GET["l"]; }	
	
$cat='0';	
if (isset($_POST["cat"])) { $cat=$_POST["cat"]; }	
if (isset($_GET["c"])) { $cat=$_GET["c"]; }	

$query = "SELECT * FROM gal_nations ORDER BY plass ASC";
$result = $db->query($query);
?>   
<form name="add" method="post" action="index.php?s=3&p=3">
<TABLE class="admtable1">
			<TR>
			      <td WIDTH="90">
			         <select name="land" onChange="this.form.submit()">
			         <option>Velg land</option>
	<?php while ( $liste = $result->fetch_array() ) {		         
             echo '<option value="'; echo $liste[0]; echo '"'; if ($liste[0]==$land) {echo ' selected';} echo '>'; echo $liste[2]; 
             echo '</option>';
							}  ?>
			         </select> <br>&nbsp;
			      </td>
			      <td width="40" align="center">
			        
			      </td>
			      <td WIDTH="250">
	<?php
	if ($land != 0) {
			$query = "SELECT * FROM gal_kategori WHERE natid = '$land' ORDER BY plass ASC";
			$result = $db->query($query);
				      
	?>		      
			         <select name="cat" onChange="this.form.submit()">
			         <option>Velg kategori</option>
	<?php while ( $liste1 = $result->fetch_array() ) {		         
             echo '<option value="'; echo $liste1[0]; echo '"'; if ($liste1[0]==$cat) {echo ' selected';} echo '>'; echo $liste1[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=2&amp;l=<?php echo $land; ?>">rediger</a>  
			         <?php }  ?>
			      </td>
			     
			 </TR>
</table>
</form>
<?php
 if ($land!=0 && $cat!=0) {
?> 
<br>	
<form name="add" method="post" action="adm_type_add.php">
<TABLE CELLPADDING="3" CELLSPACING="0"  class="admtable1">
			<TR>
			      			      <td WIDTH="350" >
			         <input type="text" name="nytype" style="width:340px;" value="ny type">
			      </td>
			      <td WIDTH="90">
			         plasser etter nr. 
			      </td>
			      <td width="40" align="center">
			        <input type="text" name="seq" style="width: 30px;">
			      </td>
			      <td >
			         <input type="submit" value="legg til">
			      </td>
			 </TR>
</table>
<input type="hidden" name="land" value="<?php echo $land ?>">
<input type="hidden" name="cat" value="<?php echo $cat ?>">
</form> 	
 	
<br>
<form name="update" action="adm_type_update.php" method="post">
<input type="submit" value="  oppdatere endringer  ">
<br /><br />
<table cellpadding="3" cellspacing="0" class="admtable">
   <tr>
      <td width="40" valign="top">
         <b>plass</b>
      </td>
      <td width="400" valign="top">
         <b>Type</b>
      </td>
      <td width="100" valign="top">
         <b>redigere enhet</b>
      </td>
      <td width="40" valign="top">
         <b>slette</b>
      </td>        
              
 </TR>
<?php
$n=1;
$query = "SELECT * FROM `gal_type` WHERE katid = '$cat' ORDER BY plass";
$result = $db->query($query);
while ( $liste2 = $result->fetch_array() ) {
?>
<tr>
  <td width="40">
    <input type="text" name="s<?PHP echo $n; ?>" style="width: 30px; border: 0px;" value="<?PHP echo $liste2[5]; ?>">
  </td>
  <td width="250">
    <input type="text" name="t<?PHP echo $n; ?>" style="width: 390px; border: 0px;" value="<?PHP echo htmlspecialchars($liste2[1]); ?>">
    <input type="hidden" name="i<?PHP echo $n; ?>" value="<?PHP echo $liste2[0]; ?>">
  </td>
  <td valign="top" width="100"><a href="index.php?s=3&amp;p=4&amp;l=<?php echo $land; ?>&amp;c=<?php echo $cat; ?>&amp;t=<?php echo $liste2[0]; ?>" style="color: blue;">rediger enheter</a>
  </td>
  <td width="40" valign="top">
         <a href="#" onClick="window.location.href='adm_type_delcheck.php?s=3&p=3&l=<?php echo $land; ?>&c=<?php echo $cat; ?>&t=<?php echo $liste2[0];?>'" style="color: blue;">slett</a>
      </td> 
</tr>	 
<?PHP
$n=$n+1;
}
?>	
</TABLE>
<br>
<input type="hidden" name="land" value="<?php echo $land ?>">
<input type="hidden" name="cat" value="<?php echo $cat ?>">
<input type="hidden" name="antal" value="<?php echo $n; ?>">

<input type="submit" value="  oppdatere endringer  ">
<br />
</form>

<br><br><br>
 	
<?php 	
 	}   // slut if begge variable er sat
?>


