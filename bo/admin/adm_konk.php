<br />
 
<div style="width: 1000px; text-align: left; font-size: 14px; font-weight: bold;">På Sporet av 2014</div> 
<br />
<?php
include('configi.php');
$query = "select search_text from phorum_search where forum_id = 11 ";
$result = $db->query($query);
$f=0; $m=0;
while ( $fliste = $result->fetch_array() ) {
    $forumtext[$f] = $fliste[0]; 
    $f++;
     } 
     
for ($n = 0 ; $n<$f ; $n++)
{
	$needle = "[img]";
	$lastPos = 0;
	$positions = array();
	
	while (($lastPos = strpos($forumtext[$n], $needle, $lastPos))!== false) {
	    $positions[] = $lastPos;
	    $lastPos = $lastPos + strlen($needle);
	}

foreach ($positions as $istart) {
	$islut = strpos($forumtext[$n],'[/img]',$istart);	
	$istreng[$m] = substr($forumtext[$n],($istart+5),($islut-$istart-5));
	$m++;
	}
}
// nu er alle billeder fra dette forum læst ind i et array

/*

$l=0;
for ($n = 0 ; $n<$m ; $n++)
{
	$query = "select id, thumb, stemmer, poeng, from gal_images where url = '$istreng[$n]' ";
	if ( @$db->query($query)->fetch_object()->thumb != '' ) { 
		
	$id[$l] = $db->query($query)->fetch_object()->id;
	
	$l++;	
	}
	
}
*/
$instreng = '(';


$n=0;
while ($n<$m-1)
{
	$instreng .= "'".$istreng[$n]."',"; 
	$n++;
}
	$instreng .= "'".$istreng[$n]."')";
	
	

	
	
/*	
$query = "select * , (poeng/stemmer)+(stemmer*0.2) as score from gal_images where id in $instreng order by score desc, poeng desc";
$result = $db->query($query);
*/


$query = "select sum(poeng) as poengsum from gal_comments where url in $instreng group by url order by poengsum desc";
$result = $db->query($query);

while ( $img = $result->fetch_array() ) {

echo $img[0]; echo "<br />";




}

/*
?>	
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="280">
		<a href="../subpage.php?s=0&id=<?php echo $img[0]; ?>" target="_parent"><img src="<?php echo $img[2]; ?>" border="0" /></a>
	</td>
	<td width="500" valign="top">
		<b>Fotograf: <?php echo $img[5]; ?></b>
		<br /><br />
		Stemmer: <?php  echo $img[12]; ?><br />
		Poeng: <?php echo $img[11]; ?><br />
		<b>Poengsum:  
		<?php echo number_format(($img[24]), 2, ',', '');  ?></b>
		<br /><br />
		<?php
		if ($img[13] != '') {
      	echo $img[13]; echo ", "; echo $img[14]; echo '<br />';
     	if (substr($img[15],0,1)!=' ') {
      	echo $img[18]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[15]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
       	echo $img[16]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $img[17];
       	echo '<br />'; }
		}
       	?>
	</td>	
</tr>
</table>
<br />
<?php
	
		if ($img[11] > 0) {
		?>
		<table cellpadding="3" cellspacing="3" border="0" style="width: 100%; background-color: #E6E6E6;">	
		<?php	
			$query2 = "select * from gal_comments where url = '$img[1]' ";
			$result2 = $db->query($query2);	
			while ( $com = $result2->fetch_array() ) { 
				?>
		<tr>
			<td width="300" style="background-color: #ffffff;">		
				<?php echo $com[4]; ?>
			</td>
			<td width="50" style="background-color: #ffffff;">	
				<?php echo $com[3]; ?>
			</td>	
			<td width="700" style="background-color: #ffffff;">	
				<?php echo $com[2]; ?>
			</td>
		</tr>	
			<?php
			}
		?>
		</table>
		<br />	
		<?php

		}
		
		
?>		
<hr />
   
   
<?php 

*/


  



?>
