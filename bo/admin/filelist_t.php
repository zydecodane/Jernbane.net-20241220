<?php

/*
$server1 = "localhost";
$dbuser1 = "php";
$pw1     = "picard";
$dbase  = "jernbane_net";
*/


$server1 = "94.231.109.106";
$dbuser1 = "phorum";
$pw1     = "ivarslund";
$dbase  = "jernbane";


$db = mysql_connect($server1, $dbuser1, $pw1);
mysql_select_db($dbase, $db);

$n=0;
$m=0;
$ok = 0;

$dir = $_GET['d'];

//$domain = 'home.gill.dk/jernbane.net';
//$domain2 = 'home.gill.dk/jernbane.net';
 $domain = 'www.jernbane.net';
 $domain2 = 'jernbane.net';

if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
         if (substr($entry,0,5) == "thumb" ) {
          $url = 'http://'.$domain.'/'.$dir.'/'.$entry;
//søgning start

            $url = 'http://'.$domain.'/'.$dir.'/'.$entry;
            //echo $url; echo "<br />";
            
            $ok=0;

            @$getimg = mysql_query("SELECT id FROM gal_images WHERE url = '$url' ");
            @$result=mysql_fetch_row($getimg);
            if ($result[0] > 0)   // billedet findes i databasen
             {
                $ok=1;
             }
            
            if ($ok == 0)
              {
                    @$getimg = mysql_query("SELECT id FROM gal_images WHERE thumb = '$url' ");
                    @$result=mysql_fetch_row($getimg);
                    if ($result[0] > 0)   // billedet findes i databasen
                    {
                       $ok=1;
                     }
              }
              
            // domæneskift - og check igen
            $url = 'http://'.$domain2.'/'.$dir.'/'.$entry; // nu checker vi på det andet domæne unden www

            if ($ok == 0)
              {

                    @$getimg = mysql_query("SELECT id FROM gal_images WHERE url = '$url' ");
                    @$result=mysql_fetch_row($getimg);
                       if ($result[0] > 0)   // billedet findes i databasen
                         {
                           $ok=1;
                         }
              }
              
            if ($ok == 0)
              {
                           @$getimg = mysql_query("SELECT id FROM gal_images WHERE thumb = '$url' ");
                           @$result=mysql_fetch_row($getimg);
                           if ($result[0] > 0)   // billedet findes i databasen
                           {
                             $ok=1;
                           }
              }




// søgning slut
if ($ok == 0) {
?>
                           <a href="bo/admin/filelist_delete.php?url=<?php echo $url ?>&dir=<?php echo $dir; ?>">* slett * </a>&nbsp;&nbsp;&nbsp; -
                           &nbsp;&nbsp;&nbsp;<a href="bo/admin/filelist_cat.php?url=<?php echo $url ?>&dir=<?php echo $dir; ?>">velg</a>&nbsp;&nbsp;&nbsp; -  &nbsp;&nbsp;&nbsp;<a href="<?php echo $url; ?>"><?php echo $url; ?></a><br />
                           <?php
						   $slashpos = strrpos($url, "/");
							$newfile = substr($url, ($slashpos+1));
							$newurl = '../../'.$dir.'/'.$newfile;
							unlink ($newurl) ;
							echo "<br />"; 
                           $m=$m+1;


}
$n=$n+1;

         }
        }
    }

    closedir($handle);
}



echo "<br />"; 
echo "Unders&oslash;gt "; echo $n; echo " bilder<br />";

echo $m; echo " bilder funnet i folderen  <i>"; echo $dir; echo "</i><br />";

?>
<br /><br />
