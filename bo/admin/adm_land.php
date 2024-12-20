<br />
<form name="add" method="post" action="adm_land_add.php">
<div style="display: inline-block; width: 260px;">
	<input type="text" name="nykat" style="width:240px;" value="nyt land">
</div>			         
<div style="display: inline-block; width: 60px;">
	<input type="text" name="nyiso" style="width:30px;" value="ISO">
</div>
<div style="display: inline-block; width: 50px;">
    <a href="http://en.wikipedia.org/wiki/ISO_3166-2" target="_blank">finn ISO</a>
</div>
<div style="display: inline-block; width: 75px;">
	<input type="text" name="nycontinent" style="width: 65px;" value="verdensdel">
</div>
<div style="display: inline-block; width: 90px;">
	plasser etter nr. 
</div>
<div style="display: inline-block; width: 40px;">
	<input type="text" name="seq" style="width: 30px;">
</div>
<div style="display: inline-block; width: 50px;">
	<input type="submit" value="legg til">
</div>
<br />
Verdensdeler: xx=Norden eu=europa af=afrika na=amerika as=asia oc=oceania mx=diverse

</form>
<br />
<table cellpadding="3" cellspacing="3" style="border: 2px solid #FFFFFF;">
   <tr>
      <td width="40" valign="top" class="admtable">
         <b>plass</b>
      </td>
      <td width="40" valign="top" class="admtable">
         <b>ISO</b>
      </td>
      <td width="60" valign="top" class="admtable">
         <b>verdelsdel</b>
      </td>
      <td width="250" valign="top" class="admtable">
         <b>land</b>
      </td>
   </tr>
<?PHP
$query = "select * from gal_nations order by plass ASC";
$result = $db->query($query);
while ( $liste = $result->fetch_array() ) {
?>
<tr>
  <td width="40" class="admtable">
	 <?PHP echo $liste[5]; ?>
	</td>
	<td width="40" class="admtable">
	 <?PHP echo $liste[1]; ?>
	</td>
	<td width="60" class="admtable">
	 <?PHP echo $liste[3]; ?>
	</td>
	
  <td width="250" class="admtable">
	 <?PHP echo $liste[2]; ?>
	</td>
</tr>	 
<?PHP
}
?>	
</table>

