 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link type="text/css" href="../stylesheet.css" rel="stylesheet" >

<title></title>
</head>
<body style="margin-left: 40px;">
    <?php

 $url=$_GET['url'];
 $dir=$_GET['dir'];

$slashpos = strrpos($url, "/");
$newfile = substr($url, ($slashpos+1));

?>

<br /><br />
<form name="del" method="post" action="filelist_del_do.php" OnSubmit="return confirm('Er du helt sikker p\u00E5 at du vil slette dette bildet?');">
         <input type="hidden" name="fil" value="<?php echo $newfile ?>">
         <input type="hidden" name="dir" value="<?php echo $dir ?>">
         <input type="submit" value="slet bildet" style="width: 250px; text-align: left;">
        </form>

<br />
<br />
<img src="<?php echo $url; ?>" />
 <br />
<br />
</body>   
</html>
