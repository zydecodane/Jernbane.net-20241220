<?php
$isloggedin = 0;
if ($userid !='') { $isloggedin = 1; }

// get ukens
date_default_timezone_set('CET');
$uk_year = date('o');
$uk_week = date('W');

$squery = "select imgid from gal_ukens where uke = '$uk_week' and aar = '$uk_year'";
@$uk_id = $db->query($squery)->fetch_object()->imgid;

if(isset($uk_id)) {  // ukens bilde er valgt

$squery = "select id, thumb, url, tekst, stemmer, poeng, fotograf, clean_url from gal_images where id = '$uk_id'";
$sresult = $db->query($squery);
$sukens = $sresult->fetch_array();
}
?>

<div class="mobile_show">
	<?php
		@$ustars= round($sukens[5]/$sukens[4]);
	?>
 	<div class="description_header">
            Ukens Bilde <img src="<?php echo $path; ?>../bo/graphics/<?php echo @$ustars; ?>stars.gif" alt="" align="right" style="padding-right: 10px;" />
    </div>
    <?php if(isset($uk_id)) { ?>
    <div class="description_content">
        <div id="show_imgcontainer" style="padding-right: 2px;">
                       <?php
                        // https
                        if (substr($sukens[1],0,5) == 'http:') {
                            $sukens[1] = 'https:'.substr($sukens[1],5);
                        }
                        ?>
                        <?php if ($isloggedin ==1) { ?> 
                            <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $sukens[7]; ?>&id=<?php echo $sukens[0]; ?>">
                        <?php } ?>
                            <img src="<?php echo $sukens[2]; ?>" alt="ukens bilde"  class="latest_uploads" width="100%" />
                        <?php if ($isloggedin ==1) {echo "</a>"; } ?>  
                        <br />
                <div style="text-align: center;">  
                    <br />
                    <?php echo $sukens[3]; ?><br />Fotograf: <?php echo $sukens[6]; ?>	
                        <br /><br />
                        <a href="<?php echo $path; ?>subpage.php?s=5" style="color: #0000ff !important;"><u>Tidligere <i>Ukens Bilde</i></u></a>
                        <br /><br />
                </div>                                     
        </div>
    </div>
	<?php }  else { ?>
    <div class="description_content">
        <br />Denne ukes <i>Pictue of the Week</i><br />ikke valgt ennå<br /><br />
    </div>
    <?php } ?>
	<br />
	<?php
	// dagens bilde

	if ($dagens[9]==1) {  // der er et dagens bilde som skal vises
		@$dstars= round($dagens[5]/$dagens[4]);
		?>
		<div class="description_header">
	            Dagens Bilde <img src="<?php echo $path; ?>../bo/graphics/<?php echo @$dstars; ?>stars.gif" alt="" align="right" style="padding-right: 10px;" />
	    </div>
	    <div class="description_content">
	        <div id="show_imgcontainer" style="padding-right: 2px;">
	                       <?php
	                        // https
	                        if (substr($dagens[1],0,5) == 'http:') {
	                            $dagens[1] = 'https:'.substr($dagens[1],5);
	                        }
	                        ?>
	                        <?php if ($isloggedin ==1) { ?> 
	                            <a href="<?php echo $path; ?>posthylla_redir.php?img=<?php echo $dagens[7]; ?>&id=<?php echo $dagens[0]; ?>">
	                        <?php } ?>
	                            <img src="<?php echo $dagens[2]; ?>" alt="dagens bilde"  class="latest_uploads" width="100%" />
	                        <?php if ($isloggedin ==1) {echo "</a>"; } ?>  
	                        <br />
	                <div style="text-align: center;">  
	                    <br />
	                    <?php echo $dagens[3]; ?><br />Fotograf: <?php echo $dagens[6]; ?>	
	                        <br /><br />
	                </div>                                     
	        </div>
	    </div>
	<br />  
	<?php
	    }
	?>
</div>                                                                                    