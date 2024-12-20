<div class="wide_heading">
	Tabeller
</div>
<div class="wide_content" style="overflow: hidden;">
<div style="width: 1240px;">
	<div>
	<h2>Endring af opplastingsmappe</h2>
	Opplastingsmappen må være i roten til filsystemet og ha en undermappe kalt thumbs, f.eks. <b>/upload_03/thumbs</b>
	<br /><br />
	Begge mappene må ha CHMOD -R 777 - dette gjøres ved hjelp av ftp-program, som også skal brukes til å opprette nye opplastingsmapper.
	<br /><br /><br >
	</div>
	
    	<div style="color: #666666; display: inline-block; float: left; width: 200px;">
      		<b>Upload-folder</b>
      	</div>
      	<div style="display: inline-block; float: left; width: 120px;">
          <?php
                      $di2 = @dir('../../');
						if ($di2!='') {
						$c=0;
						$liste2=array();
						while (false !== ($entry2 = $di2->read())) {
						if (substr($entry2,0,6) == "upload")
						 {  
						 	$liste2[$c]=$entry2;
						    $c=$c+1;                                 
						 }
						}
						array_multisort ($liste2, SORT_ASC);
						}
			$query = "select var from gal_variables where name = 'upload_folder'";			
			$folder = $db->query($query)->fetch_object()->var;	
           ?>
			<form name="ufolder" action="adm_update_ufolder.php" method="post" style="margin; 0px;">
           		<select name="ufolder">
            <?php for ($n = 0 ; $n<$c ; $n++) { ?>
           			<option value="<?php echo $liste2[$n] ?>"<?php if ($liste2[$n]==$folder){?> selected<?php } ?>><?php echo $liste2[$n]; ?></option><?php } ?>
            	</select>
      	</div>
      	<div display: inline-block; float: left; width: 80px;">
		 	<input type="submit" value="endre folder">
		 	</form>
		</div> 
		<br />
		<hr />
		<h2>Redigering av vilkår og betingelser</h2>
    	<div style="color: #666666; display: inline-block; float: left; width: 200px;">
      		<b>Bruksbetingelser version</b>
      	</div>
		<?php
		$query1 = "select version from misc_betingelser where id = '1'";			
		$version = $db->query($query1)->fetch_object()->version;
		?>
		<div style="display: inline-block; float: left; width: 120px;">
			<form name="version" action="adm_update_version.php" method="post" style="margin; 0px;">
           		<input type="text" style="width:30px;" name="version" value="<?php echo $version; ?>">	
		</div>	
      	<div display: inline-block; float: left; width: 80px;">
		 	<input type="submit" value="endre version">
		 	</form> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="window.location.href='index.php?s=12'">Redigér bruksbetingelser</button>
		</div>
		</form>	
		<br /><br />
 </div>   	
		
