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

<div class="wide_heading">
	Slett et bilde fra gallerierne
</div>
<div class="wide_content" style="overflow: hidden;">

	<br />
	
	<?php
	if(!isset($_POST['id'])){ @$id = $_GET['id'];} 
	if(isset($_POST['u'])){$unit = $_POST['u'];} else {$unit='';}
	if(isset($_POST['page'])) { $page = $_POST['page']; } else { $page = 1; }
	if(isset($_GET['page'])) { $page = $_GET['page']; }
	if(isset($_POST['fi'])) { $fi = $_POST['fi']; } 
	if(isset($_GET['fi'])) { $fi = $_GET['fi']; }
	if(!isset($_POST['ae'])){$ae = -1;}
	else {$ae = $_POST['ae'];}
	if(isset($_GET['ae'])){$ae = $_GET['ae'];}
	
	// set active element parameter string
	$ae_parstr = "";
	if($ae>0) {
	    $ae_parstr = "&amp;ae=".$ae;
	}
	 if(isset($_POST['id'])) { $id = $_POST['id'];}
	 if ($id > 0) {
	 
	 $query = "select * from gal_images where id = '$id'";
	 $result = $db->query($query);
	 $img = $result->fetch_array();
	
	echo "Fotograf: "; echo $img[5]; echo "<br>";
	echo $img[4]; 
	if ($img[6]!=0) { echo ", "; echo date('j.n.Y', $img[6]); }
	
	// check om billedet forekommer mere end een gang i gallerierne
	
	$query="select url from gal_images where id = '$id'";
	$url = $db->query($query)->fetch_object()->url;

	$query2="select count(id) as antal from gal_images where url = '$url'";
	$antal = $db->query($query2)->fetch_object()->antal;
	
	if ($antal > 1) {
		$ng = 0;
		$query3 = "select id, type, nummer from gal_images where url = '$url'";
		$result3 = $db->query($query3);
		while ( $slist = $result3->fetch_array() ) {
			$imgid[$ng] = $slist[0];
			$typeid[$ng] = $slist[1];
			$nummer[$ng] = $slist[2];
			$ng++;			
		} 
	}
	?>
	<br /><br />
	<div style="display: inline-block; width:300px;">
	  <a class="grouped_elements" rel="" href="<?php echo $img[1]; ?>"><img src="<?php echo $img[2]; ?>" alt="<?php echo $id; ?>" title="<?php echo $id; ?>" class="adm_img"></a>
	</div>
	<?php
	if ($antal > 1) {
	?>
	<div style="display: inline-block; width:800px; vertical-align: top; ">
		<b>Bildet er plassert mer enn en gang i galleriene!</b><br />Hvilken forekomst vil du slette?<br /><br /><br />
		
		<form name="multislet" action="adm_multislet.php" method="post" OnSubmit="return confirm('Er du helt sikker?');">
		<table>
		<?php
		for ($mg = 0 ; $mg<$ng ; $mg++) {
			$query2 = "select typename, katid from gal_type where typeid = '$typeid[$mg]'";
			@$tyname[$mg] = $db->query($query2)->fetch_object()->typename;
			@$kid[$mg] = $db->query($query2)->fetch_object()->katid;

			$query3 = "select katname, natid, natnavn from gal_kategori where katid = '$kid[$mg]'";
			@$kname[$mg] = $db->query($query3)->fetch_object()->katname;
			@$nid[$mg] = $db->query($query3)->fetch_object()->natid;
			@$nname[$mg] = $db->query($query3)->fetch_object()->natnavn;
			
			$query4 = "select enhet, info from gal_unit where numid = '$nummer[$mg]'";
			@$enhet[$mg] = $db->query($query4)->fetch_object()->enhet;
			@$info[$mg] = $db->query($query4)->fetch_object()->info;
		?>
		<tr>
			<td>
				<input type="checkbox" name="image[]" value="<?php echo $imgid[$mg]; ?>" style="line-height: 15px;">
			</td>	
			<td>
				<a href="<?php echo $path; ?>subpage.php?s=1&l=<?php echo $nid[$mg]; ?>" target="_blank" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $nname[$mg]; ?></a> > 
				<a href="<?php echo $path; ?>subpage.php?s=2&k=<?php echo $kid[$mg]; ?>" target="_blank" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $kname[$mg]; ?></a> >
				<a href="<?php echo $path; ?>subpage.php?s=3&t=<?php echo $typeid[$mg]; ?>" target="_blank" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $tyname[$mg]; ?></a> >
				<a href="<?php echo $path; ?>subpage.php?s=4&u=<?php echo $nummer[$mg]; ?>" target="_blank" class="galsearch" onfocus="if(this.blur)this.blur()"><?php echo $enhet[$mg]; ?></a>
			</td>
		 </tr>
		<?php
		}
		?>
		</table>
		<br /><br />
			<input type="hidden" name="antal" value="<?php echo $antal; ?>" />
	        <input type="submit" value="slet" class="button15">
		</form>

	</div>
	<?php } ?>	
	<br /><br /><br />
	<?php
	if ($antal == 1) {
	?>
	 <form name="del" method="post" action="adm_ph_slet.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
	         <input type="hidden" name="id" value="<?php echo $img[0]; ?>">
	         <input type="hidden" name="page" value="<?php echo $page; ?>" />
	         <input type="hidden" name="ae" value="<?php echo $ae; ?>" />
	         <input type="hidden" name="u" value="<?php echo $unit; ?>" />
	         <input type="hidden" name="fi" value="<?php echo $fi; ?>" />
	        <input type="submit" value="slet bildet" style="width: 250px; text-align: left;">
	</form>
	<?php
	}
	?>
	        
	<?php
	 }
	else
	{
	?>	
	<div style="text-align:left;">
	   <br />
	     <form action="index.php?s=4<?php echo $ae_parstr; ?>" method="post">
		     bilde-id: &nbsp;&nbsp;<input type="text" name="id" style="width: 70px;"><br><br>
		     <input type="hidden" name="u" value="<?php echo $uke; ?>">
		     <input type="submit" class="button15" value="hent bilde">
	     </form>
	
	</div>	
		
<?php	
} 
?>
<br  /><br />
</div>