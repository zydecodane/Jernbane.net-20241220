<meta http-equiv="expires" content="-1">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />

<div class="wide_heading">
	Posthylla-auto - logning
</div>
<div class="wide_content" style="overflow: hidden;">
<div style="width:1240px;">
<?php
$query = "select * from log_cron_posthylla order by id desc limit 30";
$result = $db->query($query);


if (isset($_GET['logid'])) { $logid = $_GET['logid']; }
if (isset($_POST['logid'])) { $logid = $_POST['logid']; } 
if (!isset($logid)) {
	$query0 = "select max(id) as maxid from log_cron_posthylla";
	$logid = $db->query($query0)->fetch_object()->maxid;
	} 

?>
	<form action="index.php?s=11" method="POST">
		Dato/tid for kørsel: <select name="logid" onchange="this.form.submit()">
	<?php
	while ( $timelist = $result->fetch_array() ) {	
    ?>
    	<option value="<?php echo $timelist[0]; ?>" <?php if($logid == $timelist[0]){echo 'selected="selected"';} ?>><?php echo date("d.m.Y - H:i:s", $timelist[1]); ?></option>
    
    <?php
     } 	
	?>	

		</select>
	</form>	
	<?php
	$query2 = "select * from log_cron_posthylla where id = '$logid'";
	$dlogid = $db->query($query2)->fetch_object()->id;
	$dtimestamp = $db->query($query2)->fetch_object()->timestamp;
	$dimgstring = $db->query($query2)->fetch_object()->img;
	
	$result2 = $db->query($query2);
	?>
	<hr />
	<?php
	$images = preg_split('/;/', $dimgstring);
	?>
	<h4><?php echo sizeof($images); ?> bilder auto-flyttet til glleriet <?php echo date("d.m.Y - H:i:s", $dtimestamp); ?></h4>
	<?php
	for ($n = 0 ; $n<sizeof($images) ; $n++)
	{

		$query3 = "select id, url, thumb, tekst, fotograf, dato, type, nummer, timestamp, posthylla from gal_images where id = '$images[$n]'";
		$result3 = $db->query($query3);
		$img = $result3->fetch_array();

	if(!isset($img[0])) {
		?>
			<div class="phylla_line">
			
				<p>Bildet med id <?php echo $images[$n]; ?> er slettet.</p>
			</div>
		<hr />	
		
		<?php
			} else {
		?>
	
	
		<div class="phylla_line">
			<div class="phylla_img">
				<a  href=../subpage.php?s=0&id=<?php echo $img[0]; ?> target="_blank"><img src="<?php echo $img[2]; ?>" class="adm_img" alt="<?php echo $img[0]; ?>" title="<?php echo $img[0]; ?>" /></a>
			<br /><br />	
			</div>
			<div class="phylla_text"  >
				<div class="phylla_text_left">
					<b>Fotograf:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $img[4]; ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Opplastet:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo date("d.m.Y - H:i:s", $img[8]); ?><br />
				</div>
				
				<br /><br />
	<?php
	$query = "select numid, enhet from gal_unit where numid = '$img[7]'";
	$result = $db->query($query);
	$unit = $result->fetch_array();
	
	$query = "select typeid, typename, katid from gal_type where typeid = '$img[6]'";
	$result = $db->query($query);
	$type = $result->fetch_array();
	        
	$query = "select katid, katname, natid from gal_kategori where katid = '$type[2]'";
	$result = $db->query($query);
	$kat = $result->fetch_array();
	
	$query = "select natid, natnavn from gal_nations where natid = '$kat[2]'";
	$result = $db->query($query);
	$land = $result->fetch_array();
	
	
	// check om billedet i mellemtiden er blevet kopieret til ytterligere plassering i gallerierne
	$query6 = "select count(id) as antal from gal_images where url = '$img[1]'";	
	$result6 = $db->query($query6)->fetch_object()->antal;
	

	?>
			    <div class="phylla_text_left">
					<b>Land:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $land[1]; ?><br />
				</div>   
				<div class="phylla_text_left">
					<b>Kategori:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $kat[1]; ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Type:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $type[1]; ?><br />
				</div>
				<div class="phylla_text_left">
					<b>Nummer:</b>
				</div>
				<div class="phylla_text_right">
					<?php echo $unit[1]; ?><br />
				</div>
				
				<?php 
				if ($result6 > 1) { ?>
				<div class="phylla_text_left">
					<b>OBS:</b>
				</div>
				<div class="phylla_text_right">
					Ytterligere <?php echo $result6-1; ?> plassering<?php if($result6 > 2){echo "er";} ?> i galleriet
				</div>
				<?php } ?>
				
				<div class="phylla_text_left">
					<b>Tekst:</b>
				</div>	
				<div class="phylla_text_right">
					<?php echo $img[3]; if ($img[5]!='') { echo ", "; echo date("d.m.Y",$img[5]); } ?>
				</div>
				<?php				
				if ($img[9]==2) { ?>  
		   			<div class="phylla_text_left">
						<br />
					</div>
		   			<div class="phylla_text_right">
		   			<br />
						<b>Bildet er parkert</b>
					</div>
				<?php } ?>
			</div>	
			
			<div class="phylla_buttons">
            <br />
	            <div class="phylla_bottom_line">
			        <form name="kat" method="post" action="index.php?s=6&id=<?php echo $img[0]; ?>&page=autolog">
			         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
			         <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
			         <input type="submit" value="endre kategorisering" style="width: 220px; text-align: left;" />
			        </form> 
				</div>
				<div class="phylla_bottom_line">
			        <form name="kopi" method="post" action="index.php?s=7&id=<?php echo $img[0]; ?>&page=autolog">
			         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
			         <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
			         <input type="submit" value="kopiere til ytterligere plassering" style="width: 220px; text-align: left;" />	         
			        </form> 
				</div>
	            <div class="phylla_bottom_line">
			        <form name="park" id="park" method="post" action="adm_posthylla_auto_park.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil parkere dette bildet?');">
			         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
			         <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
			         <input type="submit" value="parker bildet" style="width: 220px; text-align: left;" />
			        </form>
			        
				</div>
				<div class="phylla_bottom_line">
			        <form name="slet" method="post" action="adm_posthylla_auto_slet.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
			         <input type="hidden" name="id" value="<?php echo $img[0]; ?>" />
			         <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
			         <input type="submit" value="slet bildet" style="width: 220px; text-align: left;" />
			        </form> 
				</div>
				
		    </div>	
			</div>
		<hr />	
		<?php 
			}
		?>	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php	
	
	}
	
	
	
	
	
	
	
	?>	
	<br /><br />
</div>	
</div>	