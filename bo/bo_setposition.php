<?php

if(isset($_POST['imgx'])) {$imgx = $_POST['imgx']; }
if(isset($_POST['img1'])) {$img1 = $_POST['img1']; } else { $img1 =''; } 
if(isset($_POST['img2'])) {$img2 = $_POST['img2']; } else { $img2 =''; }
if(isset($_POST['img3'])) {$img3 = $_POST['img3']; } else { $img3 =''; }
if(isset($_POST['img4'])) {$img4 = $_POST['img4']; } else { $img4 =''; }
if(isset($_POST['img5'])) {$img5 = $_POST['img5']; } else { $img5 =''; }


if(isset($_POST['latval'])) {$lat = $_POST['latval']; }
if(isset($_POST['longval'])) {$long = $_POST['longval']; }

if(isset($_POST['latlng'])) { $latlng = $_POST['latlng']; 	
	
	
	
	if ($latlng!='') {
	
	preg_match('#\((.*?)\)#', $latlng, $latlng);
	$lat = substr($latlng[1],0,strpos($latlng[1],','));
	$long = substr($latlng[1],strpos($latlng[1],',')+1);
	}
}
else {
	$lat=$_POST['latval'];
	$lon=$_POST['lonval'];
}


if(isset($_POST['retur'])) {$retur = $_POST['retur']; } else {$retur='';}
if(isset($_POST['page'])) {$page = $_POST['page']; } else {$page='';}
if(isset($_POST['adm'])) {$adm = $_POST['adm']; } else {$adm=0;}
if(isset($_POST['id'])) {$id = $_POST['id']; } else {$id=0;}

include('configi.php');



 


if($id>0) {
    $query="UPDATE gal_images SET latitude = '$lat' WHERE id = '$id'";
    $query1="UPDATE gal_images SET longitude = '$long' WHERE id = '$id'";
} else {   
    $query="UPDATE gal_images SET latitude = '$lat' WHERE navn = '$imgx'"; 
    $query1="UPDATE gal_images SET longitude = '$long' WHERE navn = '$imgx'";
}

$result = mysqli_query($db, $query);
$result1 = mysqli_query($db, $query1);

$filecheck1 = '';
$filecheck2 = '';
$filecheck3 = '';
$filecheck4 = '';
$filecheck5 = '';

if ($img1!='') { $filecheck1='true'; }
if ($img2!='') { $filecheck2='true'; }
if ($img3!='') { $filecheck3='true'; }
if ($img4!='') { $filecheck4='true'; }
if ($img5!='') { $filecheck5='true'; }

if ($adm==1) { ?>
<form name="end" action="subpage.php?s=0&id=<?php echo $id; ?>" method="post">
<?php 
} else { ?>
<form name="end" action="subpage.php?s=52" method="post">
<?php
}
?>

<input type="hidden" name="img1" value="<?php if ($img1!='') {echo $img1; $filecheck1='true'; } else {$img1='';} ?>" />
<input type="hidden" name="img2" value="<?php if ($img2!='') {echo $img2; $filecheck2='true'; } else {$img2='';} ?>" />
<input type="hidden" name="img3" value="<?php if ($img3!='') {echo $img3; $filecheck3='true'; } else {$img3='';} ?>" />
<input type="hidden" name="img4" value="<?php if ($img4!='') {echo $img4; $filecheck4='true'; } else {$img4='';} ?>" />
<input type="hidden" name="img5" value="<?php if ($img5!='') {echo $img5; $filecheck5='true'; } else {$img5='';} ?>" />

<input type="hidden" name="filecheck1" value="<?php echo $filecheck1; ?>" />
<input type="hidden" name="filecheck2" value="<?php echo $filecheck2; ?>" />
<input type="hidden" name="filecheck3" value="<?php echo $filecheck3; ?>" />
<input type="hidden" name="filecheck4" value="<?php echo $filecheck4; ?>" />
<input type="hidden" name="filecheck5" value="<?php echo $filecheck5; ?>" />

<input type="hidden" name="lastlat" value="<?php echo $lat; ?>" />
<input type="hidden" name="lastlon" value="<?php echo $long; ?>" />

</form>

<form name="myimg" action="subpage.php?s=60" method="post">
 <input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
 if ($retur=='myimg') 
 {
?> 	
 <script language="javascript" type="text/javascript">
   document.myimg.submit();
 </script>
<?php 	
 }
else { 
 ?>
<script language="javascript" type="text/javascript">
   document.end.submit();
</script>
<?php  }  ?>