<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
';

include ('configi.php');

$type='img';	
if (isset($_POST["type"])) { $type=$_POST["type"]; }
if (isset($_GET["type"])) { $type=$_GET["type"]; }

$n=1;	
if (isset($_POST["n"])) { $n=$_POST["n"]; }
if (isset($_GET["n"])) { $n=$_GET["n"]; }

$timezero = mktime(12,0,0,1,10,2017); //new DateTime("2017-01-10 12:00:00");

/*
$txt = "John Doe\n"."Jane Doe\n";
file_put_contents("../../testfile.txt",$txt,LOCK_EX) or print_r(error_get_last());
//die("Unable to write to file!");
print "File created";
*/

function sitemap_head() {
    print '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
}

function sitemap_tail() {
    print '</urlset>
';
}

function sitemap_url($url, $lastmod=0, $changefreq="never", $priority="1.0") {
    global $timezero;
    if($lastmod==0) {
        $lastmod = $timezero;
    }
    $tstr = strftime("%F", $lastmod);
    print '  <url>
    <loc>'.$url.'</loc>
    <lastmod>'.$tstr.'</lastmod>
  </url>
';
    // venter med lastmod etc. til dette stoettes av db
/*    print '  <url>
    <loc>'.$url.'</loc>
    <lastmod>'.$lastmod.'</lastmod>
    <changefreq>'.$changefreq.'</changefreq>
    <priority>'.$priority.'</priority>
</url>
';*/
}

$N_PER_FILE = 40000;

sitemap_head();

if($type=="type") {
    $query ="SELECT typeID, modify_time FROM `gal_type` WHERE typeID > 0";
    $result = $db->query($query);
    //var_dump($result);
    while ( $typeinfo = $result->fetch_array() ) {
        //print "type = ".$typeinfo[0]."<br>\n";
        sitemap_url('http://jernbane.net/bo/subpage.php?s=3&amp;t='.$typeinfo[0],$typeinfo[1]);
    }
}

if($type=="img") {
    $startimg = ($n-1) * $N_PER_FILE;
    $lastimg = $startimg + $N_PER_FILE;

    $query ="SELECT id, modify_time FROM `gal_images` WHERE url<>''";
    $result = $db->query($query);
    $i=0;
    while ( $imginfo = $result->fetch_array() ) {
        // er det ok aa bruke userid 0 her? Google vil jo ikke ha adgang til fullstoerrelse bilder uansett
        if($i>=$startimg && $i<$lastimg) {
            sitemap_url('http://jernbane.net/bo/subpage.php?s=0&amp;id='.$imginfo[0].'&amp;u=0',$imginfo[1]);
        }
        $i++;
    }
}

sitemap_tail();
        

?>
