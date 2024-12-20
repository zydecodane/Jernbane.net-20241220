<?php

$border1 = 1;
$border2 = 23;
$im=ImageCreateFromJpeg($add);
$width=ImageSx($im);
$height=ImageSy($im);

$img_adj_width=$width+(2*$border1);
$img_adj_height=$height+($border1+$border2);
$newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);

$border_color = imagecolorallocate($newimage, 0, 0, 0);
imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);

imageCopyResized($newimage,$im,$border1,$border1,0,0,$width,$height,$width,$height);
// ImageJpeg($newimage,$add,100);  // image is saved

// border is added

if ($author != '') { $textline = chr(169)." ".$author; } else { $tekstline = ''; }
if ($text != '') { $textline .= ' - '.$text; }
if ($date !='')  { $textline .= ', '.$date; } 


$text_colour = imagecolorallocate( $newimage, 255, 255, 255 );

// $font = 'pala.ttf';
// $font = 'verdana.ttf';
// $font = 'AquaKana.ttc';
// $font = 'refsan.ttf';
// $font = 'cour.ttf';
$font = './calibri.ttf';


imagettftext($newimage, 11, 0, 10, $height+18, $text_colour, $font, $textline);

// text i swritten - now we paste the logo

$logo = imagecreatefromgif("graphics/logo.gif");

// list($width, $height) = getimagesize($newimage);

$newwidth = $width+2*$border1;
$newheight = $height+$border1+$border2;

$pics = imagecreatetruecolor($newwidth, $newheight);

imagecopyresampled($pics, $newimage, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
imagecopymerge($pics, $logo, ($newwidth-imageSX($logo)), ($newheight-imageSY($logo)), 0, 0, imageSX($logo), imageSY($logo), 100);

// the logo is pastetd - now we save the file

ImageJpeg($pics,$new_filename,100);  // image is saved

  // Clear Memory
 
imagedestroy($newimage);
imagedestroy($pics);

?>