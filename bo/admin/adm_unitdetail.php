<?php
//error_reporting(E_ERROR | E_PARSE);
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

ini_set("include_path", '/var/www/jernbane.net/php:' . ini_get("include_path") );

require_once 'HTML/Table.php';

$land='0';	
if (isset($_POST["land"])) { $land=$_POST["land"]; }
if (isset($_GET["l"])) { $land=$_GET["l"]; }
	
$cat='0';	
if (isset($_POST["cat"])) { $cat=$_POST["cat"]; }	
if (isset($_GET["c"])) { $cat=$_GET["c"]; }	
	
$type='0';	
if (isset($_POST["type"])) { $type=$_POST["type"]; }	
if (isset($_GET["t"])) { $type=$_GET["t"]; }	

$unit='0';	
if (isset($_POST["unit"])) { $unit=$_POST["unit"]; }	
if (isset($_GET["u"])) { $unit=$_GET["u"]; }	

$query = "SELECT * FROM gal_nations ORDER BY plass ASC";
$result = $db->query($query);
?>   

<link href="jquery/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">

<script src="jquery/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui-1.11.4/jquery-ui.js"></script>
<style>
	body{
		font: 62.5% "Trebuchet MS", sans-serif;
		/* margin: 50px; */
	}
	.demoHeaders {
		margin-top: 2em;
	}
        a.dialog-link-class {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	a.dialog-link-class span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
        
.anchor {
    display: block;
    padding-top: 60px;
    margin-top: -60px;
}
        
</style>
        
<!-- Editable grid setup -->
<script type="text/javascript" src="editablegrid/editablegrid.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_validators.js"></script> 
<script type="text/javascript" src="editablegrid/editablegrid_renderers.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_editors.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_utils.js"></script>
<script type="text/javascript" src="editablegrid/editablegrid_charts.js"></script>

<link rel="stylesheet" href="editablegrid/editablegrid.css" type="text/css" media="screen">

<style>
        body { font-family:'lucida grande', tahoma, verdana, arial, sans-serif; font-size:11px; }
        h1 { font-size: 15px; }
        a { color: #548dc4; text-decoration: none; }
        a:hover { text-decoration: underline; }
        table.editorgrid { border-collapse: collapse; border: 1px solid #aaa; width: 780px; }
        table.editorgrid td, table.editorgrid th { padding: 5px; border: 1px solid #a0a0a0; }
        table.editorgrid th { background: #f0f0f0; text-align: left; }
        table.editorgrid td { background: #f0f0f0; }
        table.editorgrid tr { border-bottom: 1px solid #a0a0a0; }
        input.invalid { background: red; color: #FDFDFD; }
</style>

<style>
    h1.info_heading { color: #548dc4; text-align: left; margin: 20px 40px 20px 0px; text-decoration: underline; font-size:20px; display: inline;  }
    h2.info_type_heading { color: #548dc4;  margin: 20px 0px 5px 20px; }
    div.info_type_content { margin: 0px 0px 0px 20px; }
    p.tekst_tittel { font-size:12px; font-weight: bold; margin-bottom: -7px; margin-top: 0px;}
    p.tekst_body { font-weight: normal; margin-bottom: 0px; }
    div.tekst_boks { padding: 3px 10px 3px 10px; border-collapse: collapse; border: 1px solid #CCB; width: 800px;   
                      -moz-box-shadow: 3px 3px 4px #888; -webkit-box-shadow: 3px 3px 4px #888; box-shadow: 3px 3px 4px #888;}
    table.infotable { border-collapse: collapse; border: 1px solid #CCB; width: 800px;   
                      -moz-box-shadow: 3px 3px 4px #888; -webkit-box-shadow: 3px 3px 4px #888; box-shadow: 3px 3px 4px #888; }
    td.infotable_title {  background: #990000; text-align: left; color: #FDFDFD; padding: 2px; font-size:13px;  }
    td.infotable_coltitle { text-decoration: none; text-align: center; font-weight: bold; background: #dddddd; }
    td.pictable_cell { text-decoration: none; text-align: center; width: 200px; padding: 3px; }
    td.pictable_kommentar { text-decoration: none; text-align: center; padding: 3px; }
    td.pictable_heading { text-decoration: none; text-align: center; padding: 3px; font-weight: bold; }
    td.spectable_kat { text-decoration: none; text-align: left; font-weight: bold; }
    td.spectable_info { text-decoration: none; text-align: left; }
    textarea.texteditclass { width:750 !important; }
</style>

<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" >

/*
// korriger image paths hvis de er relative
$('.large-image > img').each(function(){
     var msrc=$(this).attr('src');
     var isAbsolute = new RegExp('^([a-z]+://|//)');

    if (! isAbsolute.test(msrc)) {
        // add a ../ to the path
        msrc = "../" + msrc;
        $(this).attr('src', msrc);
    }
})
*/
</script>
<form name="add" method="post" action="index.php?s=3&p=5">
<TABLE class="admtable1">
			<TR>
			      <td WIDTH="90">
			         <select name="land" onChange="this.form.submit()">
			         <option>Velg land</option>
	<?php while ( $liste = $result->fetch_array() ) {	         
             echo '<option value="'; echo $liste[0]; echo '"'; if ($liste[0]==$land) {echo ' selected';} echo '>'; echo $liste[2]; 
             echo '</option>';
							}  ?>
			         </select> <br>&nbsp;
			      </td>
			      <td width="40" align="center">
			        
			      </td>
			      <td WIDTH="250">
	<?php
	if ($land != 0) {
		$query ="SELECT * FROM gal_kategori WHERE natid = '$land' ORDER BY plass ASC";
		$result = $db->query($query);	      
	?>		      
			         <select name="cat" onChange="this.form.submit()">
			         <option>Velg kategori</option>
	<?php while ( $liste1 = $result->fetch_array() ) {		         
             echo '<option value="'; echo $liste1[0]; echo '"'; if ($liste1[0]==$cat) {echo ' selected';} echo '>'; echo $liste1[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=2&amp;l=<?php echo $land; ?>">rediger</a> 
			         <?php }  ?>
			      </td>
			      <td>
	<?php
	if ($cat != 0) {
		$query ="SELECT * FROM gal_type WHERE katid = '$cat' ORDER BY plass ASC";
		$result = $db->query($query);	      
	?>		      
			         <select name="type" onChange="this.form.submit()">
			         <option>Velg type</option>
	<?php while ( $liste2 = $result->fetch_array() ) {			         
             echo '<option value="'; echo $liste2[0]; echo '"'; if ($liste2[0]==$type) {echo ' selected';} echo '>'; echo $liste2[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=3&amp;l=<?php echo $land; ?>&amp;c=<?php echo $cat; ?>">rediger</a> 
			         <?php }  ?>
					 
			      </td>
				  			      <td>
	<?php
	if ($type != 0) {
		$query ="SELECT * FROM gal_unit WHERE typeid = '$type' ORDER BY plass ASC";
		$result = $db->query($query);	      
	?>		      
			         <select name="unit" style="width:450px" onChange="this.form.submit()">
			         <option>Velg enhet/sted</option>
	<?php while ( $liste3 = $result->fetch_array() ) {			         
             echo '<option value="'; echo $liste3[0]; echo '"'; if ($liste3[0]==$unit) {echo ' selected';} echo '>'; echo $liste3[1]; 
             echo '</option>';
							}  ?>
			         </select><br><a href="index.php?s=3&amp;p=4&amp;l=<?php echo $land; ?>&amp;c=<?php echo $cat; ?>&amp;t=<?php echo $type; ?>">rediger</a>
			         <?php }  ?>
					 
			      </td>
			 </TR>
</table>
</form>
<?php
 if ($land!=0 && $cat!=0 && $type!=0 &&$unit!=0) {
?>
<?php
if (isset($unit)) {
$enhet = $db->query("select enhet from gal_unit where numID = '$unit'")->fetch_object()->enhet;
echo "<h2>",$enhet."</h2>";
}
?>

<form name="add" method="post" action="adm_unitdetail_add.php">
<table cellpadding="3" cellspacing="0" class="admtable1">
			<TR>
			      <td WIDTH="350" >
			         <input type="text" name="nyunitdetail" style="width:340px;" value="ny detalj" />
			      </td>
			      <td WIDTH="90">
			         plasser etter nr. 
			      </td>
			      <td width="40" align="center">
			        <input type="text" name="seq" style="width: 30px;" />
			      </td>
			      <td >
			         <input type="submit" value="legg til" />
			      </td>
			 </TR>
</table>
<input type="hidden" name="land" value="<?php echo $land; ?>" />
<input type="hidden" name="cat" value="<?php echo $cat; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<input type="hidden" name="unit" value="<?php echo $unit; ?>" />
</form> 	
<br />

<form name="updateform" action="adm_unitdetail_update.php" method="post">
<table cellpadding="3" cellspacing="0" class="admtable">
   <tr>
      <td width="40" valign=top>
         <b>Plass</b>
      </td>
      <td width="250" valign=top>
         <b>Detalj</b>
      </td>
      <td valign="top" width="40" >
         <b>Info</b>
      </td>
      <td valign="top" width="40" >
         <b>Slette</b>
      </td>
 </tr>

<script type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=400px,width=820px');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>



<?PHP
$n=1;
$query = "SELECT * FROM `gal_unitdetail` WHERE numid = '$unit' ORDER BY plass";
$result = $db->query($query);
while ( $liste4 = $result->fetch_array() ) {
?>



<tr id="<?php echo $liste4[0]; ?>" class="anchor">

  <td width="40">
	 <input type="text" name="s<?PHP echo $n; ?>" style="width: 30px; border: 0px;" value="<?PHP echo $liste4[4]; ?>" />
  </td>
  <td width="250">
    <input type="text" name="u<?PHP echo $n; ?>" style="width: 390px; border: 0px;" value="<?PHP echo htmlspecialchars($liste4[1]); ?>" />
    <input type="hidden" name="i<?PHP echo $n; ?>" value="<?PHP echo $liste4[0]; ?>" />
  </td>
  <td width="40">
     <a href="#" onClick="popitup('adm_unitdetailinfo.php?l=<?php echo $land; ?>&c=<?php echo $cat; ?>&t=<?php echo $type; ?>&u=<?php echo $unit; ?>&d=<?php echo $liste4[0]; ?>')" style="color: blue;">info</a>
  </td>
  <td width="40">
     <a href="#" onClick="window.location.href='adm_unitdetail_delcheck.php?l=<?php echo $land; ?>&c=<?php echo $cat; ?>&t=<?php echo $type; ?>&u=<?php echo $unit; ?>&d=<?php echo $liste4[0];?>'" style="color: blue;">slett</a>

  </td>

</tr>	 

<?PHP
$n=$n+1;
}
?>	
</TABLE>
<br>
<input type="HIDDEN" name="land" value="<?php echo $land; ?>" />
<input type="hidden" name="cat" value="<?php echo $cat; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<input type="hidden" name="unit" value="<?php echo $unit; ?>" />
<input type="hidden" name="antal" value="<?php echo $n; ?>" />
<input type="submit" value="  oppdatere endringer  " />
</form>

<br><br>
 	
<?php 	
 	}   // slut if begge variable er sat
?>
