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
$query = "select id, url, thumb, tekst, clean_url, stemmer, poeng, fotograf, clean_thumb from gal_images where id in('$rid[0]','$rid[1]','$rid[2]','$rid[3]','$rid[4]','$rid[5]')";	
$result2 = $db->query($query);
while ( $rlist = $result2->fetch_array() ) {
 @$rstars[$rir] = round($rlist[6]/$rlist[5]);	
 $rfotograf[$rir] = $rlist[7];
 $riid[$rir] = $rlist[0];
 $riurl[$rir] = $rlist[1];
 $rithumb[$rir] = $rlist[2];
 $ritekst[$rir] = $rlist[3];
 $riclean_url[$rir] = $rlist[4];
 $riclean_thumb[$rir] = $rlist[8];

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

<div id="rndgal">
	<div id="rndgal_heading">
		Fra galleriene - tilfeldig valgt blant totalt <?php echo number_format($totant, 0, ',', '.'); ?> bilder i databasen
	</div>
	<?php for ($ln = 0 ; $ln<3 ; $ln++) { ?>
		<div class="rndgal_cell">
		<div class="galrand_header">
			<img src="<?php echo $path; ?>graphics/<?php echo @$rstars[$ln]; ?>stars.gif" alt="" />
		</div>
		<?php if ($isloggedin==1) { echo '<a href="../bo/posthylla_redir.php?img='.$riclean_url[$ln].'&id='.$riid[$ln].'" class="gal_siste_pv">'; } 
		echo '<img src="'.$riclean_thumb[$ln].'" alt=""  class="latest_uploads" />';if ($isloggedin==1) { echo '</a>'; }
		echo '<br />'.$ritekst[$ln].'<br />Fotograf: '.$rfotograf[$ln].'<br />'; ?>
		</div>
	<?php } ?>
	<br />
</div>