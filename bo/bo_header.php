<?php
include('config.php');

/*
$confil=$path.'config.php';
include($confil);
*/
/*
 $getlastid = mysql_query("SELECT max(id) FROM gal_images");
	$lastid = mysql_result($getlastid,0);
	$startid = $lastid-20;
*/

// get user
$loggedin=0;

@$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);
if ($userid > 0) {$loggedin=1;}

// get user slut


$a=1;	
$getthumbs = mysql_query("SELECT id, tekst, thumb, poeng, stemmer, navn FROM gal_images WHERE timestamp > '0' ORDER BY id DESC LIMIT 0,4");
  while ($thumbs = mysql_fetch_row($getthumbs))
  { $id[$a] = $thumbs[0];
    $tekst[$a] = $thumbs[1];
    $thumb[$a] = $thumbs[2];
    $navn[$a] = $thumbs[5];
    if ($thumbs[3]>0) {
    $stars[$a] = round($thumbs[3]/$thumbs[4]);
    } else { $stars[$a] = 0; }
    $a=$a+1;
  }
if(isset($_GET['photographer'])) {$fotograf = $_GET['photographer'];}
else {$fotograf = ''; }	
?>
<br />
<div id="header_container">
 <div id="header_fiveimg">

<?php
 // get picture of the week

$aar = date('o');
$uke = date('W');


$getukens = mysql_query("SELECT imgid FROM gal_ukens WHERE uke = '$uke' AND aar = '$aar' ");
@$ukens = mysql_result($getukens,0);



$year='2013';

$getuimg = mysql_query("SELECT id, navn, thumb, tekst, stemmer, poeng FROM gal_images WHERE id = '$ukens'");
$uimg = mysql_fetch_row($getuimg);

@$ustars= round($uimg[5]/$uimg[4]);

?>


<table cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td width="14"></td>
  <td width="250" valign="top">
   <div class="header_box">
    <b>Picture of the Week</b><br />
    
    
  
    <?php
    if ($uimg[0]!='') {
    ?>
    <img src="<?php echo $path; ?>graphics/<?php echo $ustars; ?>stars.gif" alt="" />
<?php if ($loggedin==1) { ?>    
     <a href="http://jernbane.net/bo/posthylla_redir.php?img=<?php echo $uimg[1]; ?>&id=<?php echo $uimg[0]; ?>" target="_parent"><img src="<?php echo $uimg[2]; ?>" width="200" border="0" alt="" /></a>
<?php } else { ?>
   <img src="<?php echo $uimg[2]; ?>" width="200" border="0" alt="" />
<?php } ?> 
     <br />
    <?php
      if ($f == 'phorum') { echo utf8_encode($uimg[3]);  }
       else
       { echo $uimg[3]; } 
if ($loggedin==0) { echo "<br />"; }       
 ?>      
    <br />
    
  
<?php if ($loggedin==1) { ?>    
    <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $uimg[1]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $path; ?>graphics/finn.jpg" border="0" alt="" /></a>
<?php } ?>
    
    
    
      <div ><a href="<?php echo $path; ?>subpage.php?s=5" style="color: #FFFFFF; text-decoration: none;">Se tidligere "Ukens bilde"</a></div>
     <?php
    } else {
    	echo "<br /><br /><br />Ukens bilde ikke valgt<br /><br />
    	Pictute of the Week not chosen<br /><br /><br /><br /><br /><br /><br />";
       	}
     ?>
</div>
  </td>
  <?php
 for ($n = 1 ; $n<5 ; $n++)
{
?> 
<?php
//<div class="header_filler1"><br /></div>
?>
  <td width="250" valign="top">
  <div class="header_box"> 
    <b>Today's upload</b><br />
    <img src="<?php echo $path; ?>graphics/<?php echo $stars[$n];?>stars.gif" alt="" />
<?php if ($loggedin==1) { ?>    
    <a href="http://jernbane.net/bo/posthylla_redir.php?img=<?php echo $navn[$n]; ?>&id=<?php echo $id[$n]; ?>" target="_parent"><img src="<?php echo $thumb[$n] ?>" width="200" border="0" alt="" /></a>
<?php } else { ?>
     <img src="<?php echo $thumb[$n] ?>" width="200" border="0" alt="" />
<?php  } ?>    
    
      <div class="header_textcontainer">
      <?php
       if ($f == 'phorum') { echo utf8_encode($tekst[$n]); }
       else
       { echo  ($tekst[$n]); }   
       ?>
      </div>
<?php if ($loggedin==1) { ?>      
    <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $navn[$n]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $path; ?>graphics/finn.jpg" border="0" alt="" /></a>
<?php } else { echo "<br />"; } ?>    
  </div>
  </td>
<?php } ?>
 </tr>
</table>  
<?php
/*

<br / ><br />
<div class="header_box">
    <b>Picture of the Week</b><br />
    <?php
    if ($uimg[0]!='') {
    ?>
    <img src="<?php echo $path; ?>graphics/<?php echo $ustars; ?>stars.gif" alt="" />
     <a href="<?php echo $path; ?>subpage.php?s=0&amp;id=<?php echo $uimg[0]; ?>" target="_parent"><img src="<?php echo $uimg[2]; ?>" width="200" border="0" alt="" /></a>
     <br />
    <?php
      if ($f == 'phorum') { echo htmlentities($uimg[3]);  }
       else
       { echo $uimg[3]; } ?>
    <br />
    <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $uimg[1]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $path; ?>graphics/finn.jpg" border="0" alt="" /></a>
      <div ><a href="<?php echo $path; ?>subpage.php?s=5" style="color: #FFFFFF; text-decoration: none;">Se tidligere "Ukens bilde"</a></div>
     <?php
    } else {
    	echo "<br /><br /><br />Ukens bilde ikke valgt<br /><br />
    	Pictute of the Week not chosen<br /><br /><br /><br /><br /><br /><br />";
       	}
     ?>
</div>

<?php
 for ($n = 1 ; $n<5 ; $n++)
{
?> 
<?php
//<div class="header_filler1"><br /></div>
?>
<img src="<?php echo $path; ?>graphics/filler.gif" width="10" alt="0" style="border: 0px;" />
<div class="header_box">
    <b>Today's upload</b><br />
    <img src="<?php echo $path; ?>graphics/<?php echo $stars[$n];?>stars.gif" alt="" />
    <a href="<?php echo $path; ?>subpage.php?s=0&amp;id=<?php echo $id[$n]; ?>" target="_parent"><img src="<?php echo $thumb[$n] ?>" width="200" border="0" alt="" /></a>
      <div class="header_textcontainer">
      <?php
       if ($f == 'phorum') { echo htmlentities($tekst[$n]); }
       else
       { echo  ($tekst[$n]); }
       ?>
      </div>
    <a href="http://www.jernbane.net/phorum/search.php?7,search=<?php echo $navn[$n]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="<?php echo $path; ?>graphics/finn.jpg" border="0" alt="" /></a>



</div>
<?php } ?>
<br />

*/

?>
 <div class="header_text">
Vi ser kontinuerlig etter nye, spennende bilder til v&aring;rt galleri. Hjelp oss utvide bildesamlingen av lokomotiver, vogner og alt det andre som har
 med jernbanen &aring; gj&oslash;re.<br />
Du er velkommen til &aring; bidra med b&aring;de gamle og nye bilder. <a href='/bo/subpage.php?s=61'><font color=ffffff>F&oslash;lg denne linken</font></a>, velg land, materielltype/banestrekning og nummer/sted
 og last opp.<br />
 </div>
<hr>
 <div class="header_text">
 We are always looking for new photo to add to our gallery. Help us collect images of locomotives, carriages, signals and everything else that belongs to the railroad.<br />
You're more than welcome to contribute with old and new photos. <a href='/bo/subpage.php?s=61'><font color=ffffff>Follow this link</font></a>, select country, type of locomotive/DMU/EMU/station before uploading images.
 </div>
</div>

</div>