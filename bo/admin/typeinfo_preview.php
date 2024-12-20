<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Typeinfo forh&aring;ndsvisning</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/* Skip this until jernbane.net supports setting <base> tag
   $http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'? "https://" : "http://";

   $url = $http . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
   
   //$rooturl =  substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['REQUEST_URI'], "/")+1);
   $rooturl = preg_replace("/typeinfo_preview.*$/", "..", $url);

   echo '<base href="'.$rooturl.'" >' ;
 */
?>

<link type="text/css" href="../stylesheet.css" rel="stylesheet" />
<link type="text/css" href="style.css?v=2" rel="stylesheet" />
    
</head>
<body>
<?php
include('configi.php');
include ('../typeinfo_view.php');
if (isset($_GET['t'])) { $typeid = $_GET['t']; } else { $typeid = NULL; }

if($typeid) {

    $query = "select typename, katid, info, infostruct, info_deleted from gal_type where typeid = '$typeid'";
    $result = $db->query($query);
    $type = $result->fetch_array();
//var_dump($type[3]);echo "<br>";
//var_dump($type[2]);echo "<br>";
?>
		<div class="gal_heading">
			<?php echo $type[0]; ?>
	</div>
    <div class="gal_content">
	<div id="gal_typeinfo" style="background-color: #ffffff; padding-left: 5px;">
            
<?php
    echo dbTypeInfoToHtml($type[3]); ?>
        </div>
</div>

<?php
} else {
    echo "ERROR: Ingen typeid";
}

?>
        </div>
</div>
</body>
</html>