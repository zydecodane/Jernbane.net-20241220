<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


include('configi.php');

$a=1;

$query = "select imgid, thumb, fotograf, poeng, stemmer, (poeng/stemmer) as snit, (stemmer * 0.2) as tillaeg, ((poeng/stemmer)+(stemmer*0.2)) as poengsum from misc_konkurranse order by poengsum desc";
$result = $db->query($query);
?>
<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid grey;
}
</style>

<br /><br />

<h1>På Sporet av 2014</h1>

<table cellpadding="5" cellspacing="0">
<tr>
		<td width="30">
    		<b>Plass</b>
    	</td>
    	<td width="270">
    		<b>Bilde</b>
    	</td>
    	<td width="160" valign="top">
    		<b>Fotograf</b>
    	</td>
    	<td width="100" valign="top">
    		<b>Stemmer</b>
    	</td>
    	<td width="50" valign="top">
    		<b>Poeng</Æb>	
    	</td>
    	<td width="80" valign="top">
    		<b>Gennemsnit</b>
    	</td>
    	<td width="150" valign="top">
    		<b>Tillæg (0,2 pr. stemme)</b>
    	</td>
    	<td width="60" valign="top">
    		<b>Poengsum</b>
    	</td>  
    </tr>

<?php
while ( $liste = $result->fetch_array() ) {
    ?>
    <tr>
    	<td width="30" valign="top">
    		<?php echo $a; ?>
    	</td>
    	<td width="270">
    		<a href="http://jernbane.net/bo/subpage.php?s=0&id=<?php echo $liste[0]; ?>"><img src="<?php echo $liste[1]; ?>" border="0"/></a>
    	</td>
    	<td width="160" valign="top">
    		<?php echo $liste[2]; ?>
    	</td>
    	<td width="100" valign="top">
    		<?php echo $liste[4]; ?>
    	</td>
    	<td width="50" valign="top">
    		<?php echo $liste[3]; ?>
    	</td>
    	<td width="80" valign="top">
    		<?php echo number_format(($liste[5]), 2, ',', '');$liste[5]; ?>
    	</td>
    	<td width="150" valign="top">
    		<?php echo number_format(($liste[6]), 2, ',', '');$liste[5]; ?>
    	</td>
    	<td width="60" valign="top">
    		<?php echo number_format(($liste[7]), 2, ',', '');$liste[5]; ?>
    	</td>  
    </tr>
<?php    
/*    
    echo $liste[0]; echo " - "; echo $liste[1]; echo " - "; echo $liste[2]; echo " - "; echo $liste[3]; echo " - "; echo $liste[4]; echo " - "; echo $liste[5]; echo " - "; echo $liste[6]; echo "<br />";
*/
?>    
<?php    
$a++;
     } 
?>

</table>