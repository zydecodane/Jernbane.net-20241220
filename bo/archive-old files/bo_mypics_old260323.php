<?php
// check if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;

	// check if user is logged in - find user in cookie
	if (isset($_COOKIE["bbuserid"]))
	{ $loggedin = 1;} else {$loggedin = 0;}
	// get users real name and admin/notadmin from database

	$userid = $_COOKIE["bbuserid"];
	include ('configi.php');

	$dbase2 =  'jernbane_net_db_forum';		
	$db2 = new mysqli($dbserver, $dbuserid, $dbpw, $dbase2);
	$db2->set_charset("utf8");
	$user = $db2->query("select displayname from user where userid = '$userid'")->fetch_object()->displayname;

}
// another check whether the user is really logged in
if ($userid > 0)
{

// user from image-table
// $imguser = substr($img[7],0,strpos($img[7],' -'));

if(!isset($_POST['eg'])){$eg = 0;}
else {$eg = $_POST['eg'];}
if(isset($_GET['eg'])){$eg = $_GET['eg'];}


$tableuser = $userid." - ".$username;

if(isset($_GET['p'])){$page = $_GET['p'];} else {$page=1;}

if(isset($_POST['page'])){$page = $_POST['page'];} 

$nrpp = 25; //number of rows per page

// how many are there...
$n=0;
unset ($id);
if ($eg==0) {
$query = "select id, fotograf from gal_images where bruker = '$tableuser' and fotograf = '$username' and timestamp > 1645444800 order by timestamp desc";
} 
if ($eg == 2) {
$query = "select id, fotograf from gal_images where bruker = '$tableuser' and latitude = '0' and fotograf = '$username' and timestamp > 1645444800 order by timestamp desc";	
}
$result = $db->query($query);
while ( $init = $result->fetch_array() ) {
	
$id[$n] = $init[0];
$n=$n+1;
}
$antal=$n;

$pages = ceil($antal/$nrpp);

$startpoint = $nrpp*$page-$nrpp;
$m=$startpoint;
?>


<br />
<div id="bo_heading">
 <span style="font-size: 14px; font-weight: bold;">&nbsp;&nbsp;&nbsp;<?php echo $username; ?> - mine bilder</span>
 <img src="graphics/filler.gif" height="1px" width="50px" />
 <span style="font-size: 12px;">Denne siden viser bare bilder lastet opp etter skift til ny forum-motor 21.2.2022</span>
<img width="10px" height="23px" src="graphics/filler.gif">
<img class="logo_align" src="graphics/jernbanenet_h28.gif">
</div>
<div class="bo_intro">
  <br />


<form name="egform" id="egform" method="post" action="subpage.php?s=60">
<input type="radio" name="eg" <?php if($eg == 0){ echo "checked";} ?> value="0" onClick="document.egform.submit()" />&nbsp;&nbsp;alle
<br />
<input type="radio" name="eg" <?php if($eg == 2){ echo "checked";} ?> value="2" onClick="document.egform.submit()" />&nbsp;&nbsp;bilder uten geodata
</form>




<!-- bladring-divtag  -->
<div style="width: 1098px; text-align: center;">
<?php
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=60&amp;p=1&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php if ($page==1) {echo '1';} else {echo $page-1;} ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
   <?php 
   }					
	$fra=1; $til=$pages;
	if ($pages > 30)
		{
			if ($page>14) {$fra=$page-14;} else {$fra=1;}
			$til=$fra+29; if ($til>$pages) {$til=$pages;}	
			if ($fra>($til-29)) {$fra=$til-29;}
		}				
	else {$til=$pages;}	
	if ($fra>1) {echo "..";}		
 	for ($b = $fra ; $b<$til+1 ; $b++) 
   		{ 
   		if ($b>1) {if ($b>$fra){echo chr(124);}}
   	
   	if ($b==$page){echo "<b> ";}
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=60&amp;p=<?php echo $b ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><?php }
   	  	 echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   		}
   	if($til<$pages) {echo "..";}	
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php echo $pages; ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">>></a>
  	<?php
  						}
}
?>
</div>
<!-- bladring-divtag slut -->

<br />
<hr />

<?php for ($tr = 0 ; $tr<($nrpp) ; $tr++) { 

@$query1 = "select id, url, thumb, tekst, fotograf, dato, type, nummer, timestamp, latitude, longitude, navn, clean_url, clean_thumb from gal_images where id = '$id[$m]'";
$result1 = $db->query($query1);
@$img = $result1->fetch_array();

$m=$m+1;
if ($img[0] > 0) {
?>
<table width="1090" cellpadding="0" cellspacing="0" border="0" style="color: #000000;">
<tr >
 <td width="30"><br/></td>
 <td width="300" valign="top">
 <br />
  <a href="subpage.php?s=0&amp;id=<?php echo $img[0]; ?>"><img src="<?php echo $img[13]; ?>" class="adm_img" alt="<?php echo $img[0]; ?>" title="<?php echo $img[0]; ?>" /></a>
  <br /><br />
 </td>
 <td width="500" valign="top">
  <br />
      <table cellpadding="1" cellspacing="0" border="0" width="705">
       <tr>
        <td width="80" valign="top">
           <b>Fotograf:</b>
        </td>
        <td valign="top">
             <?php echo $img[4]; ?>
        </td>
        <td width="210" align="right">
        <?php if ($img[9] > 0 ) { 
         $position = $img[9].','.$img[10];	
         	?>
         <input type="submit" value="Se posisjon" style="width: 200px; text-align: left;" onClick="window.open('show_geo.php?pos=<?php echo $position; ?>','sgeo','width=400,height=400')" />
         <?php } else { echo "ingen geodata"; } ?>        
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <b>Opplastet:</b>
        </td>
        <td valign="top">
           <?PHP echo date("d.m.Y - H:i",$img[8]); ?>
        </td>
        <td width="210" align="right">
			<form name="setgeo<?php echo $img[0]; ?>" method="post" action="subpage.php?s=53">
	         <input type="hidden" name="img1" value="<?php echo $img[11]; ?>" />
	         <input type="hidden" name="is" value="1" />
	         <input type="hidden" name="retur" value="myimg" />
	         <input type="hidden" name="page" value="<?php echo $page; ?>" />
	         <input type="submit" value="Sett / endre posisjon" style="width: 200px; text-align: left;" />
        </form>        
        </td>
       </tr>
       <tr>
        <td width="80" valign="top">
           <br />
        </td>
        <td valign="top">
           <br />
        </td>
        <td width="210" align="right">
        
        
             
        </td> 
       </tr>
<?php
// mulighed for at slette såfremt det er under en time siden opplasting
if ( (date('U') - 3600) < $img[8])
 {
?>       
       <tr>
        <td width="80" valign="top">
           <br />
        </td>
        <td valign="top">
           <br />
        </td>
        <td width="210" align="right">
        <form name="del<?php echo $img[0]; ?>" method="post" action="bo_deletemypic.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
        	<input type="hidden" name="id" value="<?php echo $img[0]; ?>">
        	<input type="hidden" name="url" value="<?php echo $img[1]; ?>">
        	<input type="hidden" name="thumb" value="<?php echo $img[2]; ?>">
        	<input type="hidden" name="navn" value="<?php echo $img[11]; ?>">
            <input type="submit" value="slett bildet" style="width: 200px; text-align: left;" />
        </form>     
        </td> 
       </tr>
<?php
	}
?>       
    </table>
    <table cellpadding="1" cellspacing="0" border="0" width="478">   
       <tr>
        <td valign="top">
           <b>Forum-kode:</b><br />
           <?PHP $phorumcode =  "\n\n"."[img]"."https://jernbane.net".$img[12]."[/img]"; ?>
           <textarea name="forumkode" rows="3" style="width: 700px; font-size: 11px; border: 1px solid #800000;"><?php echo $phorumcode  ?></textarea>
        </td>
       </tr>
      
      </table>
 <br />
 
 <br />
    
</tr>
</table>
<hr />
<?php	
  }
}
?>


<br />
<!-- bladring-divtag  -->
<div style="width: 1098px; text-align: center;">
<?php
if ($pages > 1) { 
	if ($page > 0)  {
	?>
   <a href="subpage.php?s=60&amp;p=1&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php if ($page==1) {echo '1';} else {echo $page-1;} ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;
   <?php 
   }					
	$fra=1; $til=$pages;
	if ($pages > 30)
		{
			if ($page>14) {$fra=$page-14;} else {$fra=1;}
			$til=$fra+29; if ($til>$pages) {$til=$pages;}	
			if ($fra>($til-29)) {$fra=$til-29;}
		}				
	else {$til=$pages;}	
	if ($fra>1) {echo "..";}		
 	for ($b = $fra ; $b<$til+1 ; $b++) 
   		{ 
   		if ($b>1) {if ($b>$fra){echo chr(124);}}
   	
   	if ($b==$page){echo "<b> ";}
   	  if ($b!=$page)  { ?>&nbsp;<a href="subpage.php?s=60&amp;p=<?php echo $b ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;"><?php }
   	  	 echo $b;
   	  	   if ($b!=$page) { ?></a>&nbsp;<?php  }	  
   	if ($b==$page){echo " </b>";} 
   		}
   	if($til<$pages) {echo "..";}	
  if ($page<$pages+1)   {
  	?>
  	&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php if ($page<$pages) {echo $page+1;} else {echo $pages;} ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="subpage.php?s=60&amp;p=<?php echo $pages; ?>&eg=<?php echo $eg; ?>" target="_parent" style="color: #000000;">>></a>
  	<?php
  						}
}
?>
</div><!-- bladring-divtag slut -->

<br /><br /><br />
</div>

<?php  
}
else // user not logged in
{
	?>
  <div style="text-align: center;">	 
  <br /><br />
  You are no allowed to access this page - Du er ikke autorisert til &aring f&aring tilgang til denne siden
  <br /><br />	
  </div>
<?php  
}
?>

