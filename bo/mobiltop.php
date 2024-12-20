<div style="background-color: #800000; width: 200px; position:absolute; z-index: 10000;">
<a href="http://jernbane.net"><img src="../bo/graphics/toplogo.gif" style="padding-top: 6px; padding-left: 13px;" /></a>
</div>
<style>
	.mlink {
		text-decoration: none;
		color: #ffffff;
	}
</style>

<!-- ------------------------------ -->	



		<script>
		$(document).ready(function(){
			$(".nav-button").click(function () {
			$(".nav-button,.primary-nav").toggleClass("open");
			});    
		});
		</script>
		
<style>


.nav-button { display: none; } /* hide the navigation button by default */

@media only screen and (min-width: 0px) and (max-width: 960px) {

	/* Navigation Button
	-------------------------------------------------------- */

	.pagecontainer {
		margin-top: 50px;
		}
	.nav-button {
		display: block;
		position: absolute;
		top: 7px;
		right: 10px;
		width: 50px;
		height: 35px;
		background: url('../bo/mobmenu_images/menu-icon-large.png'), -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/menu-icon-large.png'),    -moz-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/menu-icon-large.png'),     -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/menu-icon-large.png'),      -o-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-position: center center;
		background-repeat: no-repeat;
		background-size: 21px, 100%;
		cursor: pointer;
		border: 0 none;
		border-bottom: 1px solid rgba(255,255,255,.1);
		box-shadow: 0 0 4px rgba(0,0,0,.7) inset;
		border-radius: 5px;
		z-index: 999;
		text-indent: -9999px;

	}
	.nav-button:hover { 
		background-color: rgba(0,0,0,.1); 
	}
	.nav-button.open {
		background: url('../bo/mobmenu_images/close-icon-large.png'), -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/close-icon-large.png'),    -moz-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/close-icon-large.png'),     -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('../bo/mobmenu_images/close-icon-large.png'),      -o-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-position: center center;
		background-repeat: no-repeat;
		background-size: 21px, 100%;
	}

	/* Navigation Bar
	-------------------------------------------------------- */

	.primary-nav {
		width: 100%;
		float: none;
		background-color: #800000; /* change the menu color */
		background-image: -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-image:    -moz-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-image:     -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-image:      -o-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		display: block;
		height: 50px;
		margin: 0;
		padding: 0;
		overflow: hidden;
		box-shadow: 0 1px 2px rgba(0,0,0,.6);
		position: absolute;
		top: 0px;
		left: 0px;
		z-index: 998;
		clear: both;
	}
	.primary-nav li {
		display: none;
		width: 100%;
		font-family: Arial;
	}
	.primary-nav li a {
		display: block;
		width: 90%;
		padding: 10px 5%;
		font-size: 14px;
		font-weight: bold;
		text-shadow: -1px -1px 0 rgba(0,0,0,.15);
		color: white;
		text-decoration: none;
		border-bottom: 1px solid rgba(0,0,0,.2);
		border-top: 1px solid rgba(255,255,255,.1); 
	}
	.primary-nav li a:hover {
		background-color: rgba(0,0,0,.5);
		border-top-color: transparent;
	}
	.primary-nav > li:first-child {
		border-top: 1px solid rgba(0,0,0,.2);
	}

	/* Toggle the navigation bar open  */

	.primary-nav.open { 
		height: auto; 
		padding-top: 50px;
	}
	.primary-nav.open li { 
		display: block; 
	}

	/* Submenus – optional .parent class indicates dropdowns */

	.primary-nav > li:hover > a {
		background: rgba(0,0,0,.5);
		border-bottom-color: transparent;
	}
	.primary-nav li.parent > a:after {
		content: "▼";
		color: rgba(255,255,255,.5);
		float: right;
	}
	.primary-nav li.parent > a:hover {
		background: rgba(0,0,0,.75);
	}
	.primary-nav li ul {
		display: none;
		background: rgba(0,0,0,.5);
		border-top: 0 none;
		padding: 0;
		padding-left: 10px;
	}
	.primary-nav li ul a {
		border: 0 none;
		font-size: 12px;
		padding: 10px 5%;
		font-weight: normal;
	}
	.primary-nav li:hover ul {
		display: block;
		border-top: 0 none;
	}
	#mobiltopfiller {
		width: 100%; 
		height: 50px;
		}


} /* End Mobile Styles */

</style>		
<div class="mobil">		
		
		<button class="nav-button">Menu</button>
	</div>	
	
		
	<ul class="primary-nav">
		<li class="parent"><a href="<?php echo $phorumlink; ?>index.php">Postvogna</a>
				<ul>
				  <li><a href="<?php echo $phorumlink; ?>list.php?8">Postvogna</a></li>
				  <li><a href="<?php echo $phorumlink; ?>list.php?7">InteRailvogna</a></li>
				  <li><a href="<?php echo $phorumlink; ?>list.php?13">Driftshåndboka</a></li>
				  

                  <?php if($isadmin == 1) { ?>  
					<li><a href="<?php echo $phorumlink; ?>list.php?2">Inspeksjonsvogna</a></li>
					<li><a href="<?php echo $phorumlink; ?>list.php?12">Supplerende informasjon til galleriene</a></li>    
                  <?php } ?>    
                </ul>
        </li>
        <?php if ($isadmin == 1) { ?>		
		<li class="parent"><a href="#"><b>Administrasjon</b></a>
			<ul>
				<li><a href="<?php echo $path; ?>admin/index.php?s=1">Posthylla</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=2">Ukens bilde</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=3">Tabeller</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=4">Slet et bilde</a></li>
				<li><a href="/phorum/admin.php">Phorum admin</a></li>
				<li><a href="<?php echo $path; ?>admin/index.php?s=8">Registreringslog</a></li>
			</ul>
		</li>
					<?php  }  ?> 
		
		<li class="parent"><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=1">Norge</a>
				<ul>
				<?php  
					$query ="select katid, katname, natid from gal_kategori where natid = 1 order by plass";
					$result = $db->query($query);
					while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                	<li><a href="<?php echo $path; ?>subpage.php?s=20">Typetegninger</a></li>
                </ul>
            </li>
			<li class="parent"><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=3">Danmark</a>
			     <ul>
				<?php  
					$query ="select katid, katname, natid from gal_kategori where natid = 3 order by plass";
					$result = $db->query($query);
					while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                 </ul>
			</li>
			<li class="parent"><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=2">Sverige</a>
			     <ul>
			     <?php
                 $query = "select katid, katname, natid from gal_kategori where natid = 2 order by plass";
                 $result = $db->query($query);
				 while ( $cat = $result->fetch_array() ) { ?>
					<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                    <?php } ?>
			     </ul>
			</li>
			<li class="parent"><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=4">Finland</a>
			     <ul>
				<?php  
				$query = "select katid, katname, natid from gal_kategori where natid = 4 order by plass";
				$result = $db->query($query);
				while ( $cat = $result->fetch_array() ) { ?>
                	<li><a href="<?php echo $path; ?>subpage.php?s=2&amp;k=<?php echo $cat[0]; ?>"><?php echo $cat[1]; ?></a></li>
                <?php } ?>
                </ul>
			</li>
			<li class="parent"><a href="<?php echo $path; ?>subpage.php?s=21">Europa</a>
				<ul>
				  <?php  
				  $query = "select natid, natnavn from gal_nations where gruppe = 'eu' order by natnavn";
				  $result = $db->query($query);
				  while ( $nat = $result->fetch_array() ) { ?>
                  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=<?php echo $nat[0]; ?>"><?php echo $nat[1]; ?></a></li>
                  <?php } ?>            
		 		 </ul>
		 	</li>
			<li class="parent"><a href="#">Andre land</a>
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
			</li> <li class="parent"><a href="#">Transport / Train Technology</a>			
			   <ul>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&l=490">Train Technology</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&l=42">Vogntog</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=59">Det Maritime Hj&oslash;rnet</a></li>
				  <li><a href="<?php echo $path; ?>subpage.php?s=1&amp;l=433">Luftfart</a></li>
				                    
			  </ul>
			</li>
		</ul>
		
		
<?php		
/*		
		
		<ul class="primary-nav">
			<li><a href="#">Home</a></li>
			<li class="parent"><a href="#">About Us</a>
				<ul>
					<li><a href="#">Our History</a></li>
					<li><a href="#">Latest News</a></li>
					<li><a href="#">Community Involvement</a></li>
					<li><a href="#">Job Opportunities</a></li>
				</ul>
			</li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Contact</a></li>
		</ul>
*/
?>


</div>




<!-- ------------------------------ -->	

