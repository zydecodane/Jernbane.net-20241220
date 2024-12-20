<?php
include('configi.php');
include('bo_exif_functions.php');
include_once ('bo_resize_functions.php');
$antimg = 0;

if(isset($_POST['gallery'])) { $gallery = $_POST['gallery']; } else { $gallery = '2'; }

$query = "select data from phorum_settings where name = 'http_path'";
$httppath = $db->query($query)->fetch_object()->data;

$domain = substr($httppath,0,strrpos($httppath,'/'));

$query = "select var from gal_variables where name = 'upload_folder'";
$folder = $db->query($query)->fetch_object()->var;

if (isset($_POST['user'])) {$user = $_POST['user'];}
$ip = $_SERVER['REMOTE_ADDR'];
$datetime = date('U');

$indir = '../incoming/';

// ---------  image 1 -------------

if ($_FILES['img']['name'][0]!='')
{
$originalfile1 = $_FILES['img']['name'][0];

//removing web-unfriendly characters
$originalfile1 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile1);

$newfile1 = $datetime.'_'.$originalfile1;
$file1 = $indir.$newfile1;
copy($_FILES['img']['tmp_name'][0], $file1); 
// now the file is stored in the incoming-folder


// check for filetype
$filecheck1 = 'false';
if (strtolower(substr($file1, -3)) == 'jpg') {$filecheck1 = 'true';}
if (strtolower(substr($file1, -4)) == 'jpeg') {$filecheck1 = 'true';}

// check for filesize
//if (filesize($file1) > 1024000) {$filecheck1 = "size";}

if ($filecheck1 != 'true')
{ 
  unlink($file1); 
  $antimg = $antimg+1;
}
else
{	
if(isset($_POST['photographer1'])) { $photographer1 = $_POST['photographer1']; } else { $photographer1=''; }
if(isset($_POST['tekst1'])) {$tekst1 = $_POST['tekst1']; } else { $tekst1=''; }
if(isset($_POST['date1'])) {$date1 = $_POST['date1']; } else { $date1=0; }
if(isset($_POST['drop_1'])) { $country1 = $_POST['drop_1']; } else { $country1 = 0; }
if(isset($_POST['drop_2'])) { $cat1 = $_POST['drop_2']; }  else { $cat1 = 0; }
if(isset($_POST['drop_3'])) { $type1 = $_POST['drop_3']; } else { $type1 = 0; }
if(isset($_POST['drop_4'])) { $unit1 = $_POST['drop_4']; } else { $unit1 = 0; }
if(isset($_POST['drop_4_1'])) { $detail1 = $_POST['drop_4_1']; } else { $detail1 = 0; }

if ($date1!=0){
$year1 = substr($date1,6,4);
$month1 = substr($date1,3,2);
$day1 = substr($date1,0,2);
$date1 = mktime(0, 0, 0, $month1, $day1, $year1);
} 

$url1 = $domain.'/'.$folder.'/'.$newfile1;
$thumb1 = $domain.'/'.$folder.'/thumbs/'.$newfile1;
    
$clean_url1 = '/'.$folder.'/'.$newfile1;
$clean_thumb1 = '/'.$folder.'/thumbs/'.$newfile1;    

@$exif_data = exif_read_data($file1, 'EXIF' ,0 );
if (isset($exif_data['Make'])) { 

$shutter1 = calcExposure($exif_data['ExposureTime']).' sec';
$camera1 = $exif_data['Make'];
$model1 = $exif_data['Model'];
$aperture1 = 'f/'.toDecimal($exif_data['FNumber']);
$focal1 = toDecimal($exif_data['FocalLength']).' mm';
$iso1 = 'ISO '.$exif_data['ISOSpeedRatings'];

if(isset($exif_data["GPSLongitude"])) {
$lon1 = getGps($exif_data["GPSLongitude"], $exif_data['GPSLongitudeRef']);
$lat1 = getGps($exif_data["GPSLatitude"], $exif_data['GPSLatitudeRef']);
$lat1 = round($lat1,6); 
$lon1 = round($lon1,6);
}
else
{
$lat1=0;
$lon1=0;
}

}
else
{
	$shutter1 = '';
	$camera1 = '';
	$model1 = '';
	$aperture1 = '';
	$focal1 = '';
	$iso1 = '';
	$lat1 = 0;
	$lon1 = 0;
}	

// check for image dimensions
$size1 = getimagesize($file1);
if ($size1[0] > 1400) {
		//$filecheck1 = "dimension";
		// resize to 1400	
	$sourceImageFilePath = $file1;
	$maxResizeWidth = 1390;
	$maxResizeHeight = 1390;
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
	$result = imagejpeg($imageOutput, $outputPath, 100);
	if($result === FALSE) return false; // Error condition
	}
// -----------------------------------------------------------


if ($user !='') {
//removing unfriendly characters
$cleantekst1 = $tekst1;
$tekst1 = addslashes($tekst1);	
	
$query="INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb, detailID) VALUES ('$url1','$thumb1','$newfile1','$tekst1','$photographer1','$date1','$user','$ip','$type1','$unit1','$camera1','$model1','$shutter1','$aperture1','$iso1','$focal1','$gallery','$lat1','$lon1','$datetime','$clean_url1','$clean_thumb1','$detail1')";
$result = mysqli_query($db, $query);


$antimg=$antimg+1;
}
} // end if user is not empty
} // end if file is ok
// ---------  image 2 ----------

if ($_FILES['img']['name'][1]!='')
{
$originalfile2 = $_FILES['img']['name'][1];

//removing web-unfriendly characters
$originalfile2 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile2);

$newfile2 = $datetime.'_'.$originalfile2;
$file2 = $indir.$newfile2;
copy($_FILES['img']['tmp_name'][1], $file2); 
// now the file is stored in the incoming-folder

// check for filetype
$filecheck2 = 'false';
if (strtolower(substr($file2, -3)) == 'jpg') {$filecheck2 = 'true';}
if (strtolower(substr($file2, -4)) == 'jpeg') {$filecheck2 = 'true';}

// check for filesize
//if (filesize($file2) > 1024000) { $filecheck2 = "size"; }


if ($filecheck2 != 'true')
{ 
  unlink($file2); 
  $antimg = $antimg+1;
}
else
{
if(isset($_POST['photographer2'])) { $photographer2 = $_POST['photographer2']; } else { $photographer2=''; }
if(isset($_POST['tekst2'])) {$tekst2 = $_POST['tekst2']; } else { $tekst2=''; }
if(isset($_POST['date2'])) {$date2 = $_POST['date2']; } else { $date2=0; }
if(isset($_POST['drop_5'])) { $country2 = $_POST['drop_5']; } else { $country2 = 0; }
if(isset($_POST['drop_6'])) { $cat2 = $_POST['drop_6'];  } else { $cat2 = 0; }
if(isset($_POST['drop_7'])) { $type2 = $_POST['drop_7']; } else { $type2 = 0; }
if(isset($_POST['drop_8'])) { $unit2 = $_POST['drop_8']; } else { $unit2 = 0; }
if(isset($_POST['drop_8_1'])) { $detail2 = $_POST['drop_8_1']; } else { $detail2 = 0; }

if ($date2!=0){
$year2 = substr($date2,6,4);
$month2 = substr($date2,3,2);
$day2 = substr($date2,0,2);
$date2 = mktime(0, 0, 0, $month2, $day2, $year2);
}

$url2 = $domain.'/'.$folder.'/'.$newfile2;
$thumb2 = $domain.'/'.$folder.'/thumbs/'.$newfile2;
    
$clean_url2 = '/'.$folder.'/'.$newfile2;
$clean_thumb2 = '/'.$folder.'/thumbs/'.$newfile2;     

@$exif_data = exif_read_data($file2, 'EXIF' ,0 );
if (isset($exif_data['Make'])) { 

$shutter2 = calcExposure($exif_data['ExposureTime']).' sec';
$camera2 = $exif_data['Make'];
$model2 = $exif_data['Model'];
$aperture2 = 'f/'.toDecimal($exif_data['FNumber']);
$focal2 = toDecimal($exif_data['FocalLength']).' mm';
$iso2 = 'ISO '.$exif_data['ISOSpeedRatings'];

if(isset($exif_data["GPSLongitude"])) {
$lon2 = getGps($exif_data["GPSLongitude"], $exif_data['GPSLongitudeRef']);
$lat2 = getGps($exif_data["GPSLatitude"], $exif_data['GPSLatitudeRef']);
$lat2 = round($lat2,6); 
$lon2 = round($lon2,6);
}
else
{
$lat2=0;
$lon2=0;
}

}
else
{
	$shutter2 = '';
	$camera2 = '';
	$model2 = '';
	$aperture2 = '';
	$focal2 = '';
	$iso2 = '';
	$lat2 = 0;
	$lon2 = 0;
}	

// check for image dimensions
$size2 = getimagesize($file2);
if ($size2[0] > 1400) {
		//$filecheck1 = "dimension";
		// resize to 1400	
	$sourceImageFilePath = $file2;
	$maxResizeWidth = 1398;
	$maxResizeHeight = 1398;
	$outputPath = $file2;
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
	$result = imagejpeg($imageOutput, $outputPath, 100);
	if($result === FALSE) return false; // Error condition
	}
// -----------------------------------------------------------

if ($user !='') {
//removing unfriendly characters
$cleantekst2 = $tekst2;
$tekst2 = addslashes($tekst2);	
	
$query2="INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb, detailID) VALUES ('$url2','$thumb2','$newfile2','$tekst2','$photographer2','$date2','$user','$ip','$type2','$unit2','$camera2','$model2','$shutter2','$aperture2','$iso2','$focal2','$gallery','$lat2','$lon2','$datetime','$clean_url2','$clean_thumb2','$detail2')";
$result2 = mysqli_query($db, $query2);

$antimg=$antimg+1;
}
} // end if user is not empty
} // end if file2 is ok
// ---------  image 3 ------------

if ($_FILES['img']['name'][2]!='')
{
$originalfile3 = $_FILES['img']['name'][2];

//removing web-unfriendly characters
$originalfile3 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile3);

$newfile3 = $datetime.'_'.$originalfile3;
$file3 = $indir.$newfile3;
copy($_FILES['img']['tmp_name'][2], $file3); 
// now the file is stored in the incoming-folder

// check for filetype
$filecheck3 = 'false';
if (strtolower(substr($file3, -3)) == 'jpg') {$filecheck3 = 'true';}
if (strtolower(substr($file3, -4)) == 'jpeg') {$filecheck3 = 'true';}

// check for filesize
//if (filesize($file3) > 1024000) {$filecheck3 = "size";}

if ($filecheck3 != 'true')
{ 
  unlink($file3); 
  $antimg = $antimg+1;
}
else
{
if(isset($_POST['photographer3'])) { $photographer3 = $_POST['photographer3']; } else { $photographer3=''; }
if(isset($_POST['tekst3'])) {$tekst3 = $_POST['tekst3']; } else { $tekst3=''; }
if(isset($_POST['date3'])) {$date3 = $_POST['date3']; } else { $date3 = 0; }
if(isset($_POST['drop_9'])) { $country3 = $_POST['drop_9']; } else { $country3 = 0; }
if(isset($_POST['drop_10'])) { $cat3 = $_POST['drop_10'];  } else { $cat3 = 0; }
if(isset($_POST['drop_11'])) { $type3 = $_POST['drop_11']; } else { $type3 = 0; }
if(isset($_POST['drop_12'])) { $unit3 = $_POST['drop_12']; } else { $unit3 = 0; }
if(isset($_POST['drop_12_1'])) { $detail3 = $_POST['drop_12_1']; } else { $detail3 = 0; }

if ($date3!=0){
$year3 = substr($date3,6,4);
$month3 = substr($date3,3,2);
$day3 = substr($date3,0,2);
$date3 = mktime(0, 0, 0, $month3, $day3, $year3);
}

$url3 = $domain.'/'.$folder.'/'.$newfile3;
$thumb3 = $domain.'/'.$folder.'/thumbs/'.$newfile3;
    
$clean_url3 = '/'.$folder.'/'.$newfile3;
$clean_thumb3 = '/'.$folder.'/thumbs/'.$newfile3;     

@$exif_data = exif_read_data($file3, 'EXIF' ,0 );
if (isset($exif_data['Make'])) { 

$shutter3 = calcExposure($exif_data['ExposureTime']).' sec';
$camera3 = $exif_data['Make'];
$model3 = $exif_data['Model'];
$aperture3 = 'f/'.toDecimal($exif_data['FNumber']);
$focal3 = toDecimal($exif_data['FocalLength']).' mm';
$iso3 = 'ISO '.$exif_data['ISOSpeedRatings'];

if(isset($exif_data["GPSLongitude"])) {
$lon3 = getGps($exif_data["GPSLongitude"], $exif_data['GPSLongitudeRef']);
$lat3 = getGps($exif_data["GPSLatitude"], $exif_data['GPSLatitudeRef']);
$lat3 = round($lat3,6); 
$lon3 = round($lon3,6);
}
else
{
$lat3=0;
$lon3=0;
}

}
else
{
	$shutter3 = '';
	$camera3 = '';
	$model3 = '';
	$aperture3 = '';
	$focal3 = '';
	$iso3 = '';
	$lat3 = 0;
	$lon3 = 0;
}	

// check for image dimensions
$size3 = getimagesize($file3);
if ($size3[0] > 1400) {
		//$filecheck1 = "dimension";
		// resize to 1400	
	$sourceImageFilePath = $file3;
	$maxResizeWidth = 1398;
	$maxResizeHeight = 1398;
	$outputPath = $file3;
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
	$result = imagejpeg($imageOutput, $outputPath, 100);
	if($result === FALSE) return false; // Error condition
	}
// -----------------------------------------------------------

if ($user !='') {
//removing unfriendly characters
$cleantekst3 = $tekst3;
$tekst3 = addslashes($tekst3);

$query3="INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb, detailID) VALUES ('$url3','$thumb3','$newfile3','$tekst3','$photographer3','$date3','$user','$ip','$type3','$unit3','$camera3','$model3','$shutter3','$aperture3','$iso3','$focal3','$gallery','$lat3','$lon3','$datetime','$clean_url3','$clean_thumb3','$detail3')";
$result3 = mysqli_query($db, $query3);

$antimg=$antimg+1;
}
} // end if user is not empty
} // end if file3 is ok
// ----------- end image 3 --------------

// ---------  image 4 ------------

if ($_FILES['img']['name'][3]!='')
{
$originalfile4 = $_FILES['img']['name'][3];

//removing web-unfriendly characters
$originalfile4 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile4);

$newfile4 = $datetime.'_'.$originalfile4;
$file4 = $indir.$newfile4;
copy($_FILES['img']['tmp_name'][3], $file4); 
// now the file is stored in the incoming-folder

// check for filetype
$filecheck4 = 'false';
if (strtolower(substr($file4, -3)) == 'jpg') {$filecheck4 = 'true';}
if (strtolower(substr($file4, -4)) == 'jpeg') {$filecheck4 = 'true';}

// check for filesize
//if (filesize($file4) > 1024000) { $filecheck4 = "size"; }


if ($filecheck4 != 'true')
{ 
  unlink($file4); 
  $antimg = $antimg+1;
}
else
{
if(isset($_POST['photographer4'])) { $photographer4 = $_POST['photographer4']; } else { $photographer4=''; }
if(isset($_POST['tekst4'])) {$tekst4 = $_POST['tekst4']; } else { $tekst4=''; }
if(isset($_POST['date4'])) {$date4 = $_POST['date4']; } else { $date4 = 0; }
if(isset($_POST['drop_13'])) { $country4 = $_POST['drop_13']; } else { $country4 = 0; }
if(isset($_POST['drop_14'])) { $cat4 = $_POST['drop_14'];  } else { $cat4 = 0; }
if(isset($_POST['drop_15'])) { $type4 = $_POST['drop_15']; } else { $type4 = 0; }
if(isset($_POST['drop_16'])) { $unit4 = $_POST['drop_16']; } else { $unit4 = 0; }
if(isset($_POST['drop_16_1'])) { $detail4 = $_POST['drop_16_1']; } else { $detail4 = 0; }

if ($date4!=0){
$year4 = substr($date4,6,4);
$month4 = substr($date4,3,2);
$day4 = substr($date4,0,2);
$date4 = mktime(0, 0, 0, $month4, $day4, $year4);
}

$url4 = $domain.'/'.$folder.'/'.$newfile4;
$thumb4 = $domain.'/'.$folder.'/thumbs/'.$newfile4;
    
$clean_url4 = '/'.$folder.'/'.$newfile4;
$clean_thumb4 = '/'.$folder.'/thumbs/'.$newfile4;     

@$exif_data = exif_read_data($file4, 'EXIF' ,0 );
if (isset($exif_data['Make'])) { 

$shutter4 = calcExposure($exif_data['ExposureTime']).' sec';
$camera4 = $exif_data['Make'];
$model4 = $exif_data['Model'];
$aperture4 = 'f/'.toDecimal($exif_data['FNumber']);
$focal4 = toDecimal($exif_data['FocalLength']).' mm';
$iso4 = 'ISO '.$exif_data['ISOSpeedRatings'];

if(isset($exif_data["GPSLongitude"])) {
$lon4 = getGps($exif_data["GPSLongitude"], $exif_data['GPSLongitudeRef']);
$lat4 = getGps($exif_data["GPSLatitude"], $exif_data['GPSLatitudeRef']);
$lat4 = round($lat4,6); 
$lon4 = round($lon4,6);
}
else
{
$lat4=0;
$lon4=0;
}

}
else
{
	$shutter4 = '';
	$camera4 = '';
	$model4 = '';
	$aperture4 = '';
	$focal4 = '';
	$iso4 = '';
	$lat4 = 0;
	$lon4 = 0;
}	

// check for image dimensions
$size4 = getimagesize($file4);
if ($size4[0] > 1400) {
		//$filecheck1 = "dimension";
		// resize to 1400	
	$sourceImageFilePath = $file4;
	$maxResizeWidth = 1398;
	$maxResizeHeight = 1398;
	$outputPath = $file4;
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
	$result = imagejpeg($imageOutput, $outputPath,100);
	if($result === FALSE) return false; // Error condition
	}
// -----------------------------------------------------------

if ($user !='') {
//removing unfriendly characters
$cleantekst4 = $tekst4;
$tekst4 = addslashes($tekst4);

$query4="INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb, detailID) VALUES ('$url4','$thumb4','$newfile4','$tekst4','$photographer4','$date4','$user','$ip','$type4','$unit4','$camera4','$model4','$shutter4','$aperture4','$iso4','$focal4','$gallery','$lat4','$lon4','$datetime','$clean_url4','$clean_thumb4','$detail4')";
$result4 = mysqli_query($db, $query4);

$antimg=$antimg+1;
}
} // end if user is not empty
} // end if file4 is ok
// ----------- end image 4 --------------

// ---------  image 5 ------------

if ($_FILES['img']['name'][4]!='')
{
$originalfile5 = $_FILES['img']['name'][4];

//removing web-unfriendly characters
$originalfile5 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile5);

$newfile5 = $datetime.'_'.$originalfile5;
$file5 = $indir.$newfile5;
copy($_FILES['img']['tmp_name'][4], $file5); 
// now the file is stored in the incoming-folder

// check for filetype
$filecheck5 = 'false';
if (strtolower(substr($file5, -3)) == 'jpg') {$filecheck5 = 'true';}
if (strtolower(substr($file5, -4)) == 'jpeg') {$filecheck5 = 'true';}

// check for filesize
//if (filesize($file5) > 1024000) { $filecheck5 = "size";}

if ($filecheck5 != 'true')
{ 
  unlink($file5); 
  $antimg = $antimg+1;
}
else
{
if(isset($_POST['photographer5'])) { $photographer5 = $_POST['photographer5']; } else { $photographer5=''; }
if(isset($_POST['tekst5'])) {$tekst5 = $_POST['tekst5']; } else { $tekst5=''; }
if(isset($_POST['date5'])) {$date5 = $_POST['date5']; } else { $date5 = 0; }
if(isset($_POST['drop_17'])) { $country5 = $_POST['drop_17']; } else { $country5 = 0; }
if(isset($_POST['drop_18'])) { $cat5 = $_POST['drop_18'];  } else { $cat5 = 0; }
if(isset($_POST['drop_19'])) { $type5 = $_POST['drop_19']; } else { $type5 = 0; }
if(isset($_POST['drop_20'])) { $unit5 = $_POST['drop_20']; } else { $unit5 = 0; }
if(isset($_POST['drop_20_1'])) { $detail5 = $_POST['drop_20_1']; } else { $detail5 = 0; }

if ($date5!=0){
$year5 = substr($date5,6,4);
$month5 = substr($date5,3,2);
$day5 = substr($date5,0,2);
$date5 = mktime(0, 0, 0, $month5, $day5, $year5);
}

$url5 = $domain.'/'.$folder.'/'.$newfile5;
$thumb5 = $domain.'/'.$folder.'/thumbs/'.$newfile5;
    
$clean_url5 = '/'.$folder.'/'.$newfile5;
$clean_thumb5 = '/'.$folder.'/thumbs/'.$newfile5;     

@$exif_data = exif_read_data($file5, 'EXIF' ,0 );
if (isset($exif_data['Make'])) { 

$shutter5 = calcExposure($exif_data['ExposureTime']).' sec';
$camera5 = $exif_data['Make'];
$model5 = $exif_data['Model'];
$aperture5 = 'f/'.toDecimal($exif_data['FNumber']);
$focal5 = toDecimal($exif_data['FocalLength']).' mm';
$iso5 = 'ISO '.$exif_data['ISOSpeedRatings'];

if(isset($exif_data["GPSLongitude"])) {
$lon5 = getGps($exif_data["GPSLongitude"], $exif_data['GPSLongitudeRef']);
$lat5 = getGps($exif_data["GPSLatitude"], $exif_data['GPSLatitudeRef']);
$lat5 = round($lat5,6); 
$lon5 = round($lon5,6);
}
else
{
$lat5=0;
$lon5=0;
}

}
else
{
	$shutter5 = '';
	$camera5 = '';
	$model5 = '';
	$aperture5 = '';
	$focal5 = '';
	$iso5 = '';
	$lat5 = 0;
	$lon5 = 0;
}	

// check for image dimensions
$size5 = getimagesize($file5);
if ($size5[0] > 1400) {
		//$filecheck1 = "dimension";
		// resize to 1400	
	$sourceImageFilePath = $file5;
	$maxResizeWidth = 1398;
	$maxResizeHeight = 1398;
	$outputPath = $file5;
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
	$result = imagejpeg($imageOutput, $outputPath, 100);
	if($result === FALSE) return false; // Error condition
	}
// -----------------------------------------------------------

if ($user !='') {
//removing unfriendly characters
$cleantekst5 = $tekst5;
$tekst5 = addslashes($tekst5);

$query5="INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb, detailID) VALUES ('$url5','$thumb5','$newfile5','$tekst5','$photographer5','$date5','$user','$ip','$type5','$unit5','$camera5','$model5','$shutter5','$aperture5','$iso5','$focal5','$gallery','$lat5','$lon5','$datetime','$clean_url5','$clean_thumb5','$detail5')";
$result5 = mysqli_query($db, $query5);

$antimg=$antimg+1;
}
} // end if user is not empty
} // end if file4 is ok
// ----------- end image 5 --------------

include ('bo_resize_functions.php');


if ($antimg==0) {
?>
<script>alert('Ikke noe bilde valgt.');</script>
<script>parent.location.href='subpage.php?s=61';</script>
<?php } 

// image 1
if (isset($newfile1)) {
	if ($filecheck1 == 'true')
	{	
	   // create thumb
	   $frafil = $file1;
	   $tilfil = '../'.$folder.'/thumbs/'.$newfile1;
	 include('bo_create_thumb.php');
		
	   //add border
	   $add = $file1;
	   $new_filename = '../'.$folder.'/'.$newfile1;
	   if ($photographer1!='') { $author = $photographer1; } else {$author = '';}
	   if ($date1!='') {$date = date('j.n.Y',$date1); } else { $date = '';}
       if ($tekst1!='') {$text = $cleantekst1; } else { $text = ''; }
     include('bo_add_border.php'); 
     
     unlink($file1);
	}
}
	
	
// image 2
if (isset($newfile2)) {
	if ($filecheck2 == 'true')
	{		
	   // create thumb
	   $frafil = $file2;
	   $tilfil = '../'.$folder.'/thumbs/'.$newfile2;
	 include('bo_create_thumb.php');
		
	   //add border
	   $add = $file2;
	   $new_filename = '../'.$folder.'/'.$newfile2;
	   if ($photographer2!='') { $author = $photographer2; } else {$author = '';}
	   if ($date2!='') {$date = date('j.n.Y',$date2); } else { $date = '';}
       if ($tekst2!='') {$text = $cleantekst2; } else { $text = ''; }
     include('bo_add_border.php');
     
     unlink($file2);  	    
	}
}


// image 3	
if (isset($newfile3)) {
	if ($filecheck3 == 'true')
	{	
	   // create thumb
	   $frafil = $file3;
	   $tilfil = '../'.$folder.'/thumbs/'.$newfile3;
	 include('bo_create_thumb.php');
		
	   //add border
	   $add = $file3;
	   $new_filename = '../'.$folder.'/'.$newfile3;
	   if ($photographer3!='') { $author = $photographer3; } else {$author = '';}
	   if ($date3!='') {$date = date('j.n.Y',$date3); } else { $date = '';}
       if ($tekst3!='') {$text = $cleantekst3; } else { $text = ''; }
     include('bo_add_border.php');  
     
     unlink($file3);
	}
}	


// image 4	
if (isset($newfile4)) {
	if ($filecheck4 == 'true')
	{	
	   // create thumb
	   $frafil = $file4;
	   $tilfil = '../'.$folder.'/thumbs/'.$newfile4;
	 include('bo_create_thumb.php');
		
	   //add border
	   $add = $file4;
	   $new_filename = '../'.$folder.'/'.$newfile4;
	   if ($photographer4!='') { $author = $photographer4; } else {$author = '';}
	   if ($date4!='') {$date = date('j.n.Y',$date4); } else { $date = '';}
       if ($tekst4!='') {$text = $cleantekst4; } else { $text = ''; }
     include('bo_add_border.php');  
     
     unlink($file4);
	}
}	



// image 5	
if (isset($newfile5)) {
	if ($filecheck5 == 'true')
	{	
	   // create thumb
	   $frafil = $file5;
	   $tilfil = '../'.$folder.'/thumbs/'.$newfile5;
	 include('bo_create_thumb.php');
		
	   //add border
	   $add = $file5;
	   $new_filename = '../'.$folder.'/'.$newfile5;
	   if ($photographer5!='') { $author = $photographer5; } else {$author = '';}
	   if ($date5!='') {$date = date('j.n.Y',$date5); } else { $date = '';}
       if ($tekst5!='') {$text = $cleantekst5; } else { $text = ''; }
     include('bo_add_border.php');  
     
     unlink($file5);
	}
}	




?>

<form name="processend" action="subpage.php?s=52" method="post">

<input type="hidden" name="img1" value="<?php if (isset($newfile1)) {echo $newfile1;} ?>" />
<input type="hidden" name="img2" value="<?php if (isset($newfile2)) {echo $newfile2;} ?>" />
<input type="hidden" name="img3" value="<?php if (isset($newfile3)) {echo $newfile3;} ?>" />
<input type="hidden" name="img4" value="<?php if (isset($newfile4)) {echo $newfile4;} ?>" />
<input type="hidden" name="img5" value="<?php if (isset($newfile5)) {echo $newfile5;} ?>" />

<input type="hidden" name="filecheck1" value="<?php if (isset($filecheck1)) {echo $filecheck1;} ?>" />
<input type="hidden" name="filecheck2" value="<?php if (isset($filecheck2)) {echo $filecheck2;} ?>" />
<input type="hidden" name="filecheck3" value="<?php if (isset($filecheck3)) {echo $filecheck3;} ?>" />
<input type="hidden" name="filecheck4" value="<?php if (isset($filecheck4)) {echo $filecheck4;} ?>" />
<input type="hidden" name="filecheck5" value="<?php if (isset($filecheck5)) {echo $filecheck5;} ?>" />

</form>


<script language="javascript" type="text/javascript">
    document.processend.submit();
</script>

