<html>
<body style="background-color: #FFFFCC;">

<?php


include('config.php');

if (isset($_POST['id'])) {$id=$_POST['id'];} else { $id='';}
if (isset($_POST['url'])) {$url=$_POST['url'];} else { $url='';}
// if (isset($_POST['user'])) {$user=$_POST['user'];} else { $user=''; }
if (isset($_POST['userid'])) {$userid=$_POST['userid'];} else { $userid='';}
if (isset($_POST['tekst'])) {$tekst=$_POST['tekst'];} else {$tekst = '';}
if (isset($_POST['vote'])) {$poeng=$_POST['vote'];} else {$poeng = '1';}

//removing unfriendly characters
$tekst = addslashes($tekst);

// pornofilter start

if ((preg_match("/poker/i", $tekst)) || (preg_match("/casino/i", $tekst)) || (preg_match("/http/i", $tekst)) || (preg_match("/@/i", $tekst)) || (preg_match("/href/i", $tekst))) {
   $check = 0;
} else {
   $check = 1;
}

// pornofilter end

$getuser=mysql_query("SELECT real_name FROM phorum_users WHERE user_id = '$userid'");
@$user=mysql_result($getuser,0);


if ($user=='') {$check=0;}

// if everything is ok

if ($check==1) 
{

$dato = date('U');
$ip = $ip = $_SERVER['REMOTE_ADDR'];

// check whether this user har voted for this picture before

$getcheck=mysql_query("SELECT user_id FROM gal_comments WHERE url = '$url' AND user_id = '$userid'");
$check=mysql_fetch_row($getcheck);

if (isset($check[0])) {$ok=0;} else {$ok=1;}

if ($ok==1)
{
mysql_query ("INSERT INTO gal_comments (url, tekst, poeng, bruker, dato, ip, user_id) VALUES ('$url','$tekst','$poeng','$user','$dato','$ip','$userid')");
mysql_query ("UPDATE gal_images SET poeng=poeng+'$poeng' WHERE id='$id'");
mysql_query ("UPDATE gal_images SET stemmer=stemmer+1 WHERE id='$id'");
}
else
{
?>
 <script type="text/javascript">
  alert('Du har allerede stemt p\u00E5 dette bildet. ');
 </script>
<?php
}

}
else // something is not ok
{
?>
<script type="text/javascript">alert('not allowed !');
</script>

<?php
}



 echo "et &oslash;jeblik ...";
 echo "<script>parent.location.href='subpage.php?s=0&id="; echo $id; echo"'</script>";
?>
</body>
</html>
