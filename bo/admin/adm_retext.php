<?php
// FP/20231009
//
// Made from adm_gal_dete.php
//
// The purpose is to change the caption of a picture in the gallery
//
?>

<script type="text/javascript" src="fancybox/jquery_min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
jQuery(function($){
  $.datepicker.regional['no'] = {
    closeText: 'Lukk',
    prevText: '&laquo;Forrige',
    nextText: 'Neste&raquo;',
    currentText: 'I dag',
    monthNames: ['januar','februar','mars','april','mai','juni','juli','august','september','oktober','november','desember'],
    monthNamesShort: ['jan','feb','mar','apr','mai','jun','jul','aug','sep','okt','nov','des'],
    dayNamesShort: ['s&oslash:n','man','tir','ons','tor','fre','l&oslash;r'],
    dayNames: ['s&oslash;ndag','mandag','tirsdag','onsdag','torsdag','fredag','l&oslash;rdag'],
    dayNamesMin: ['s&oslash;','ma','ti','on','to','fr','l&oslash;'],
    weekHeader: 'Uke',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['no']);
});

</script>
<style type="text/css">

.btn,
.btn-search {
  color: #fff;
  background: #295073;
  display: inline-block;
  width: min-content;
  white-space: nowrap;
  border: 1px solid transparent;
  border-radius: 5px;
  padding: .1rem .5rem;
  line-height: 1.5;
  vertical-align: middle;
  text-transform: uppercase;
}

.btn {
  font-size: 0.9rem;
}

.btn:hover {
  color: #fff;
  background: #c8743d;
  cursor: pointer;
}

.btn-primary {
  background-color: #295073;
  border-color: #295073;
}
.btn-primary:hover {
  background-color: #137ad7;
  border-color: #137ad7;
}

.form-control {
  display: block;
  width: 100%;
  height: calc(2.25rem + 2px);
  padding: .375rem .75rem;
  font-size: 1rem;
  line-height: 1.5;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
}

label {
  display: inline-block;
}

textarea {
  min-height: 7rem;
}

/* input[type=submit] {
  float: right;
  margin-bottom: 1rem;
} */

input[type=submit]:hover {
  cursor: pointer;
}

.form-group {
  margin-bottom: 1rem;
}


</style>

<style type="text/css">
		.retext {
			width: 380px;
		}
		.retext_button {
			border: 5px, solid, blavk;
			padding: 10px;
			width: 240px;
			border-radius: 10px;
			color: #f5b91d;
			background-color: #800000;
			font-weight: bold;
		}
	</style>


<!--
<script type="text/javascript">
	$(document).ready(function() {
		$("a.grouped_elements").fancybox({
			'padding': 0,
			'margin': 0,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'titlePosition': 'none',
			'titleShow': 'none'
		});
	});
</script>
-->

<!--  script for validating date input  -->
<script>
           function isValidDate(sText) {
            var reDate = /(?:0[1-9]|[12][0-9]|3[01])\.(?:0[1-9]|1[0-2])\.(?:19|20\d{2})/;
           return reDate.test(sText);
    		}   		
          function validate() {
          if(document.getElementById('datepicker1').value != ''){
            var oInput1 = document.getElementById("datepicker1");
            if (isValidDate(oInput1.value)) {
           } else {
           if (document.getElementById('datepicker1').value != '')
            alert("Feil i datoformat - bilde 1"); return false;
            }
        }
              
     }
</script>

<div class="wide_heading">
	Rett fotograf, tekst og dato på et billede i galleriet
</div>
<div class="wide_content" style="overflow: hidden;">

	<br />

	<?php

function html_escape($text): string
{
    // Next line is an update for PHP 8.1 see https://phpandmysql.com/updates/passing-null-to-string-functions/
    $text = $text ?? ''; // If the value passed into function is null set $text to a blank string

    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
}


	if (!isset($_POST['id'])) {
		@$id = $_GET['id'];
	}
	if (isset($_POST['u'])) {
		$unit = $_POST['u'];
	} else {
		$unit = '';
	}
	if (isset($_POST['page'])) {
		$page = $_POST['page'];
	} else {
		$page = 1;
	}
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	if (isset($_POST['fi'])) {
		$fi = $_POST['fi'];
	}
	if (isset($_GET['fi'])) {
		$fi = $_GET['fi'];
	}
	if (!isset($_POST['ae'])) {
		$ae = -1;
	} else {
		$ae = $_POST['ae'];
	}
	if (isset($_GET['ae'])) {
		$ae = $_GET['ae'];
	}

	// set active element parameter string
	$ae_parstr = "";
	if ($ae > 0) {
		$ae_parstr = "&amp;ae=" . $ae;
	}
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}

// Test: Print the parameters
	// echo("<p>id = " . $id . "</p>");
	// echo("<p>u = " . $unit . "</p>");
	// echo("<p>page = " . $page . "</p>");
	// echo("<p>fi = " . $fi . "</p>");
	// echo("<p>ae = " . $ae . "</p>");
	// echo("<p>ae_parstr = " . $ae_parstr . "</p>");

// Test ende

if ($id > 0) {
?>
	<div class="phylla_line">

<?php
	$query = "select * from gal_images where id = '$id'";
	$result = $db->query($query);
	$img = $result->fetch_array();


	// check om billedet forekommer mere end een gang i gallerierne

	$query = "select url from gal_images where id = '$id'";
	$url = $db->query($query)->fetch_object()->url;
	?>
	<br /><br />

	<div class="phylla_img">
	<div style="display: inline-block; width:300px;">
		<a class="grouped_elements" rel="" href="<?php echo $img[1]; ?>"><img src="<?php echo $img[2]; ?>" alt="<?php echo $id; ?>" title="<?php echo $id; ?>" class="adm_img"></a>
	</div>
	</div>
	<div class="phylla_text">
		<!--  Tre input type text med fotograf, tekst og dato -->


	<div class="phylla_text_left">Fotograf:</div>
	<div class="phylla_text_right"><?php echo $img[5]; ?></div>
	<div class="phylla_text_left">Tekst:</div>
	<div class="phylla_text_right"><?php echo $img[4]; ?></div>
	<div class="phylla_text_left">Dato:</div>
	<div class="phylla_text_right"><?php if ($img[6] != 0) {echo date('j.n.Y', $img[6]);} ?></div>
	<div class="phylla_text_left">Placering:</div>
	<div class="phylla_text_right"><?php echo $img[25]; ?></div>
</div>	



	<br /><br /><br />

<div class="phylla_text">
	<form name="retext" method="post" action="adm_retext_update.php" onsubmit="return validate()">

		<div class="phylla_text_left">Fotograf:</div>
		<div class="phylla_text_right"><input class="retext" type="text" name="fotograf" value="<?php echo htmlspecialchars($img[5]); ?>"></div>
		<br />
		<div claas="phylla_text_left">&nbsp;</div>
		<div class="phylla_text_left">Tekst:</div>
		<div class="phylla_text_right"><input class="retext" type="text" name="tekst" value="<?php echo htmlspecialchars($img[4]); ?>"></div>
		<br />
		<div claas="phylla_text_left">&nbsp;</div>
		<div class="phylla_text_left">Dato:</div>
		<div class="phylla_text_right"><input class="retext" type="text" name="dato"  id="datepicker1" value="<?php if ($img[6] != 0) {echo date('j.n.Y', $img[6]);} ?>"></div>
		<br />
		<div claas="phylla_text_left">&nbsp;</div>
		<div class="phylla_text_left">&nbsp;</div>
		<div class="phylla_text_right"><input class="button15" type="submit" value="Oppdater tekst på bildet">

		<input type="hidden" name="id" value="<?php echo $img[0]; ?>">
		<input type="hidden" name="page" value="<?php echo $page; ?>" />
		<input type="hidden" name="ae" value="<?php echo $ae; ?>" />
		<input type="hidden" name="u" value="<?php echo $unit; ?>" />
		<input type="hidden" name="fi" value="<?php echo $fi; ?>" />
	</form>
</div>
<?php
} else {
?>
<div style="text-align:left;">
<br />
  <form action="index.php?s=15<?php echo $ae_parstr; ?>" method="post">
	  bilde-id: &nbsp;&nbsp;<input type="text" name="id" style="width: 70px;"><br><br>
	  <input type="hidden" name="u" value="<?php echo $uke; ?>">
	  <input type="submit" class="button15" value="hent bilde">
  </form>

</div>	
<?php
}

?>
	<br /><br />
</div>
</div>

<!-- script for datepicker --> 
<script>
			$(document).ready(function(){
			 var d = new Date();
		         var ty = (d.getFullYear());
			$(function() {
				$( "#datepicker1" ).datepicker({
					changeMonth: true,
					changeYear: true
				});
				$( "#datepicker1" ).datepicker( "option", "yearRange", '1960:ty' );
			});
		})
		</script>	

