<?php
include('configi.php');
// user-check
if(isset($_POST['cookie'])) {$cookie = $_POST['cookie']; } else { $cookie=''; }
if ($cookie == '1') {
	if(isset($_POST['userid'])) {$userid = $_POST['userid']; } else { $userid=''; }
	}
else
{
if(isset($_POST['username'])) {$username = $_POST['username']; } else { $username=''; }
if(isset($_POST['password'])) {$password = $_POST['password']; } else { $password=''; }

$cpassword = md5($password); // Encrypted Password
}

if(isset($_POST['userid'])) {$userid = $_POST['userid']; } else { $userid=''; }
if(isset($_POST['forum'])) {$forum1 = $_POST['forum']; } else { $forum1='11'; }
if(isset($_POST['date1'])) {$date1 = $_POST['date1']; } else { $date1=''; }
if(isset($_POST['bildetekst'])) {$tekst1 = $_POST['bildetekst']; } else { $tekst1=''; }
if(isset($_POST['forumhead'])) {$forumhead = $_POST['forumhead']; } else { $forumhead=''; }
if(isset($_POST['forumbody'])) {$forumbody = $_POST['forumbody']; } else { $forumbody=''; }
if(isset($_POST['drop_1'])) { $country1 = $_POST['drop_1']; } else { $country1 = 0; }
if(isset($_POST['drop_2'])) { $cat1 = $_POST['drop_2']; }  else { $cat1 = 0; }
if(isset($_POST['drop_3'])) { $type1 = $_POST['drop_3']; } else { $type1 = 0; }
if(isset($_POST['drop_4'])) { $unit1 = $_POST['drop_4']; } else { $unit1 = 0; }
if(isset($_POST['fotograf'])) { $fotograf = $_POST['fotograf']; } 

$date = $date1;

if ($date1 != '')
	{
		$dd = substr($date1,0,2);
		$dm = substr($date1,3,2);
		$dy = substr($date1,6,4);
		$udate = mktime(12, 0, 0, $dm, $dd, $dy);
	}
else {$udate = '';}	

if ($cookie == '0') {
$query = "select user_id from phorum_users where username = '$username' and password = '$cpassword'";
@$result = $db->query($query)->fetch_object()->user_id;

if (isset($result)) {$userid = $result;}

?>
<form name="back" action="index.php" method="post">
	<input type="hidden" name="username" value="<?php echo $username; ?>" />
	<input type="hidden" name="password" value="<?php echo $password; ?>" />
 	<input type="hidden" name="forum" value="<?php echo $forum1; ?>">
 	<input type="hidden" name="bildetekst" value="<?php echo $tekst1; ?>" />
 	<input type="hidden" name="forumhead" value="<?php echo $forumhead; ?>" />
	<input type="hidden" name="forumbody" value="<?php echo $forumbody; ?>" /> 
</form>
<?php

if (!isset($result))
{
 echo '<script type="text/javascript">alert("Feil brukernavn/passord");</script>';
 echo '<script type="text/javascript">document.back.submit();</script>';
}
} else {
	$result=$userid;
	}
 // end if no cookie
if (isset($result)) // user/password-combination is valid
{
// end user-check

// strart file-check
if ($_FILES['img']['name'][0]=='')  // no file
{
  echo '<script type="text/javascript">alert("Ikke noe bilde valgt");</script>';
  
  echo '<script type="text/javascript">parent.location.href="subpage.php?s=54";</script>';
	
}
else
{
$indir = '../incoming/';	
$datetime = date('U');
	
$originalfile1 = $_FILES['img']['name'][0];

//removing web-unfriendly characters
$originalfile1 = preg_replace('`[^a-z0-9-_.]`i','_',$originalfile1);

$newfile1 = $datetime.'_'.$originalfile1;
$file1 = $indir.$newfile1;

copy($_FILES['img']['tmp_name'][0], $file1); 
// now the file is stored in the incoming-folder

// check for filetype
$filecheck1 = 'false';
if (strtolower(substr($file1, -3)) == 'jpg') {$filecheck = 'true';}
if (strtolower(substr($file1, -4)) == 'jpeg') {$filecheck = 'true';}

if ($filecheck != 'true')
{
	echo '<script type="text/javascript">alert("filtypen ikke tillatt");</script>';
  	echo '<script type="text/javascript">document.back.submit();</script>';
}
else
{
// everything ok

$query = "SELECT data FROM `phorum_settings` WHERE name = 'http_path'";
$httppath = $db->query($query)->fetch_object()->data;

$domain = substr($httppath,0,strrpos($httppath,'/'));

$query="SELECT var FROM `gal_variables` WHERE name = 'upload_folder'";
$folder = $db->query($query)->fetch_object()->var;

$query="SELECT real_name FROM `phorum_users` WHERE user_id = '$userid'";
$realname = $db->query($query)->fetch_object()->real_name;
$photographer1 = $realname;

if (isset($_POST['user'])) {$user = $_POST['user'];}
$ip = $_SERVER['REMOTE_ADDR'];

include('../bo/bo_exif_functions.php');
include ('../bo/bo_resize_functions.php');

$author = $realname;
$text = $tekst1;
// $date1 = date('U');
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
//removing unfriendly characters
$cleantekst1 = $tekst1;
// $tekst1 = addslashes($tekst1);	

$tekst1 = $db->real_escape_string($tekst1);

// check for orientation and rotate ----------------------------------

 $exif = exif_read_data($file1);
 if(isset($exif['Orientation'])) {
 	if ($exif['Orientation'] == '3') {
 		$source = imagecreatefromjpeg($file1);
   		$rotate = imagerotate($source, 180, 0);
		imagejpeg($rotate,$file1);	
 		 }
 	if ($exif['Orientation'] == '6') {
 		$source = imagecreatefromjpeg($file1);
   		$rotate = imagerotate($source, -90, 0);
		imagejpeg($rotate,$file1);
 		}
 	if ($exif['Orientation'] == '8') {
 		$source = imagecreatefromjpeg($file1);
   		$rotate = imagerotate($source, 90, 0);
		imagejpeg($rotate,$file1);
 		}
}

// end orientation ----------------------------------------
// check image dimensions  ---------------------------------------------

$size1 = getimagesize($file1);
if ($size1[0] > 1200) {
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
}


// end resize ---------------------------------------------
// create thumb
  $frafil = $file1;
  $tilfil = '../'.$folder.'/thumbs/'.$newfile1;
  include('../bo/bo_create_thumb.php');

//add border
  $add = $file1;
  $new_filename = '../'.$folder.'/'.$newfile1;

// add_border bruger $author, men author btuges også til indlægget. Derfor sætter vi $author tilbage npår border er added 

 
  if ($photographer1!='') { $author = $photographer1; } else {$author = '';}
  if (isset($fotograf)) {$author = $fotograf; $photographer1 = $fotograf;} 
  // if ($date1!='') {$date = date('j.n.Y',$date1); } else { $date = '';}
  if ($tekst1!='') {$text = $cleantekst1; } else { $text = ''; }
  include('../bo/bo_add_border.php'); 

$author = $realname; // $autgor sættes tilbage

unlink($file1);    
// end processing image
// write image to database
$user = $userid." - ".$realname;

$query = "INSERT INTO gal_images (url, thumb, navn, tekst, fotograf, dato, bruker, ip, type, nummer, kamera, kameramodel, lukkertid, blender, iso, focal, posthylla, latitude, longitude, timestamp, clean_url, clean_thumb) VALUES ('$url1','$thumb1','$newfile1','$tekst1','$photographer1','$udate','$user','$ip','$type1','$unit1','$camera1','$model1','$shutter1','$aperture1','$iso1','$focal1','0','$lat1','$lon1','$datetime','$clean_url1','$clean_thumb1')";
$result = mysqli_query($db, $query); 

// write message to Phorum
$query = "SELECT signature FROM `phorum_users` WHERE user_id = '$userid'";
$signature = $db->query($query)->fetch_object()->signature;

if ($signature =='') {$signature = "Vennlig hilsen<br />".$author;}


$body = $forumbody."<br /><br />[img]".$url1."[/img]<br /><br />".$signature;
$searchtext = $forumbody."<br /><br />[img]".$url1."[/img]";


$query = "SELECT MAX(message_id) FROM `phorum_messages` AS max_id";
$result = $db->query($query);
while ( $galliste = $result->fetch_array() ) {
    $next_id = $galliste[0]+1; 
     } 

$forumhead = $db->real_escape_string($forumhead);
$body = mysqli_real_escape_string($db, $body);
$photographer1 = mysqli_real_escape_string($db, $photographer1);

$query = "INSERT INTO phorum_messages (forum_id, thread, user_id, author, subject, body, ip, status, modifystamp, thread_count, sort, datestamp, meta, recent_message_id, recent_user_id, recent_author) VALUES ('$forum1', '$next_id', '$userid', '$author', '$forumhead', '$body', '$ip', '2', '$datetime', '1', '2', '$datetime', 'a:0:{}', '$next_id', '$userid', '$photographer1')";
$result = mysqli_query($db, $query);

$searchtext = $photographer1." | ".$forumhead." | ".$searchtext;

$query = "INSERT INTO phorum_search (message_id, forum_id, search_text) VALUES ('$next_id','$forum1', '$searchtext')";
$result = mysqli_query($db, $query);
$query = "UPDATE phorum_forums SET message_count=message_count+1 where forum_id = '$forum1'";
$result = mysqli_query($db, $query);
$query = "UPDATE phorum_forums SET thread_count=thread_count+1 where forum_id = '$forum1'"; 
$result = mysqli_query($db, $query);
$query = "UPDATE phorum_forums SET lats_post_time = '$datetime' where forum_id = '$forum1'";
$result = mysqli_query($db, $query);

// send user to his forum-post
$link = "../phorum/read.php?".$forum1.",".$next_id.",".$next_id."#msg-".$next_id;
echo '<script type="text/javascript">parent.location.href="'; echo $link; echo '";</script>';
	
} // file ok	
} // file ok
} // user ok


