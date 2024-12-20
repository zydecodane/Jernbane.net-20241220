<?php
$rn=0;
$query = "select id from gal_images where posthylla = '1' and poeng > 10";
		$result = $db->query($query);
		while ( $row = $result->fetch_object() ) {
			$rndimg[$rn] = $row->id;
			$rn++;
			 }
		$rand_keys = array_rand($rndimg, 6);
		for ($lm = 0 ; $lm<6 ; $lm++) {
		$rid[$lm] = $rndimg[$rand_keys[$lm]]; 
		} 
	
$rir=0;
$query = "select id, url, thumb, navn, tekst, clean_url, stemmer, poeng, fotograf, clean_thumb from gal_images where id in('$rid[0]','$rid[1]','$rid[2]','$rid[3]','$rid[4]','$rid[5]')";	
$result2 = $db->query($query);
while ( $rlist = $result2->fetch_array() ) {
 @$rstars[$rir] = round($rlist[7]/$rlist[6]);	
 $rfotograf[$rir] = $rlist[8];
 $riid[$rir] = $rlist[0];
 $riurl[$rir] = $rlist[1];
 $rithumb[$rir] = $rlist[2];
 $rinavn[$rir] = $rlist[3];
 $ritekst[$rir] = $rlist[4];
 $riclean_url[$rir] = $rlist[5];
 $riclean_thumb[$rir] = $rlist[9];

 // https
 if (substr($rithumb[$rir],0,11) == 'http://www.') {
    $rithumb[$rir] = 'https://'.substr($rithumb[$rir],11);
  }    
 // rens for www
 if (substr($rithumb[$rir],0,5) == 'http:') {
    $rithumb[$rir] = 'https:'.substr($rithumb[$rir],5);
  }       
    
 $rir++;
}
$totant = $db->query("select count(id) as antal from gal_images where posthylla=1 and (timestamp is null or timestamp > 0)")->fetch_object()->antal;
?>	

<?php // årets bilde
$todayDate = new DateTime(); // Today
$DateBegin = new DateTime('2018-01-01');
$DateEnd  = new DateTime('2018-01-15');
if (
  $todayDate->getTimestamp() > $DateBegin->getTimestamp() && 
  $todayDate->getTimestamp() < $DateEnd->getTimestamp())
{
// vi finder de 3 billeder med flest poeng, opplastet i 2017
$air=0;
$query6 = "select id, url, thumb, navn, tekst, clean_url, stemmer, poeng, fotograf, stemmer*poeng as stjerner, clean_thumb from gal_images where timestamp between '1483225200' and '1514761199' order by stjerner desc limit 3";	 
$result6 = $db->query($query6);
while ( $alist = $result6->fetch_array() ) {
 @$astars[$air] = round($alist[7]/$alist[6]);	
 $afotograf[$air] = $alist[8];
 $aiid[$air] = $alist[0];
 $aiurl[$air] = $alist[1];
 $aithumb[$air] = $alist[2];
 $ainavn[$air] = $alist[3];
 $aitekst[$air] = $alist[4];
 $aiclean_url[$air] = $alist[5];
 $aiclean_thumb[$air] = $alist[10];

 // https
 if (substr($aithumb[$air],0,11) == 'http://www.') {
    $aithumb[$air] = 'https://'.substr($aithumb[$air],11);
  }    
 // rens for www
 if (substr($aithumb[$air],0,5) == 'http:') {
    $aithumb[$air] = 'https:'.substr($aithumb[$air],5);
  }          
 $air++;
}	
	
	
?>
<div id="rndgal">
	<div id="rndgal_heading">
		Årets Bilder - de tre mest likte bilder 2017
	</div>

	<?php for ($an = 0 ; $an<3 ; $an++) { ?>
		<div class="rndgal_cell">
		<div class="galrand_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$astars[$an]; ?>stars.gif" alt="" />
		</div>
		<?php if ($isloggedin==1) { echo '<a href="../bo/posthylla_redir.php?img='.$ainavn[$an].'&id='.$aiid[$an].'" class="gal_siste_pv">'; } 
		echo '<img src="'.$aiclean_thumb[$an].'" alt=""  class="latest_uploads" />';if ($isloggedin==1) { echo '</a>'; }
		echo '<br />'.$aitekst[$an].'<br />Fotograf: '.$afotograf[$an].'<br />'; ?>
		</div>
	<?php } ?>
</div>
<br />
<?php  // Årets bilde slut
}
?>


<div id="rndgal">
	<div id="rndgal_heading">
		Fra galleriene - tilfeldig valgt blant totalt <?php echo number_format($totant, 0, ',', '.'); ?> bilder i databasen
	</div>
	<?php for ($ln = 0 ; $ln<3 ; $ln++) { ?>
		<div class="rndgal_cell">
		<div class="galrand_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$rstars[$ln]; ?>stars.gif" alt="" />
		</div>
		<?php if ($isloggedin==1) { echo '<a href="../bo/posthylla_redir.php?img='.$rinavn[$ln].'&id='.$riid[$ln].'" class="gal_siste_pv">'; } else { ?> <a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.')"><?php } 
		echo '<img src="'.$riclean_thumb[$ln].'" alt=""  class="latest_uploads" />'; echo '</a>';
		echo '<br />'.$ritekst[$ln].'<br />Fotograf: '.$rfotograf[$ln].'<br />'; ?>
		</div>
	<?php } ?>
	<br /><br />
	<?php for ($ln = 3 ; $ln<6 ; $ln++) { ?>
		<div class="rndgal_cell">
		<div class="galrand_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$rstars[$ln]; ?>stars.gif" alt="" />
		</div>
		<?php if ($isloggedin==1) { echo '<a href="../bo/posthylla_redir.php?img='.$rinavn[$ln].'&id='.$riid[$ln].'" class="gal_siste_pv">'; } else { ?> <a href="../phorum/login.php" onclick="alert('Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.')"> <?php } 
		echo '<img src="'.$riclean_thumb[$ln].'" alt=""  class="latest_uploads" />'; echo '</a>';
		echo '<br />'.$ritekst[$ln].'<br />Fotograf: '.$rfotograf[$ln].'<br />'; ?>
		</div>
	<?php } 
	/*
	?>
	<br /><br />
		<?php				
		$query = "select url from misc_togtegninger order by rand() limit 1";  // tilfældig togtegning
		$tog = $db->query($query)->fetch_object()->url;
		echo '<img src="..'.$tog.'" alt="" />';
		?>
	<div id="rndgal_skinne"></div>
	<?php
	*/
	?>
</div>