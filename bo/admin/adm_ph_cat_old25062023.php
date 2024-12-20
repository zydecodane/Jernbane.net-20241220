<!-- script for select-boxes --!>
<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('#drop_1').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
      $.get("funci.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
function finishAjax_tier_four(id, response) {
  $('#wait_3').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}

function finishAjax_tier_five(id, response) {
  $('#wait_4').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}

</script>
<script type="text/javascript" src="fancybox/jquery_min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$("a#single").fancybox({
		'padding'  : 0,
		'margin'   : 0
		});
		$("a.grouped_elements").fancybox({
			'padding'  : 0,
		    'margin'   : 0,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition'     : 'none',
			'titleShow'         : 'none'
		});
				});
</script>
<?php
 if(isset($_GET['r'])) { $rs = $_GET['r']; } else {$rs = 0;}
 if(isset($_GET['e'])) { $en = $_GET['e']; } else {$en = 0;}
 if(isset($_POST['id'])) { $id = $_POST['id']; }
 if(isset($_GET['id'])) { $id = $_GET['id']; }
 if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
 if(isset($_GET['page'])) { $page = $_GET['page']; }
 if(isset($_GET['eg'])) { $eg = $_GET['eg']; } 
 if(isset($_POST['eg'])) { $eg = $_POST['eg']; } 
 if(isset($_POST['fi'])) { $fi = $_POST['fi']; } 
 if(isset($_GET['fi'])) { $fi = $_GET['fi']; } else { $fi = ''; }
 if (!isset($eg)) { $eg=''; }
 if(!isset($_POST['ae'])){$ae = -1;}
 else {$ae = $_POST['ae'];}
 if(isset($_GET['ae'])){$ae = $_GET['ae'];}
 if (isset($_POST['logid'])) {$logid = $_POST['logid'];}
  

 // set active element parameter string
 $ae_parstr = "";
 if($ae>0) {
    $ae_parstr = "&ae=".$ae;
 }


 $query = "select id, url, thumb, fotograf, tekst, dato, type, nummer, detailid from gal_images where id = '$id'";
 $result = $db->query($query);
 $img = $result->fetch_array();
?>

<div class="wide_heading">
	Kategorisering
</div>
<div class="wide_content" style="overflow: hidden;">

<?php
echo "Fotograf: "; echo $img[3]; echo "<br />";
echo $img[4];
if ($img[5]!=0) { echo ", "; echo date('j.n.Y', $img[5]); }

?>
	<br /><br />
		<div style="display: inline-block; width:300px;">
			<a class="grouped_elements" rel="" href="<?php echo $img[1]; ?>"><img src="<?php echo $img[2]; ?>" alt="0" class="adm_img" /></a>
		</div>
		<div style="display: inline-block; width: 600px; vertical-align: top;">
		<form action="adm_ph_cat_set.php" method="post" name="catset" enctype="multipart/form-data">

		<div class="cat_box">
			<div class="cat_left">
	 			<b>Land:</b> 
			</div>
			<div class="cat_right">
			 <?php
			if ($rs == 1) {$img[6] = 0; $img[7] = 0; $img[8] = 0;}
			  if ($img[6] != '0' && $en == '0')
			  { 	
			  	$query = "select katid, typename from gal_type where typeid = '$img[6]'";
			  	$result = $db->query($query);
				$skat = $result->fetch_array();
			  	
			  	$query = "select katname, natnavn from gal_kategori where katid = '$skat[0]'";
				$result = $db->query($query);
				$stype = $result->fetch_array();
		 	
			  	echo $stype[1];
			  	}
			  else {	
				 $val = '';
			     if($en == '1') {$val = $img[6];}
			 ?>
			  <select name="drop_1" id="drop_1">
			    <option value="" selected="selected" disabled="disabled">Velg Land</option>
			     <?php
			      include('funci.php'); 
			     getTierOne(); 
			     ?>
			  </select>&nbsp;<span id="wait_1" style="display: none;">&nbsp;
			    <img alt="Please Wait" src="../graphics/load.gif"/></span>
			  <?php } ?>     
			</div>
			<div class="cat_left">
				<b>Kategori:</b> 
		 	</div>
	 		<div class="cat_right">
			 <?php
			  if ($img[6] != '0')
			  {
			  	echo $stype[0];
			  }
			  else {
			  	?>
			   <span id="result_1" style="display: none;"></span>&nbsp;
			   <span id="wait_2" style="display: none;">
			   	<img alt="Please Wait" src="../graphics/load.gif"/>
			   </span>    <br />
			    <?php } ?>
			 </div>
			 <div class="cat_left">   
				<b>Type/bane:</b> 
			 </div>
			 <div class="cat_right">
				 <?php
				  if ($img[6] != '0')
				  {
				  	echo $skat[1];
				  ?>
			  	    <input type="hidden" name="drop_3" value="<?php echo $img[6]; ?>">
			  	  <?php
				  }
				  else {
				  	?>
				    <span id="result_2" style="display: none;"></span>&nbsp; 
				    <span id="wait_3" style="display: none;">
				    <img alt="Please Wait" src="../graphics/load.gif"/>
				    </span>
				   <br />
				  <?php } ?>
				</div>			   
				<div class="cat_left">
					<b>Nummer/sted:</b>
				</div> 
				<div class="cat_right">
						 <span id="result_3" style="display: none;"></span>
						 <span id="wait_4" style="display: none;">
					    <img alt="Please Wait" src="../graphics/load.gif"/>
					    </span> 
						 <?php 
						 if ($img[7] != '0')
						  { 
							$query = "select enhet from gal_unit where numid = '$img[7]'";
							$result = $db->query($query);
							$sunit = $result->fetch_array();
						  	
						  	if ($sunit[0] != 'andre') { 
						  		echo $sunit[0]; 
						  		?>
						  			<input type="hidden" name="drop_4" value="<?php echo $img[7]; ?>">
						  		<?php
						  		}
						  }
						  if ($img[7]=='0') {
						  	if ($img[6]!=0)   {
						  ?>
						   	<span id="result_3" style="display: none;"></span>
					
			   	<input type="hidden" name="drop_3" value="<?php echo $img[6]; ?>" />
			  	<select id="drop_4" name="drop_4">
			  	<option value="" selected="selected"></option>
				   <?php 
				   	$query = "select numid, enhet, plass from gal_unit where typeid = '$img[6]' order by 3";
				   	$result = $db->query($query);
					while ( $sunit = $result->fetch_array() ) {
				 	?>
				 	<option value="<?php echo $sunit[0]; ?>" ><?php echo $sunit[1]; ?></option>
					<?php } ?>
					</select>
					<?php
					
					} 
				
				  }
			?>
					
			<?php
			if (@$sunit[0] == 'andre')
			  { ?>
			  	<input type="hidden" name="drop_3" value="<?php echo $img[6]; ?>" />
			  	<select id="drop_4" name="drop_4">
			  	<option value="" selected="selected"></option>
			   <?php 
					$query = "select numid, enhet, plass from gal_unit where typeid = '$img[6]' order by 3";
					$result = $db->query($query);
					while ( $sunit = $result->fetch_array() ) {
				?>
			 	<option value="<?php echo $sunit[0]; ?>" ><?php echo $sunit[1]; ?></option>
				
			<?php } ?>
			    </select>
			<?php } ?>
				</div>
				<div class="cat_left">
	 			  <b>Detalj:</b> 
			    </div>
				<div class="cat_right">
				<span id="result_4" style="display: none;"></span> 
						 <span id="wait_5" style="display: none;">
					    <img alt="Please Wait" src="../graphics/load.gif"/>
					    </span> 
						 <?php 
						 if (!empty($img[8]) || $img[8] != '0')
						  { 
							$query = "select navn from gal_unitdetail where detailID = '$img[8]'";
							$result = $db->query($query);
							$sdetail = $result->fetch_array();
						  	
						  	if ($sdetail[0] != 'andre') { 
						  		echo $sdetail[0]; 
						  		?>
						  			<input type="hidden" name="drop_5" value="<?php echo $img[8]; ?>">
						  		<?php
						  		}
						  }
						  if ($img[8]=='0') {
						  	if ($img[7]!=0)   {
						  ?>
						   	<span id="result_4" style="display: none;"></span>
					
			   	<input type="hidden" name="drop_4" value="<?php echo $img[7]; ?>" />
			  	<select id="drop_5" name="drop_5">
			  	<option value="" selected="selected"></option>
				   <?php 
				   	$query = "select detailID, navn, plass from gal_unitdetail where numID = '$img[7]' order by 3";
				   	$result = $db->query($query);
					while ( $sdetail = $result->fetch_array() ) {
				 	?>
				 	<option value="<?php echo $sdetail[0]; ?>" ><?php echo $sdetail[1]; ?></option>
					<?php } ?>
					</select>
					<?php
					
					} 
				
				  }
			?>
				</div>  
				<div class="cat_left">
				 <br />
				  <input type="hidden" name="id" value="<?php echo $id; ?>" />
				  <input type="hidden" name="page" value="<?php echo $page; ?>" />
				  <input type="hidden" name="eg" value="<?php echo $eg; ?>" />
				  <input type="hidden" name="fi" value="<?php echo $fi; ?>" />
				  <input type="hidden" name="ae" value="<?php echo $ae; ?>" />
				  <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
				  <input type="submit" value="OK" style="width: 100px;" />
				</div>
				<div class="cat_right">
				   <br />
				</form>
				<!-- <form name="catendre" style="display: inline-block;" method="post" action="index.php?s=6&id=<?php echo $id; ?>&e=1&page=<?php echo $page; ?>&eg=<?php echo $eg.$ae_parstr; ?>&fi=<?php echo $fi; ?>">   
				   <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
				   <input type="submit" value="Endre" style="width: 100px;" />
				</form>   -->
				<form name="catreset" style="display: inline-block;" method="post" action="index.php?s=6&id=<?php echo $id; ?>&r=1&page=<?php echo $page; ?>&eg=<?php echo $eg.$ae_parstr; ?>&fi=<?php echo $fi; ?>">   
				   <input type="hidden" name="logid" value="<?php echo $logid; ?>" />
				   <input type="submit" value="Reset" style="width: 100px;" />
				</form>   
				</div>
		</div>
		</form>

</div>