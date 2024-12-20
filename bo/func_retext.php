<?php

include("../configi.php");

// function gyffe() {
//     echo "<p>Gyffe er kaldt.</p>";
// }

if (!function_exists('retext_image')) {
  function retext_image($id, $author, $newtext, $date)
  {
    global $db;
    // Test
  	echo("<h2>retext_image kaldt med disse data</h2>");  
    echo("<p>id: " . $id . "</p>");
    echo("<p>Author: " . $author . "</p>");
    echo("<p>New text: " . $newtext . "</p>");
    echo("<p>Date: " . $date . "</p>");

    $query = "select clean_url from gal_images where id = '$id';";

    echo "<p>Vi finder billedets url: " . $query . "</p>";

	$filepath = $db->query($query)->fetch_object()->clean_url;
    echo("<p>Local file path: " . $filepath . "</p>");
// exit;
    // Desperat:
   $sourceImageFilePath = "../.." . $filepath;
   echo("<p>Final file path: " . $sourceImageFilePath . "</p>");

    // Get width and height of original image
   /*  $size = getimagesize($sourceImageFilePath);


    if ($size === FALSE) return FALSE; // Error
    $origWidth = $size[0];
    $origHeight = $size[1];
 */
    //Test
//    echo("<p>image size 1: " . $origWidth . " gange " . $origHeight . "</p>");

    // Opret et billede ved at loade det originale

    $im = ImageCreateFromJpeg($sourceImageFilePath);

    if ($im === FALSE)
      return FALSE;
    $width = ImageSx($im);
    $height = ImageSy($im);

    //Test
    echo("<p>image size 2: " . $width . " gange " . $height . "</p>");

    // Sammensaet den nye tekst af Copyright, Fotograf og Tekst

    if ($author != '') {
      $newTextLine = mb_chr(169) . " " . $author;
    } else {
      $newTextLine = '';
    }
    if ($newtext != '') {     $newTextLine .= ' - ' . $newtext;
    }
    if ($date != '') {
      $newTextLine .= ', ' . $date;
    }

    // test
    echo ("<p>Den nye tekst: " . $newTextLine . "</p>");

    // Dan et nyt tekstbillede med samme bredde som originalen
    // $textImageWidth = 800;
    // $textImageHeight = 600;
    $textImageWidth = $width;
    $textImageHeight = 24;

    $textImage = imagecreatetruecolor($textImageWidth, $textImageHeight);
    $backgroundColor = imagecolorallocate($textImage, 0, 0, 0);
    // if ($backgroundColor === FALSE) {
    //   echo ("<p>Ingen baggrundsfarve</p>");
    // } else {
    //   echo ("<p>Baggrundsfarve: ");
    //   var_dump($backgroundColor);
    //   echo("</p>");
    // }

    imagefilledrectangle($textImage, 0, 0, $textImageWidth, $textImageHeight, $backgroundColor );

    // $info = gd_info();
    // echo ("<p>gd_info: ");
    // var_dump($info);
    // echo("</p>");
    // $font = './calibri.ttf';
    // Set the environment variable for GD
    putenv('GDFONTPATH=' . realpath('.'));

    echo "<p>realpath(): " . realpath('.') . "</p>";

    // Name the font to be used 
    $font = 'calibri.ttf';
    // $font = 'calibri';

    $textcolor = imagecolorallocate( $textImage, 255, 255, 255);
    // if ($textcolor === FALSE) {
    //   echo ("<p>Ingen forgrundsfarve</p>");
    // } else {
    //   echo ("<p>Forgrundsfarve: ");
    //   var_dump($textcolor);
    //   echo("</p>");
    // }
    
    $textresult = imagefttext($textImage, 11, 0, 8, 18, $textcolor, $font, $newTextLine);
//    $textImage = imagefttext($textImage, 11, 0, 8, 18, $textcolor, $font, $newTextLine);
    if ($textresult === FALSE) {
      echo ("<p>Ingen tekst dannet.</p>");
    } else {
        echo ("<p>Tekstresultat:</p>");
        var_dump($textresult);
        echo ("</p>");
    }

    // Test: udskriv tekstbilledet
    $testfile = "../test/uploads/textfile.jpg";
    ImageJpeg($textImage, $testfile);
    echo "<p>Tekstbilledet er udskrevet.</p>";

    // Lav et internt billede med logoet.
    $logo = imagecreatefromgif("../graphics/logo.gif");
    $logowidth = ImageSx($logo);
    $logoheight = ImageSy($logo);
    echo "<p>logo.gif er indlaest.</p>";

    //Test
    // echo("<p>Logo size: " . $logowidth . " gange " . $logoheight . "</p>");
    ImageJpeg($logo, "../test/uploads/logofile.jpg");

    // Kopier logo-billedet ind i hoejre ende af tekstbilledet
    // imagecopymerge($textImage, $logo, $textImageWidth-$logowidth-1, 1, 0, 0, $logowidth, $logoheight, 100);
    if (imagecopymerge($textImage, $logo, $textImageWidth-$logowidth-1, 1, 0, 0, $logowidth, $logoheight, 100))
      echo("<p>Images merged.</p>");
    // Test
    $textwithlogo = "../test/uploads/textlogofile.jpg";
    ImageJpeg($textImage, $textwithlogo);

    // Kopier det resulterende tekstbillede ind nederst i det originale billede
    if (imagecopymerge($im, $textImage, 0, $height-$textImageHeight, 0, 0, $textImageWidth, $textImageHeight, 100))
      echo("<p>Billedet er færdigt.</p>");

    // Skriv det rettede billede ned med samme filnavn som det originale.
    // ImageJpeg($im, $sourceImageFilePath);

    // Ved test dog et andet sted.
    ImageJpeg($im, "../test/uploads/resultat.jpg");
    // imagejpeg($im, "C:/Apache24/htdocs/jernbane-net/bo/test/uploads/resultat.jpg");

    // Ryd op
    imagedestroy($im);
    imagedestroy($textImage);
    imagedestroy($logo);
    return TRUE;
  }
}


if (!function_exists('retext_db')) {
    function retext_db($id, $author, $newtext, $newdate) {
        global $db;
    // Test
    echo("<h2>retext_db kaldt med disse data</h2>");  
    echo("<p>id: " . $id . "</p>");
    echo("<p>Author: " . $author . "</p>");
    echo("<p>New text: " . $newtext . "</p>");
    echo("<p>Date: " . $newdate . "</p>");

    // Convert newdate to Unix format
        if ($newdate!=0){
        $year1 = substr($newdate,6,4);
        $month1 = substr($newdate,3,2);
        $day1 = substr($newdate,0,2);
        $newdateu = mktime(0, 0, 0, $month1, $day1, $year1);
        } 

        $query = "update gal_images set fotograf='" . $author . "', tekst='" . $newtext . "', dato='" . $newdateu . "' where id=" . $id . ";";
        echo "<p>Vi laver query: " . $query . "</p>";
        $result = mysqli_query($db, $query);
        if ($result) {
            echo "<p>Det gik godt!</p>";
        } else {
            echo "<p>Fejl ved opdatering mod databasen: </p>";
        }

    }
}