<?php

include('searchutil.php');

function get_params_as_string($page) {
    global $kat;
    global $kateksakt;
    global $tu;
    global $tueksakt;
    global $search;

    $params = "";
    if(strlen($kat)>0) {
        $params .= "&kat=".urlencode($kat);
        if($kateksakt==1) {
            $params .= "&kateksakt=1";
        }
    }
    if(strlen($tu)>0) {
        $params .= "&tu=".urlencode($tu);
        if($tueksakt==1) {
            $params .= "&tueksakt=1";
        }
    }
    if(strlen($search)>0) {
        $params .= "&search=".urlencode($search);
    }
    if($page>1) {
        $params .= "&p=".$page;
    }
    
    return $params;
}

function get_this_search($page) {
    return "subpage.php?s=15".get_params_as_string($page);
}

function get_back_to_search_url() {
    return "subpage.php?s=14".get_params_as_string(0);
}


// *** Parameter decoding
$kat = getarg('kat');
$kateksakt = intval(getarg('kateksakt'));  // ==1 hvis kategori er eksakt lik teksten i db
$tu = getarg('tu');
$tueksakt = intval(getarg('tueksakt')); // ==1 hvis type/unit er eksakt lik teksten i db
$search = getarg('search');
$page = intval(getarg('p')); // 0 hvis ikke satt
if($page==0)    $page=1; // start counting from 1!


$IMAGES_PER_LINE = 3;
$LINES_PER_PAGE = 10;
$IMG_PER_PAGE = $IMAGES_PER_LINE*$LINES_PER_PAGE;


// chek if user is logged in - find user in cookie
if (isset($_COOKIE["phorum_session_v5"]))
{ $loggedin = 1;
$cookie = $_COOKIE["phorum_session_v5"];
$colon = strpos($cookie, ':');
$userid = substr ($cookie,0,$colon);

// get users real name from database - til hvad?
 
/* 
$getuser=mysql_query("SELECT real_name, admin FROM `phorum_users` WHERE user_id='$userid'");
$user = mysql_fetch_row($getuser);
$username = $user[0];
$isadmin = $user[1];
*/

} else {$loggedin = 0;}


// *** DO SEARCH

function array_to_wherepar($arr,$parname) {
    if(!isset($arr) || sizeof($arr)==0)
        return "";
    
    if(sizeof($arr)>1) {
        $inlist = '(';
        $first = True;
        foreach($arr as $v) {
            if(!$first)
                $inlist .= ",";
            $inlist .= "'$v'";
            $first = False;
        }
        $inlist .= ')';
        $par = $parname." IN ".$inlist;
    } else {
        $par = $parname."='$arr[0]'";
    }
    return $par;
}

function id_result_to_array($result,&$arr) {
    if(!isset($result) || !$result) {
        $arr = array();
        return;
    }
    $n=0;
    while( $res = $result->fetch_array() ) {
        $arr[$n] = $res[0];
        $n++;
/*        if(sizeof($res)>1) {
            echo "res ".$res[0]." date ".$res[1]." ".$res[2]."<br/>";
        }*/
    }
	if($n==0) {
		$arr = array();
	}
}

function list_unit_ids($a) {
    if(sizeof($a)==0) {
        return;
    }
    $w = array_to_wherepar($a,"numID");
    $query = "select numID, enhet, typeID from gal_unit where $w";
    global $db;
    $result = $db->query($query);
    while( $res = $result->fetch_array() ) {
        echo $res[0]." - ".$res[1]."<br/>".PHP_EOL;
    }
}

function ADD_AND($v) {
    if(strlen($v)>0)
        return "AND (".$v.")";
    return "";
}

function pa($vn,$a) {
    echo "$vn=[";
    foreach($a as $v) {
        echo " $v";
    }
    echo " ]<br/>".PHP_EOL;
}


$NoHits = False;  // no hits matching search criterium

// kategori
$katpar = "";
$katid = NULL;
$reqtypepar = "";   // required types by specified katids
$reqtypeid = NULL;
if(strlen($kat)>0) {

    if($kateksakt==1) {
        $a = explode( " - ", $kat);
        if( sizeof($a)>=2) {
            $a1 = array_slice( $a, 0, sizeof($a)-1);
            $kn = join(" - ", $a1);
            $nn = $a[sizeof($a)-1];
            //echo "kn = ".$kn."     nn=".$nn;
            
            $query = "select katid from gal_kategori WHERE katname='".$db->real_escape_string($kn)."' AND natnavn='".$db->real_escape_string($nn)."'";
            $result = $db->query($query);
            $katid[0] = $result->fetch_object()->katid;
        }        
        
    } else {
        //$kv = explode(" ", $kat );
        $kv = split_parameter_string($kat);
        $wherepar = "";
        foreach($kv as $v) {
            if(strlen($wherepar)>0)
                $wherepar.= " AND ";
            $wherepar.= "((katname LIKE '%$v%') OR (natnavn LIKE '%$v%'))";
        }
        
        if(strlen($wherepar) > 0 ) {
            $query = "select katid from gal_kategori WHERE $wherepar";
            $result = $db->query($query);
            id_result_to_array($result,$katid);
            if($result) $result->free();
        }

    }
        
    if(isset($katid) && sizeof($katid)>0) {
        $katpar = array_to_wherepar($katid,"katID");
                
        // translate katid to required typeids (for use in unit search)
        $query = "select typeID from gal_type WHERE $katpar";
        $result = $db->query($query);
        id_result_to_array($result,$reqtypeid);
        if($result) $result->free();
        
        $reqtypepar = array_to_wherepar($reqtypeid,"typeID");
    } 
    
    if(strlen($katpar)==0) {
        $NoHits = True;    
    }
} 

//echo "katpar='".$katpar."'<br/>".PHP_EOL;
//echo "reqtypepar='".$reqtypepar."'<br/>".PHP_EOL;


// enhet/type
$unitpar = "";
$unitid = NULL;
$typepar = "";
$typeid = NULL;

if(!$NoHits) {
    if(strlen($tu)>0) {
        $skiptype =  " and typename <>'Ute av bruk for tilfellet'";

        if($tueksakt==1) {
            $wherepartype = "typename='".$db->real_escape_string($tu)."'";
            $whereparunit = "enhet='".$db->real_escape_string($tu)."'";
        } else {
            $wherepartype = "";
            $whereparunit = "";
            //$tuv = explode(" ", $tu );
            $tuv = split_parameter_string($tu);            
            foreach($tuv as $v) {
                if(strlen($v)<=0) {
                    continue;
                }
                if(strlen($wherepartype)>0)
                    $wherepartype.= " AND ";    
                $wherepartype.= "(gal_type.typename LIKE '%$v%')";

                if(strlen($whereparunit)>0)
                    $whereparunit.= " AND ";    
                $whereparunit.= "(gal_unit.enhet LIKE '%$v%')";
            }        
        }

        $query = "select typeID from gal_type WHERE ($wherepartype) ".ADD_AND($katpar).$skiptype;
        //echo $query."'<br/>".PHP_EOL;
        $result = $db->query($query);
        id_result_to_array($result,$typeid);
        if($result) $result->free();
        $typepar = array_to_wherepar($typeid,"typeID");
        if(sizeof($typeid)>0) {
            $query = "select numID from gal_unit WHERE (($whereparunit) OR ($typepar)) ".ADD_AND($reqtypepar);
        } else {
            $query = "select numID from gal_unit WHERE ($whereparunit) ".ADD_AND($reqtypepar);
        }
        //echo $query."'<br/>".PHP_EOL;
        $result = $db->query($query);
        id_result_to_array($result,$unitid);
        if($result) $result->free();
        $unitpar = array_to_wherepar($unitid,"nummer");   

        if(strlen($unitpar)==0) {
            $NoHits = True;    
        }

    } else if(strlen($reqtypepar)>0) {
        // no unit&/type param, but katid must be translated to unit param
        $query = "select numID from gal_unit WHERE $reqtypepar";
        $result = $db->query($query);
        id_result_to_array($result,$unitid);
        //pa("unitid",$unitid);
        if($result) $result->free();
        $unitpar = array_to_wherepar($unitid,"nummer");

        if(strlen($unitpar)==0) {
            $NoHits = True;    
        }
    }
}

//echo "unitpar='".$unitpar."'<br/>".PHP_EOL;
//echo "typepar='".$typepar."'<br/>".PHP_EOL;

      
// bilder
$img = NULL;
$nimg=0;
if(!$NoHits) {

    if(strlen($search)>0) {

        //$sv = explode(" ", $search );
        $sv = split_parameter_string($search);            

        $unitwherepar = "";
        $typewherepar = "";        
        foreach($sv as $v) {
            if(strlen($v)<=0)
                continue;
            
            if(strlen($unitwherepar)>0)
                $unitwherepar.= " AND ";    
            if(strlen($typewherepar)>0)
                $typewherepar.= " AND ";    
            
            $unitwherepar .= "((info LIKE '%$v%') OR (info2 LIKE '%$v%'))";
            
            $typewherepar .= "(info LIKE '%$v%')";
        }

        // treff i type info tekst
        $typehits = NULL;
        $query = "select typeID from gal_type where $typewherepar";
        $result = $db->query($query);
        $tarr = NULL;
        id_result_to_array($result,$tarr);
        $typehits = array_to_wherepar($tarr,"type");
        if($result)  $result->free();
        
        // treff i unit info tekst
        $unithits = "";
        $query = "select numID from gal_unit where $unitwherepar";
        $result = $db->query($query);
        $uarr = NULL;
        id_result_to_array($result,$uarr);
        $unithits = array_to_wherepar($uarr,"nummer");
        if($result)  $result->free();
        
        // treff i gal_images 
        $wherepar = "";

        if(strlen($typehits)>0) {  
            $wherepar.= "($typehits) OR ";
        }

        if(strlen($unithits)>0) {  
            $wherepar.= "($unithits) OR ";
        }
        
        $first = TRUE;
        foreach($sv as $v) {
            if(strlen($v)<=0)
                continue;
            
            if(!$first) {
                $wherepar.= " AND ";  
            }

            $first = FALSE;
            
            $wherepar.= "((navn LIKE '%$v%') OR (tekst LIKE '%$v%')  ".
                        "OR (fotograf LIKE '%$v%') OR (lukkertid LIKE '%$v%')".
                        "OR (bruker LIKE '%$v%') OR (kamera LIKE '%$v%') ".
                        "OR (kameramodel LIKE '%$v%') ".
                        "OR (blender LIKE '%$v%') OR (iso LIKE '%$v%') OR (focal LIKE '%$v%') ".
                        "OR ('$v' IN (FROM_UNIXTIME(dato,'%d.%m.%Y'),FROM_UNIXTIME(dato,'%e.%c.%Y'),FROM_UNIXTIME(dato,'%d%m%Y'),FROM_UNIXTIME(dato,'%Y%m%d'))) )";
        }
        

        //list_unit_ids($unitid);
        $query = "select id from gal_images where ($wherepar) and (posthylla = 1) ".ADD_AND($unitpar)."";
        //echo "query '".$query."'<br/>";
        $result = $db->query($query);
        //var_dump($result); echo "<br/>";
        id_result_to_array($result,$img);
        $nimg=sizeof($img);
        if($result) $result->free();

    } else if(strlen($unitpar)>0) {
        $query = "select id from gal_images where $unitpar and posthylla = 1";
        $result = $db->query($query);
        id_result_to_array($result,$img);
        $nimg=sizeof($img);
        if($result) $result->free();    
    }
}

$npages = ceil(floatval($nimg)/$IMG_PER_PAGE);
if($page>$npages) {
    $page = $npages;
}


// *** Present result
// 

function bladdrediv($npages,$page) {
   echo '<div style="width: 1000px; text-align: center;">';
   
   $thissearch = get_this_search(0);  // without page=... parameter

   if ($npages > 1) { 
	if ($page > 0)  {
          echo '<a href="'.$thissearch.'" target="_parent" style="color: #000000;"><<</a>&nbsp;&nbsp;<a href="'.$thissearch.'&p=';
          if ($page==1) {echo "1";} else {echo $page-1;} 
          echo '" target="_parent" style="color: #000000;"><</a>&nbsp;&nbsp;';
					}	
	$fra=1; $til=$npages;
	if ($npages > 30)
		{
			if ($page>14) {$fra=$page-14;} else {$fra=1;}
			$til=$fra+29; if ($til>$npages) {$til=$npages;}	
			if ($fra>($til-29)) {$fra=$til-29;}
		}				
	else {$til=$npages;}	
	if ($fra>1) {echo "..";}		
 	for ($b = $fra ; $b<$til+1 ; $b++) 
   		{ 
   		if ($b>1) {if ($b>$fra){echo chr(124);}}
   	
   	if ($b==$page){echo "<b> ";}
   	  if ($b!=$page)  { 
              echo '&nbsp;<a href="'.$thissearch.'&p=';
              echo $b;
              echo '" target="_parent" style="color: #000000;">';
          }
   	  	 echo $b;
   	  	   if ($b!=$page) { 
                       echo '</a>&nbsp;';
                   }	  
   	if ($b==$page){echo " </b>";} 
   		}
   	if($til<$npages) {echo "..";}	
        if ($page<$npages+1)   {

                echo '&nbsp;&nbsp;<a href="'.$thissearch.'&p=';
                if ($page<$npages) {echo $page+1;} else {echo $npages;} 
                echo '" target="_parent" style="color: #000000;">></a>&nbsp;&nbsp;<a href="'.$thissearch.'&p=';
                echo $npages; 
                echo '" target="_parent" style="color: #000000;">>></a>';
        }
   }
   echo '</div>';
}

?>
<div class="gal_container">
	<div id="index_left">
		<?php 
			include('../bo/bo_sideshow.php'); 
			?>
	</div>
	<div id="index_right">
		<div class="gal_heading">
			BILDES&Oslash;K RESULTAT
		</div>
	<div class="nygal_content">
		<strong>Søkeparametre:</strong><br /><br />
			<div style="display: inline-block; width: 90px; height; 50px; ">
				<strong>Kategori:</strong><br />
				<strong>Type/enhet:</strong><br />
				<strong>Søketekst:</strong><br />
			</div>
			<div style="display: inline-block; width: 600px;height; 50px;">	
				<?php echo $kat; ?><br />
				<?php echo $tu; ?><br />
				<?php echo $search; ?><br />
			</div>
			<div style="width: 960px;">
				<hr />
			</div>	
			
<?php
// content start
?>			
		<?php
		   if($nimg==0) {
       
		?>
		        <strong><span style="font-size: medium;">Ingen bilder matcher s&oslash;keparametrene</span></strong>
		<?php
		   } else {

		   bladdrediv($npages,$page);
		?>
        
		        <table cellspacing="0" cellpadding="0" border="0" width="100%">
		<?php
		$o=($page-1)*$IMG_PER_PAGE;
		for ($l = 0 ; $l<(ceil($nimg/$IMAGES_PER_LINE)) ; $l++)
		 {

		    if($l>=$LINES_PER_PAGE)
		        break;
    
		    if($o>=$nimg)
		        break;
    
		    ?>
		  <tr>
		 <?php	
		 	for ($k = 0 ; $k<$IMAGES_PER_LINE ; $k++)
		        {
		             if($o>=$nimg)
		               break;
					@$query5 = "select id, thumb, tekst, fotograf, poeng, stemmer, navn from gal_images where id = '$img[$o]'";
					@$result5 = $db->query($query5);
					@$image = $result5->fetch_array();        	
		?>
            
		      <td align="center" valign="top">      
		        <?php
		            if (isset($image[0])){ ?>
            
			<div class="nygal_box">
					<div class="nygal_starhead">
		 			   <?php
		 			     if ($image[4]>0) { $stars = round($image[4]/$image[5]); } else { $stars = 0; }
		 			   ?>
		 			    <img src="graphics/<?php echo $stars;?>stars.gif" alt="">
					</div>
				    		<a href="subpage.php?s=0&amp;id=<?php echo $image[0]; ?>" target="_parent"><img src="<?php echo $image[1] ?>" class="nygal_img" alt="" /></a><br />	
					<div class="nygal_imgtext">   
					   <?php echo $image[2]; ?><br />
				    </div>	    
					<div class="nygal_imgbund">
						<div class="nygal_author">
							<?php echo "&copy; ".$image[3]; ?>
						</div>
						<div class="nygal_searchicon">
								<a href="../phorum/search.php?7,search=<?php echo $image[8]; ?>,page=1,match_type=ALL,match_dates=0,match_forum=ALL,match_threads=0"><img src="../bo/graphics/search.jpg" title="Finn i Postvogna" alt="Finn i Postvogna"/></a>
						</div>
					</div>
	    	</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		       <hr style="background-color: #FFFFFF; color: #FFFFFF; height: 1px; collapse:collapse;">
		        
    
		            </td>
		            <?php
		               	}
		          	$o=$o+1;
		        }	?>
		   </tr> 
		<?php       	
		 	}
		?>
		</table>
		<br /><br />
		<?php
		   bladdrediv($npages,$page);
		   }   // end if $nimg==0
		?>
		<br /><br />
<?php
	// content end
?>			
					
	</div>
	<div id="gal_breadcrum">
	<a href="<?php echo $path.get_back_to_search_url(); ?>" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">Tilbake til bildes&oslash;k</a>
	</div>
	</div>		
</div>



