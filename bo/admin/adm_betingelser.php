<div style="margin-left: 50px; height: 600px;">
<b>Bruksbetingelser</b>
<?php
if (isset($_POST['language'])) {$language=$_POST['language'];} else {$language='norsk';}

?>

<div style="display:inline-block;">
	<form name="lan" action="index.php?s=12" method="POST">
		<select name="language" onchange="this.form.submit()">
	  	  <option value="norsk" <?php if ($language=='norsk'){echo "selected";} ?>>norsk</option>
	  	<option value="english" <?php if ($language=='english'){echo "selected";} ?>>english</option>
		</select>  
	</form>	
</div>
<br /><br />
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
	//	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	//	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	//	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<?php
if ($language == 'norsk') {$id = 1;}
if ($language == 'english') {$id = 2;}

$query = "select tekst from misc_betingelser where id = '$id'";	
$tekst = $db->query($query)->fetch_object()->tekst;

?>	
<form method="post" action="adm_update_betingelser.php">
	<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
	<textarea id="elm1" name="tekst" cols="90" rows="30">
		<?php echo $tekst; ?>
	</textarea>
	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<br />
	<input type="submit" name="Gem" value="Opdatér" />
	
</form>

</div>
