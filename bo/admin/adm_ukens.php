<?php
date_default_timezone_set('Europe/Oslo');

$start = strtotime('last Monday');
$refuke = strtotime('last Monday')+200;

$uke0 = date('W',$refuke);
$year0 = date('Y',$refuke);
$uke1 = date('W',$refuke+604800);
$year1 = date('Y',$refuke+604800);

$year = date('Y',$start+604800);

if (isset($_POST['u'])) {$uke = $_POST['u']; }
else {$uke = $uke1; }

if ($uke != (date('W',$start+604800))) {$start = $start-604800;}

$uploaduke = date('W',$start);

?>
<div class="wide_heading">
	Ukens Bilde
</div>
<div class="wide_content" style="overflow: hidden;">

	<div style="width: 1000px; text-align: left; font-size: 14px; font-weight: bold;">
	<br />
		<form name="ukevalg" id="ukevalg" action="index.php?s=2" method="POST" style="margin: 0px;">
			<div style="display: flex; width: 250px; height: 16px; line-height: 16px; display: inline-block;">
				Ukens bilde, uke&nbsp;
				
				<select name="u" style="border: 1px solid black; height: 16px;" onchange="document.ukevalg.submit();">
				 <option  value="<?php echo $uke0; ?>" <?php if ($uke == $uke0) {echo 'selected';} ?>><?php echo $uke0; ?></option>
				 <option  value="<?php echo $uke1; ?>" <?php if ($uke == $uke1) {echo 'selected';} ?>><?php echo $uke1; ?></option>
				</select>
			</div>
		</form>
			<br />
			
	</div> 

<b>Forslag til n&aelig;ste "ukens bilde", uke <?php echo $uke; echo '/'; echo date('Y',$start+604800); ?>: Bilder opplastet i uke <?php echo date('W',$start); echo "/"; echo date('Y',$start); ?></b>
<br /><br />
<?php
	$query = "select data from log_poeng where value='poeng'";
	$poengdate = $db->query($query)->fetch_object()->data;
?>
<b>Vægtet poengsum opdateret <?php echo date('d.m.Y H:i:s',$poengdate); ?></b><br />
<br />
<?php
//$start = strtotime($uploadyear."W".$uploaduke);
$slut = $start + 604799;

$n=0;

//$query = "select id, url, thumb, sum(stemmer) as stemmer, sum(poeng) as poeng, visning, fotograf, (poeng/stemmer)+(stemmer*0.5) as score from gal_images where poeng>0 and timestamp between '$start' and '$slut' group by url order by score desc, poeng desc";

$a=0;
$soekarray = "";

$query = "select id, url from gal_images where poeng>0 and timestamp between '$start' and '$slut'";	

$result = $db->query($query);
while ( $img = $result->fetch_array() ) {	
	$surl[$a] = $img[1];
	$a++;
}	

for ($b = 0 ; $b<$a ; $b++) {
	$soekarray .= "'".$surl[$b]."'";
	if ($b < $a-1) {$soekarray .= ",";}
	
}

$query2 = "select sum(vaegtet_poeng) as sum, url from gal_comments where url in ($soekarray) group by url order by 1 desc limit 5";
$result2 = $db->query($query2);
if ($result2 !='') {
while ( $img2 = $result2->fetch_array() ) {
	
	$query3 = "select id, url, thumb, sum(stemmer) as stemmer, sum(poeng) as poeng, visning, fotograf from gal_images where url = '$img2[1]'";
	$result3 = $db->query($query3);
	while ( $img3 = $result3->fetch_array() ) {
		
		$id[$n] = $img3[0];
		$url[$n] = $img3[1];
		$thumb[$n] = $img3[2];
		$fotograf[$n] = $img3[6];
		$stemmer[$n] = $img3[3];
		$poeng[$n] = $img3[4];
		$score[$n] = $img2[0];

		if (isset($img[5])) { $views[$n] = $img[5];	}

		$n=$n+1;  
				}
			}
		}
/*
//	$query2 = "select id, url, thumb, sum(stemmer) as stemmer, sum(poeng) as poeng, visning, fotograf, (poeng/stemmer)+(stemmer*0.5) as score from gal_images where url in ($soekarray) group by url order by score desc, poeng desc";
	$result2 = $db->query($query2);
	if ($result2 != '') {
	
while ( $img2 = $result2->fetch_array() ) {



$id[$n] = $img2[0];
$url[$n] = $img2[1];
$thumb[$n] = $img2[2];
$fotograf[$n] = $img2[6];
$stemmer[$n] = $img2[3];
$poeng[$n] = $img2[4];
$score[$n] = $img2[7];



if (isset($img[5])) { $views[$n] = $img[5];	}

$n=$n+1;  
											}
					}
					
					
*/					

	
?>
<div class="ukens_line"> 
<?php 
 for ($m = 0 ; $m<5 ; $m++)  { 
?>	
 	<div class="ukens_cell">
	   <?php 
	    if (@$poeng[$m]>0) {   
	   $stars = round($poeng[$m]/$stemmer[$m]);  } 
	   else { $stars=0; }
	   ?>
	   <div class="ukens_innercell">
	   <img src="../graphics/<?php echo $stars; ?>stars.gif">
	   </div>
	   <?php
	   if (isset($url[$m])) {
	   ?>	
	   <a href="../subpage.php?s=0&id=<?php echo $id[$m]; ?>"><img src="<?php echo $thumb[$m]; ?>" class="adm_img" width="194"></a>
	  <br>
	  <?php } ?>
	</div>	
	
 <?php  } ?>
 	<div class="ukens_cell">
 	 <?php
 		$i='';
  		if (isset($_POST['i'])) { $i=$_POST['i']; }
  		if ($i != '') {
  			$query ="select id, url, thumb, stemmer, poeng, visning, fotograf from gal_images where id = '$i'";
  			$result = $db->query($query);
			$other = $result->fetch_array();
			if (isset($other[0])) { $stars = @round($other[4]/$other[3]); }
  			}
 		?>
	  	<div style="width: 187px; height: 18px; text-align: center; background-color: #333333;">
		    <?php
		    if (isset($other[0])) { ?>
		     <img src="../graphics/<?php echo $stars; ?>stars.gif">
		    <?php } ?>
		   </div>
		   <?php
		    if (isset($other[0])) { 
		    	?>
   	 		<a href="../subpage.php?s=0&id=<?php echo $other[0]; ?>"><img src="<?php echo $other[2]; ?>" border="0" class="adm_img" width="185"></a>	
   	<?php	} 
     else { ?> 
   		<br /><br />
   		<div style="text-align:center;">et helt andet bilde<br />
   		<br />
		     <form action="index.php?s=2&u=<?php echo $uke; ?>" method="post">
			     bilde-id: &nbsp;&nbsp;<input type="text" name="i" style="width: 70px;"><br /><br />
			     <input type="hidden" name="f" value="<?php echo $faktor; ?>">
			     <input type="submit" style="width: 130px;" value="hent bilde">
		     </form>
		    </div>
   <?php  }  ?>

 	</div>	
 	
</div> 
<br />
<div class="ukens_line">   
   <?php  
     for ($m = 0 ; $m<5 ; $m++)  { ?>
   <div class="ukens_cell">
	     <?php
	      if(isset($url[$m])) {
	     ?>
		 <div class="ukens_lefttext">
		 	Fotograf:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $fotograf[$m]; ?>
	   	 </div>
	   	 <br />
	   	 <div class="ukens_lefttext">
		 	Poeng:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $poeng[$m]; if ($poeng[$m] > 0) { echo " ("; echo number_format(($poeng[$m]/$stemmer[$m]), 1, ',', ''); echo ")";} ?>
	   	 </div>
	   	 <br />
	   	 <div class="ukens_lefttext">
		 	Stemmer:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $stemmer[$m]; ?>
	   	 </div>
	   	 <br />
	   	    	 
	   	 <div class="ukens_lefttext">
		 	<b>Poengsum:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo number_format(($score[$m]), 2, ',', ''); ?></b>
	   	 </div>
	   	 <br />
	   	 
	   	 
		 <br />
		 <div>
		  <form name="setukens<?php echo $m; ?>" action="adm_ukens_set.php" method="post">
			    <input type="hidden" name="u" value="<?php echo $uke; ?>">
			    <input type="hidden" name="y" value="<?php echo $year; ?>">
			    <input type="hidden" name="i" value="<?php echo $id[$m]; ?>">
			    <input type="hidden" name="n" value="<?php echo $username; ?>">
			    
	<?php if ($m>0) { ?><input type="submit" value="velg dette" style="width: 184px;"> <?php } else { ?>
				<input type="submit" value="auto-valg" style="width: 184px;"> <?php  } ?>
			    </form>
			   
			   <br />
	   	 </div>
		<?php } 
		 else { echo "&nbsp;&nbsp;&nbsp;"; }
		?> 
	</div>
     <?php  
      } 
     ?>
     <div class="ukens_cell">
     	<?php
			      if(isset($other[0])) {
			     ?>
		<div class="ukens_lefttext">
		 	Fotograf:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $other[6]; ?>
	   	 </div>
	   	 <br />
	   	 <div class="ukens_lefttext">
		 	Poeng:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $other[4]; if ($other[4] > 0) { echo " ("; echo number_format(($other[4]/$other[3]), 1, ',', ''); echo ")";} ?>
	   	 </div>
	   	 <br />
	   	 <div class="ukens_lefttext">
		 	Stemmer:
	   	 </div>
	   	 <div class="ukens_righttext">
	   	 	<?php echo $other[3]; ?>
	   	 </div>
	   	 <br />
	   	 
		 <br />
		 
			    <form name="setukens5" action="adm_ukens_set.php" method="post">
			    <input type="hidden" name="u" value="<?php echo $uke; ?>">
			    <input type="hidden" name="y" value="<?php echo $year; ?>">
			    <input type="hidden" name="i" value="<?php echo $other[0]; ?>">
			    <input type="hidden" name="n" value="<?php echo $username; ?>">
			   
			    <input type="submit" value="velg dette" style="width: 184px;">
			    </form>
			    <br />
			    
			    
			    <?php } ?>
     </div>

</div>
<br/>
<div class="ukens_line">


<hr />
<?php
/*
$year = date('Y',$start);
// check om denne uge findes i tabellen
$query = "select id, imgid, navn, timestamp from gal_ukens where uke = '$uke' AND aar = '$year'";
$result = $db->query($query);
$check = $result->fetch_array();

if(isset($check[0])) {

}
else { ?> 
<br />
<b>Ukens bilde - uke <?php echo $uke; echo "/"; echo $year;?></b>	
<br /><br />
Ukens bilde ikke valgt
<br /><br />
<hr />
<?php
}

*/


$n=0;
$query = "select imgid, uke, aar, navn, timestamp from gal_ukens order by aar desc, uke desc limit 15";
$result = $db->query($query);
while ( $uke = $result->fetch_array() ) {

$query = "select id, thumb, fotograf, stemmer, poeng, timestamp, tekst, visning, kamera, kameramodel, lukkertid, blender, iso, focal, url from gal_images where id = '$uke[0]'";
$result1 = $db->query($query);
$bilde = $result1->fetch_array();

$query3 = "select sum(vaegtet_poeng) as sum, url from gal_comments where url = '$bilde[14]' group by url";
$poengsum = $db->query($query3)->fetch_object()->sum;



$n++;
?>
<div class="ukens_line">

	<div class="ukens_leftspace">
	      <b>Uke <?php echo $uke[1]; echo "/"; echo $uke[2]; ?></b>
	</div>     
   <?php
   if (@$bilde[4]>0) {
   $stars = round($bilde[4]/$bilde[3]);  }
   else { $stars=0; }
   ?>
	<div class="ukens_imgblock">
	   
	   <div style="display: table-cell; width: 250px; height: 18px; text-align: center; background-color: #333333;">
	       <img src="../graphics/<?php echo $stars; ?>stars.gif">
	   </div>
	
	      <a href="../subpage.php?s=0&id=<?php echo $bilde[0]; ?>"><img src="<?php echo $bilde[1]; ?>" width="248" class="adm_img" alt="<?php echo $bilde[0]; ?>" title="<?php echo $bilde[0]; ?>" /></a>
	</div>
	<div style="display: inline-block; vertical-align: top; padding-left: 30px;">
		<div class="ukens_lefttext">
			Fotograf:
		</div>
		<div class="ukens_righttext">
			<?php echo $bilde[2]; ?>   	 	
		</div>
	   <br />
		<div class="ukens_lefttext">
			Opplastet:
	    </div>
		<div class="ukens_righttext">
			<?PHP echo date("d.m.Y - H:i",$bilde[5]); ?>   	 	
		</div>
		<br />
		<div class="ukens_lefttext">
			Tekst:
	    </div>
		<div class="ukens_righttext">
			<?php echo $bilde[6]; ?>   	 	
		</div>
		<br />
		<div class="ukens_lefttext">
			Kamera:
	    </div>
		<div class="ukens_righttext">
			<?php if ($bilde[8] != '') {
			         	echo $bilde[8]; echo ", "; echo $bilde[9]; echo '<br />';
			         	  }  ?>   	 
		</div>
		<br />
		<div class="ukens_lefttext">
			Exif-data:
	    </div>
		<div class="ukens_righttext">
			 <?php if ($bilde[8] != '') {
			         	echo $bilde[13]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $bilde[10]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
			         	echo $bilde[11]; echo "&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $bilde[12];
			         	echo '<br />';
	  		         	}   ?>  	 	
		</div>
		<br /><br />
		<div class="ukens_lefttext">
			Poeng:
	    </div>
		<div class="ukens_righttext">
			<?php echo $bilde[4]; if ($bilde[4] > 0) { echo " ("; echo number_format(($bilde[4]/$bilde[3]), 1, ',', ''); echo ")";} ?>
		</div>
		<br />
		<div class="ukens_lefttext">
			Stemmer:
	    </div>
		<div class="ukens_righttext">
			 <?php echo $bilde[3]; ?>  	 	
		</div>
		<br />
		<div class="ukens_lefttext">
			<b>Poengsum:
	    </div>
		<div class="ukens_righttext">
			<?php echo number_format($poengsum, 1, ',', ''); ?></b>
		</div>
		<br />

		<div class="ukens_lefttext">
			Valgt av:
	    </div>
		<div class="ukens_righttext">
			<?php echo $uke[3]; echo " - "; echo @date("d.m.Y  H:i",$uke[4]);?>  	 	
		</div>
	</div>	
	<br /><br />
</div>
<?php if($n < 15) { echo "<hr />"; }                
}
 ?>

     
</div> 