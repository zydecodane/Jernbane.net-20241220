<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Jernbane.net</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body> 
<?php
 $position = $_GET['pos'];
?>
<center>
<iframe width="385" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
	src="https://maps.google.com/maps?q=<?php echo $position; ?>&amp;ie=UTF8&amp;t=m&amp;ll=<?php echo $position; ?>&amp;spn=0,0&amp;z=12&amp;output=embed">
	</iframe>
	<br />
	<span style="font-size: 14px; font-family: Tahoma, Arial, Helvetica, sans-serif;">
	
<a href="javascript:opener.location = 'http://maps.google.com/maps?q=<?php echo $position; ?>&amp;ie=UTF8&amp;t=m&amp;ll=<?php echo $position; ?>&amp;z=13&amp;source=embed'; self.close()">Vis st&oslash;rre kart</a>	
	
	

</center>
</body>
</htnl>	