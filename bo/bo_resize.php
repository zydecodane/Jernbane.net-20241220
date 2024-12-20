<?php
// resize to 1024	
$sourceImageFilePath = $file1;
$maxResizeWidth = 1198;
$maxResizeHeight = 1198;
$outputPath = $file1;
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
$result = imagejpeg($imageOutput, $outputPath, 90);
if($result === FALSE) return false; // Error condition
// end resize ---------------------------------------------
?>