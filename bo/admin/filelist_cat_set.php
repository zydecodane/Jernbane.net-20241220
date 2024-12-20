<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include('configi.php');

// $domain = 'home.gill.dk/jernbane_net';
$domain = 'jernbane.net';

$fotograf = $_POST['fotograf'];
$tekst = $_POST['tekst'];
$date1 = $_POST['date1'];
$url = $_POST['url'];
$dir = $_POST['dir'];
$newfile = $_POST['newfile'];

$tekst = addslashes($tekst);

//$url = "http://jernbane.net/tema/busser/1118-2.jpg";
$url = substr_replace($url, 's',4, 0);

$pos = strpos($url, 'jernbane.net');

$clean_url = substr($url,$pos+12,strlen($url));



if(isset($_POST['drop_3'])) { $type = $_POST['drop_3']; } else { $type = 0; }
if(isset($_POST['drop_4'])) { $unit = $_POST['drop_4']; } else { $unit = 0; }

/*
echo $fotograf; echo "<br />";
echo $tekst; echo "<br />";
echo $date1; echo "<br />";
echo $type; echo "<br />";
echo $unit; echo "<br />";
echo $newfile; echo "<br />";
*/


if ($date1!=0){
$year1 = substr($date1,6,4);
$month1 = substr($date1,3,2);
$day1 = substr($date1,0,2);
$date1 = mktime(0, 0, 0, $month1, $day1, $year1);
}

	$shutter1 = '';
	$camera1 = '';
	$model1 = '';
	$aperture1 = '';
	$focal1 = '';
	$iso1 = '';
	$lat1 = 0;
	$lon1 = 0;

// resize functions

 $frafil = $url;
 $tilfil = '../../opsamling/thumbs/'.$newfile;



if(!function_exists('get_image_size')){
function get_image_sizes($sourceImageFilePath, 
  $maxResizeWidth, $maxResizeHeight) {

  // Get width and height of original image
  $size = getimagesize($sourceImageFilePath);
  if($size === FALSE) return FALSE; // Error
  $origWidth = $size[0];
  $origHeight = $size[1];

  // Change dimensions to fit maximum width and height
  $resizedWidth = $origWidth;
  $resizedHeight = $origHeight;
  if($resizedWidth > $maxResizeWidth) {
    $aspectRatio = $maxResizeWidth / $resizedWidth;
    $resizedWidth = round($aspectRatio * $resizedWidth);
    $resizedHeight = round($aspectRatio * $resizedHeight);
  }
  if($resizedHeight > $maxResizeHeight) {
    $aspectRatio = $maxResizeHeight / $resizedHeight;
    $resizedWidth = round($aspectRatio * $resizedWidth);
    $resizedHeight = round($aspectRatio * $resizedHeight);
  }
  
  // Return an array with the original and resized dimensions
  return array($origWidth, $origHeight, $resizedWidth, 
    $resizedHeight);
}
}
// resize slut

// resize action


$sourceImageFilePath = $frafil;


$maxResizeWidth = 250;
$maxResizeHeight = 350;
$outputPath = $tilfil;



// Get dimensions
$sizes = get_image_sizes($sourceImageFilePath, $maxResizeWidth, $maxResizeHeight);
$origWidth = $sizes[0];
$origHeight = $sizes[1];
$resizedWidth = $sizes[2];
$resizedHeight = $sizes[3];


// Create the resized image 
$imageOutput = imagecreatetruecolor($resizedWidth, $resizedHeight);
if($imageOutput === FALSE) return FALSE; // Error condition

// Load the source image
$imageSource = imagecreatefromjpeg($sourceImageFilePath);
if($imageSource === FALSE) return FALSE; // Error condition


$result = imagecopyresampled($imageOutput, $imageSource, 
    0, 0, 0, 0, $resizedWidth, $resizedHeight, $origWidth, 
    $origHeight);
if($result === FALSE) return false; // Error condition


// Write out the JPEG file with the highest quality value
$result = imagejpeg($imageOutput, $outputPath, 80);
if($result === FALSE) return false; // Error condition

// resize slut

$datetime = date('U');


$thumb = "http://".$domain."/opsamling/thumbs/".$newfile ;

$clean_thumb = "/opsamling/thumbs/".$newfile;

$user = "admin";
$query = "INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, modify_time, clean_url, clean_thumb) VALUES ('$url','$thumb','$newfile','$tekst','$fotograf','$date1','$user','0','$type','$unit','$camera1','$model1','$shutter1','$aperture1','$iso1','$focal1','1','$lat1','$lon1','$datetime','$datetime','$clean_url','$clean_thumb')";
$result = mysqli_query($db, $query);

echo "<script>parent.location.href='../../filelist.php?d=".$dir."'</script>";

?>