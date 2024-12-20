<?php
 if (isset($_GET['p'])) { 
 $p=$_GET['p']; }
?>

<div class="wide_heading">
	Tabeller
</div>
<div class="wide_content" style="overflow: hidden;">
<div style="width: 1240px;">
	<b><a href="index.php?s=3&amp;p=1" class="<?php if ($p==1){echo "admhigh";} else {echo "admnorm";} ?>">Land</a></b>
	<br />
    <b><a href="index.php?s=3&amp;p=2" class="<?php if ($p==2){echo "admhigh";} else {echo "admnorm";} ?>">Kategori</a></b>
    <br />
    <b><a href="index.php?s=3&amp;p=3" class="<?php if ($p==3){echo "admhigh";} else {echo "admnorm";} ?>">Type/Bane</a></b>
    <br />
    <b><a href="index.php?s=3&amp;p=4" class="<?php if ($p==4){echo "admhigh";} else {echo "admnorm";} ?>">Enhet/Sted</a></b>
    <br />
    <b><a href="index.php?s=3&amp;p=5" class="<?php if ($p==5){echo "admhigh";} else {echo "admnorm";} ?>">Detaljer</a></b>
    <br />
<?php
if (isset($_GET['p'])) { 
?>
		<hr />
<?php 
 if ($p==1) { include('adm_land.php'); }
 if ($p==2) { include('adm_kategori.php'); }
 if ($p==3) { include('adm_type.php'); }
 if ($p==4) { include('adm_unit.php'); }
 if ($p==5) { include('adm_unitdetail.php'); }
?> 


<?php
}
?>
<br /><br />
</div>
</div>