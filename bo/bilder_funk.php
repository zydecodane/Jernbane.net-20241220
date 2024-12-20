<?php 

//******************************
// Hent dagens og ukensbilde
//*****************************
function dagensOgUkensBilde()
{
	include('configi.php');

		
	// get user
	$isloggedin = 0;
	if ($userid !='') { $isloggedin = 1; }
  
	$isloggedin = 1;
	$loggedin = 1;

/*
	// get ukens
	date_default_timezone_set('CET');
	$uk_year = date('o');
	$uk_week = date('W');

	$squery = "select imgid from gal_ukens where uke = '$uk_week' and aar = '$uk_year'";
	@$uk_id = $db->query($squery)->fetch_object()->imgid;

	if(isset($uk_id)) {  // ukens bilde er valgt

		$squery = "select id, thumb, url, tekst, stemmer, poeng, fotograf, clean_url, navn from gal_images where id = '$uk_id'";
		$sresult = $db->query($squery);
		$sukens = $sresult->fetch_array();
	}
*/
	$path = '/bo/';
		
	
	$html = ' <link type="text/css" href="/bo/stylesheet.css?v=351" rel="stylesheet">
		<div class="news_summary">';
		
	//$html .= sisteInnlegg($path,$isloggedin,$loggedin);
	
	$html .= sisteOpplastinger($path,$isloggedin,$loggedin);
	
	$html .= dagensBilde($path,$isloggedin,$loggedin);
	
	$html .= ukensBilde($path,$isloggedin,$loggedin);

	$html .= '</div>';	
	
	return $html;

}

function bildewrapper($tekst) 
{
	return '	<div class="news_element">
	' . $tekst . '
	</div>';
}

function dagensBilde($path,$isloggedin,$loggedin) 
{
	include('configi.php');
	@include ('../bo/gal_dagens.php');
	
	if ($dagens[9]==1) // der er et dagens bilde, som skal vises
 	{ 
		$html  = '';
		//$html .= '<div style="width: 300px; display: inline-block;">';
 		$html .= '<div class="sideshow_heading">
 			<b>Dagens bilde</b>
 		</div>
 			<div class="sideshow_content">';

		 @$dstars= round($dagens[5]/$dagens[4]);

		$html .= '<div id="ukens_header">
			<img src="' . $path .'graphics/' . @$dstars . 'stars.gif" alt="" />
		</div>
		<div id="ukens_img">';
            // https
            if (substr($dagens[2],0,5) == 'http:') {
                $dagens[2] = 'https:'.substr($dagens[2],5);
            }
    		if ($isloggedin ==1) {
				$html .= '<a href="' . $path . 'posthylla_redir.php?img=<' . $dagens[8] . '&id=' . $dagens[0] .'">';
			}  else { 
				$html .= '<a href="../phorum/login.php" onclick="alert(\'Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.\')">';
			}
			$html .= '<img src="' .  $dagens[1] . '" alt="dgens bilde"  class="latest_uploads" width="250" /></a>
    		<br />
    	</div>' .
    	$dagens[3] . '<br />Fotograf: ' . $dagens[6] .	
    	'<br /><br />
		
    	<a href="' . $path . 'subpage.php?s=17" style="color: "0000ff !important;"><u>Tidligere Dagens Bilder</u></a>
    	<br /><br />
 				
 	</div>';	
		return bildewrapper($html);
 	} 
	return '';
}

function ukensBilde($path,$isloggedin,$loggedin) 
{
	include('configi.php');

	// get ukens
	date_default_timezone_set('CET');
	$uk_year = date('o');
	$uk_week = date('W');

	$squery = "select imgid from gal_ukens where uke = '$uk_week' and aar = '$uk_year'";
	@$uk_id = $db->query($squery)->fetch_object()->imgid;

	if(isset($uk_id)) {  // ukens bilde er valgt

		$squery = "select id, thumb, url, tekst, stemmer, poeng, fotograf, clean_url, navn from gal_images where id = '$uk_id'";
		$sresult = $db->query($squery);
		$sukens = $sresult->fetch_array();
	}


	$html = '<div class="sideshow_heading">
		<b>Ukens Bilde</b>
	</div>
	<div class="sideshow_content">';
	
	
	if(isset($uk_id)) { 
			@$ustars= round($sukens[5]/$sukens[4]);
		$html .= '     <div id="ukens_header">
			<img src="' . $path . 'graphics/' . @$ustars . 'stars.gif" alt="" />
		</div>
		<div id="ukens_img">';
		
    	if(isset($uk_id)) { 
            // https
            if (substr($sukens[1],0,5) == 'http:') {
                $sukens[1] = 'https:'.substr($sukens[1],5);
            }
			if ($isloggedin ==1) {
				$html .= '<a href="' . $path . 'posthylla_redir.php?img=' . $sukens[8] . '&id=' . $sukens[0] . '">';
			} else { 
				$html .= '<a href="../phorum/login.php" onclick="alert(\'Du er ikke innlogget. Du må være innlogget for å kunne se bilder i fuld størrelse.\')">';
			} 
			$html .= '<img src="' . $sukens[1] . '" alt="ukens bilde"  class="latest_uploads" width="250" /> </a>
    		<br />
    	</div>';
    	if(isset($uk_id)) { 
			$html .= $sukens[3] . '<br />Fotograf: "' . $sukens[6];  
		}	
    	$html .= '<br /><br />
    	<a href="' . $path . 'subpage.php?s=5" style="color: "0000ff !important;"><u>Tidligere Ukens Bilde</u></a>
    	<br /><br />';
 		} 
 	} else { 
		$html .= '<br />Denne ukes Picture of the Week <br />ikke valgt ennå<br /><br />'; 
	}
 	$html .= '</div>';
	
	return bildewrapper($html);
}

function sisteOpplastinger($path,$isloggedin,$loggedin)
{
	include('configi.php');

	$html  = '';

	$html .= '  	<div class="sideshow_heading">
 		<b>Seneste opplastninger</b>
 	</div>
 	<div class="sideshow_content">';
	$html .= '    <a href="https://jernbane.net/bo/subpage.php?s=100" style="margin: -5px auto 5px auto; display: block;"><u>Gå til Posthylla</u></a>';
		 // get latest uloads
		 $a=0;
		 $squery1 ="select id, url, thumb, clean_url, navn from gal_images where timestamp > 0 order by id desc limit 16";
		 $sresult1 = $db->query($squery1);
		 while ( $latest = $sresult1->fetch_array() ) {
    		$late_id[$a] = $latest[0];
    		$late_navn[$a] = $latest[4];
    		$late_thumb[$a] = $latest[2];
			$late_clean_url[$a] = $latest[3];
			
            // https
            if (substr($late_thumb[$a],0,5) == 'http:') {
                $late_thumb[$a] = 'https:'.substr($late_thumb[$a],5);
            }           
     		$a++;
     		} 
	     $a=0;
		 
	for ($l = 0 ; $l<8 ; $l++) {
		 
		 for ($n = 0 ; $n<2 ; $n++) { 
			$html .= '	<div class="sideshow_latest">';
			if ($isloggedin==1) { 
				$html .= '<a href="'.$path.'posthylla_redir.php?img='.$late_navn[$a].'&id='.$late_id[$a].'">'; 
			} else { 
				$html .= '<a href="../phorum/login.php" onclick="alert(\'Du er ikke innlogget. Du må være innlogget for å kunne se bilder i full størrelse.\')">'; 
			} 
			$html .= '<img src="'.$late_thumb[$a].'" width="120" alt="" class="latest_uploads" /></a>
			</div>';
			$a++;
		} 
	}	
	
 	$html .= '</div>';
	
	return bildewrapper($html);

}

function sisteInnlegg($path,$isloggedin,$loggedin) 
{
	include('configi.php');

	$html  = '';

	$html .= ' 	<div class="sideshow_heading">
 		Siste innlegg
 	</div>
 	<div class="sideshow_content">';
 	
 	$squery4 = "select forum_id, name from phorum_forums";
	 $sresult4 = $db->query($squery4);
	 while ( $sforum = $sresult4->fetch_array() ) {
   		$sfnavn[$sforum[0]] = strip_tags($sforum[1]);
  	} 

	$squery2 = "select data from phorum_settings where name = 'http_path'";
 	$http_path = $db->query($squery2)->fetch_object()->data;

	$squery3 = "select message_id, forum_id, thread, subject from phorum_messages where forum_id <> 2 and forum_id <> 12 and forum_id <> 3 and forum_id <> 16 order by message_id desc limit 7";
	$sresult3 = $db->query($squery3);		

	$html .= '	<div class="sideshow_siste">
			<ul style="list-style-image: url(' . $path . 'graphics/bullet.gif); padding-left: 28px; margin-top:0px; ">';
	while ( $lpost = $sresult3->fetch_array() ) {
		$html .= '			<li class="sideshow_item">'. 
				'<a href="'.$http_path.'/read.php?'.$lpost[1].','.$lpost[2].','.$lpost[0].'#msg-'.$lpost[0].'" class="sideshow_siste_pv">'.$lpost[3].'</a><br />
				<div style="font-size: 9px; color: #A4A4A4;">'.$sfnavn[$lpost[1]].'</div>				
				</li><br />';
	}
	$html .= '		</ul>
 		</div>
 	</div>';
	
	return bildewrapper($html);
}


/*=========================================================================*\
|| #######################################################################
|| # Downloaded: [#]zipbuilddate[#]
|| # CVS: $RCSfile$ - $Revision: 101016 $
|| #######################################################################
\*=========================================================================*/
