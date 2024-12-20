<script type="text/javascript" src="../bo/datepicker/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../bo/datepicker/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="../bo/datepicker/jquery.ui.datepicker-no.js"></script>
<style>
.scrollable-menu {
    height: auto;
    max-height: 500px;
    overflow-y: auto;
	overflow-x: none;
}   
</style>
<?php 
$path='';
if ($f !='phorum' ) { include ('configi.php'); }
if ($f=='phorum') {
	include ('../bo/configi.php');
    $path = '../bo/';	
	}
	
if ($f=='admin') {
	include ('../configi.php');
    $path = '../';	
	}	
	
 if ($f=='phorum') {$phorumlink = '../phorum/'; }
 if ($f=='admin') {$phorumlink = '../../phorum/'; }
 else {$phorumlink = '../phorum/';  }

$dice=rand(1,20);  //used for random images top left in topbar

// get user
$userid=0;
$isadmin=0;

// check if user is logged in - find user in cookie
if (isset($_COOKIE["bbuserid"]))
{ $loggedin = 1;} else {$loggedin = 0;}
// get users real name and admin/notadmin from database

if ($loggedin == 1) {
$userid = $_COOKIE["bbuserid"];
include ('configi.php');

$dbase2 =  'jernbane_net_db_forum';		
$db2 = new mysqli($dbserver, $dbuserid, $dbpw, $dbase2);
$db2->set_charset("utf8");
$username = $db2->query("select displayname from user where userid = '$userid'")->fetch_object()->displayname;

} else {
	$username = 'not logged in';
	$loggedin = 0;
}
// users real name = $username
// TEST

?>
<div id="topcontainer">
<?php
/*
<img src="<?php echo $path; ?>graphics/filler.gif" width="200" height="1" alt="" />
<a href="<?php echo $path; ?>subpage.php?s=13"><img src="<?php echo $path; ?>graphics/stoett.jpg" border="0" alt="" width="150" /></a>
*/
?>
<a href="https://jernbane.net/forum/index.php" target="_parent"><img src="<?php echo $path; ?>graphics/toplogo.jpg" border="0" align="left" alt="Jernbane.net" title="Jernbane.net" style="margin-left: 10px;" /></a>
</div>
<div id="menucontainer">		
<ul id="kmenu">
<?php
/*	
			<li><a href="#">Mitt Jernbane.Net</a>
				<ul>
					<li><a href="<?php echo $path; ?>../phorum/index.php"><b>Forsiden</b></a></li>
					<li><a href="<?php echo $path; ?>subpage.php?s=51"><b>Bildeopplasting</b></a></li>
					<?php if ($userid > 0) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=60"><b>Mine bilder</b></a></li>
					<?php } ?>
                    <li><a href="<?php echo $path; ?>subpage.php?s=14"><b>Bildes&oslash;k</b></a></li>
					<li><a href="<?php echo $path; ?><?php echo $phorumlink; ?>register.php">Registrering</a></li>
					<li><a href="<?php echo $path; ?>" style="height: 3px; background-color: #800000;"></a></li>
					<li><a href="<?php echo $path; ?><?php echo $phorumlink; ?>login.php?0,logout=1">Logg p&aring; / logg av</a></li>
                                        <li><a href="" style="height: 3px; background-color: #800000;"></a></li>
					<li><a href="<?php echo $path; ?>subpage.php?s=11"><b>Om oss / kontakt</b></a></li>
					<li><a href="<?php echo $path; ?>subpage.php?s=13"><b>St&oslash;tt oss</b></a></li>
					<?php if ($isadmin == 1) { ?>
					<li><a href="<?php echo $path; ?>" style="height: 3px; background-color: #800000;"></a></li>
					<li><a href="#"><b>Administrasjon</b></a>
					 <ul>
					    <li><a href="<?php echo $path; ?>admin/index.php?s=1">Posthylla</a></li>
					    <li><a href="<?php echo $path; ?>admin/index.php?s=11">Auto-posthylla log</a></li>
					    <li><a href="<?php echo $path; ?>admin/index.php?s=2">Ukens bilde</a></li>
				     	<li><a href="<?php echo $path; ?>admin/index.php?s=3">Tabeller</a></li>
				     	<li><a href="<?php echo $path; ?>admin/index.php?s=4">Slett et bilde</a></li>
				     	<li><a href="<?php echo $path; ?>admin/index.php?s=10">Legg til sponsor</a></li>
						<li><a href="<?php echo $path; ?>admin/index.php?s=13">Upload-folder og regler</a></li>
				     	<li><a href="/phorum/admin.php">Phorum admin</a></li>
				     	<li><a href="<?php echo $path; ?>admin/index.php?s=8">Registreringslog</a></li>
						<li><a href="<?php echo $path; ?>admin/index.php?s=14">GDPR-log</a></li>
					  </ul>
					</li>
					<?php  }  ?>
				</ul>			
			</li>
*/
?>
			<li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=1">Norge</a>
				<ul class="scrollable-menu">
				<?php  
					$query ="select katid, katname, natid from gal_kategori where natid = 1 order by plass";
					$result = $db->query($query);
					while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                	<li><a href="<?php echo $path; ?>subpage.php?s=20">Typetegninger</a></li>
                </ul>
            </li>
			<li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=3">Danmark</a>
			     <ul class="scrollable-menu">
				<?php  
					$query ="select katid, katname, natid from gal_kategori where natid = 3 order by plass";
					$result = $db->query($query);
					while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                 </ul>
			</li>
			<li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=2">Sverige</a>
			     <ul class="scrollable-menu">
			     <?php
                 $query = "select katid, katname, natid from gal_kategori where natid = 2 order by plass";
                 $result = $db->query($query);
				 while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                    <?php } ?>
			     </ul>
			</li>
			<li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=4">Finland</a>
			     <ul class="scrollable-menu">
				<?php  
				$query = "select katid, katname, natid from gal_kategori where natid = 4 order by plass";
				$result = $db->query($query);
				while ( $cat = $result->fetch_array() ) { ?>
                	<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                </ul>
			</li>
			<li><a href="<?php echo $path; ?>subpage.php?s=21">Europa</a>
				<ul class="scrollable-menu">
				  <?php  
				  $query = "select natid, natnavn from gal_nations where gruppe = 'eu' order by natnavn";
				  $result = $db->query($query);
				  while ( $nat = $result->fetch_array() ) { ?>
                  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
                  <?php } ?>            
		 		 </ul>
		 	</li>
			<li><a href="#">Overseas</a>
				<ul>
				   	<li><a href="#">Asia</a>
					<ul>
					  <?php  
					  $query = "select natid, natnavn from gal_nations where gruppe = 'as' order by plass";
					  $result = $db->query($query);
					  while ( $nat = $result->fetch_array() ) { ?>
	                  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
	                  <?php } ?>            
			 		 </ul>
					</li>
					<li><a href="#">Afrika</a>
					 <ul>
					  <?php  
					  $query = "select natid, natnavn from gal_nations where gruppe = 'af' order by plass";
					  $result = $db->query($query);
					  while ( $nat = $result->fetch_array() ) { ?>
					  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
	                  <?php } ?>            
			 		 </ul>
					</li>
					<li><a href="#">Amerika</a>
					 <ul>
					  <?php  
					  $query = "select natid, natnavn from gal_nations where gruppe = 'na' order by plass";
					  $result = $db->query($query);
					  while ( $nat = $result->fetch_array() ) { ?>
	                   <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
	                  <?php } ?>            
			 		 </ul>
					</li>
					<li><a href="#">Oseania</a>
					 <ul>
					 <?php  
					  $query = "select natid, natnavn from gal_nations where gruppe = 'oc' order by plass";
					  $result = $db->query($query);
					  while ( $nat = $result->fetch_array() ) { ?>
	                   <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
	                  <?php } ?>            
			 		 </ul>
					</li>
				</ul>	
			</li>
			<li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=42">Spesialsider</a>
			   <ul>

 <?php
    // Latebiler sub menu
?>                <li><a href="<?php echo $path; ?>subpage.php?s=1&l=42">Lastebiler - vogntog</a>
                   <ul>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1625">Road Train Australia</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1627">BAG [Bundesamt für Güterverkehr]</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1626">Bedford</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1628">DAF Trucks</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1629">Dodge</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1630">FAUN</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1631">Ford</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1633">Kenworth</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1632">Peterbilt</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1634">M.A.N</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1635">Mercedes Benz</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1636">Ronny På Tur</a></li>   
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1622">Scania Vabis L / LB / LBS / LBT</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1620">Scania [Serie 1 - 2 - 3 - 4 G-P-R-T]</a></li> 
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1624">Sisu</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1623">Tatra</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=1616">Volvo</a></li>
                 </ul>
			       </li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=1617">Dumpere - hjullastere - gravemaskiner</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=59">Det Maritime Hj&oslash;rnet</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=433">Luftfart</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=12">Busser</a></li>
                     <ul>
<?php
                     $query = "select katid, katname, natid from gal_kategori where natid = 468 order by plass";
                     $result = $db->query($query);
                     while ( $cat = $result->fetch_array() ) { ?>
                        <li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                        <?php } ?>
                     </ul>
			      </li>
				  
                                    <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=469">Lokomotivmonumenter</a>
                     <ul>
                     <?php
                     $query = "select katid, katname, natid from gal_kategori where natid = 469 order by plass";
                     $result = $db->query($query);
                     while ( $cat = $result->fetch_array() ) { ?>
                        <li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                        <?php } ?>
                     </ul>
			      </li>				  
	  
			  </ul>
			</li>
 <?php
              
 // Postvogna Arkiv menu

?>                  <li><a href="https://www.jernbane.net/phorum/index.php">Arkivene</a>
				<ul>
                  <li><a href="<?php echo $phorumlink; ?>list.php?8">Postvogna</a></li>
				  <li><a href="<?php echo $phorumlink; ?>list.php?7">InterRailvogna</a></li>
				  <li><a href="<?php echo $phorumlink; ?>list.php?13">Driftshåndboka</a></li>
                  <li><a href="<?php echo $phorumlink; ?>list.php?12">Revisjoner, ombygginger</a></li>
                  <li><a href="<?php echo $phorumlink; ?>list.php?14">Jernbanenytt</a></li>
                  </ul>
			       </li>

<?php
    // Medlemside menu
?>
			  		
			<li>
			<li><a href="<?php echo $path; ?>subpage.php?s=61">Medlemsidene</a>
				<ul>
                  <li><a href="<?php echo $path; ?>subpage.php?s=61">Bildeopplasting</a></li>
					<?php if ($userid > 0) { ?>
                    <li><a href="<?php echo $path; ?>subpage.php?s=14">Search Photos</a></li>
					<li><a href="<?php echo $path; ?>subpage.php?s=60">Mine bilder.</a></li>
                    <li><a href="<?php echo $path; ?>subpage.php?s=100">Posthylla.</a></li>					
				    <li><a href="<?php echo $path; ?>subpage.php?s=40">Fotografene.</a></li>
                    <li><a href="<?php echo $path; ?>subpage.php?s=12">Om opphavsrett.</a></li>
                    <li><a href="<?php echo $path; ?>subpage.php?s=16">Brukerrettigheter og regler for Jernbane.Net</a></li>
                    <?php } ?>
				</ul>  
			</li>
			<li>
            <li><a href="<?php echo $path; ?>subpage.php?s=14">Search Photos</a></li>
 <?php

    // Teknikk menu
  ?> 
<li><a href="<?php echo $path; ?>subpage.php?s=1&l=490">Train Tech</a>
				<ul>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1644">Boggier - Lokomotiver</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1640">Boggier - Multiple Units</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1645">Boggier - Personvogner</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1643">Boggier - Godsvogner</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1686">Godsvogner - Tekniske egenskaper - Litra</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1657">ERTMS / GSM for Rail</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1642">European Vehicle Number</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1641">Kobbel (Automat og UIC Skruekobbel)</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1652">Kobbel EMU / DMU / Light Rail / Metro</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1646">Sporviddevekselsystem</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1639">Strømavtagere</a></li>
                  <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1405">NSB Typetegninger</a></li>

   </ul>
 </li>
 <?php
              
    // Jernbane.Net FAQ meny

  ?>               <li><a href="<?php echo $path; ?>subpage.php?s=2&k=1638">FAQ</a>
                   <ul>
                   <a href="<?php echo $path; ?>subpage.php?s=2&k=1638">Jernbane.Net [FAQ]</a>
                   <a href="<?php echo $path; ?>subpage.php?s=2&k=1637">Bildebehandling</a>
     
   </ul>
 </li>


<?php
?>
            <li><a href="<?php echo $path; ?>subpage.php?s=13">SUPPORT US</a></li>
<?php
// check om bruger er administrator
if ($loggedin == 1) {
	$dbase2 =  'jernbane_net_db_forum';		
	$db2 = new mysqli($dbserver, $dbuserid, $dbpw, $dbase2);
	$db2->set_charset("utf8");
	$username = $db2->query("select displayname from user where userid = '$userid'")->fetch_object()->displayname;
	$usergroupid = $db2->query("select usergroupid from user where userid = '$userid'")->fetch_object()->usergroupid;
	if ($usergroupid == 6) { $isadmin = 1; }
}	
if ($isadmin == 1) {
?>	
			<li><a href="#">ADMIN</a>
			 <ul>
			    <li><a href="<?php echo $path; ?>admin/index.php?s=1">Posthylla</a></li>
			    <li><a href="<?php echo $path; ?>admin/index.php?s=11">Auto-posthylla log</a></li>
			    <li><a href="<?php echo $path; ?>admin/index.php?s=2">Ukens bilde</a></li>
		     	<li><a href="<?php echo $path; ?>admin/index.php?s=3">Tabeller</a></li>
		     	<li><a href="<?php echo $path; ?>admin/index.php?s=4">Slett et bilde</a></li>
		     	<li><a href="<?php echo $path; ?>admin/index.php?s=10">Legg til sponsor</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=13">Upload-folder</a></li>
				<li><a href="<?php echo $path; ?>../phorum/login.php">Phorum-login</a></li>
				<li><a href="<?php echo $path; ?>../phorum/admin.php">Phorum-admin</a></li>
                <li><a href="<?php echo $path; ?>admin/index.php?s=8">Registreringslog</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=14">GDPR-log</a></li>
			  </ul>
			</li>       
<?php } ?>			
</div>		
	<br />
<?php
@include ('../bo/gal_dagens.php');
?>	

