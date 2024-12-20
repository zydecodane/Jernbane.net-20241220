<html>
<body style="background-color: #FFFFCC;">
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp; Ett &oslash;yeblikk...

<?php


include('configi.php');

if (isset($_POST['id'])) {$id=$_POST['id'];} else { $id='';}
if (isset($_POST['tekst'])) {$tekst=$_POST['tekst'];} else {$tekst = '';}
if (isset($_POST['poeng'])) {$poeng=$_POST['poeng'];} else {$poeng = '1';}

// get the userid from the cookie

// get user
$userid=0;
$isadmin=0;

// check if user is logged in - find user in cookie
if (isset($_COOKIE["bbuserid"]))
{ $loggedin = 1;} else {$loggedin = 0;}
// get users real name and admin/notadmin from database

$userid = $_COOKIE["bbuserid"];
include ('configi.php');

$dbase2 =  'jernbane_net_db_forum';		
$db2 = new mysqli($dbserver, $dbuserid, $dbpw, $dbase2);
$db2->set_charset("utf8");
$username = $db2->query("select displayname from user where userid = '$userid'")->fetch_object()->displayname;


$query = "select url, clean_url from gal_images where id = '$id'";
$url = $db->query($query)->fetch_object()->url;
$clean_url = $db->query($query)->fetch_object()->clean_url;

//removing unfriendly characters
$tekst = addslashes($tekst);

// pornofilter start
if ((preg_match("/poker/i", $tekst)) || (preg_match("/casino/i", $tekst)) || (preg_match("/http/i", $tekst)) || (preg_match("/@/i", $tekst)) || (preg_match("/href/i", $tekst))) {
   $check = 0;
} else {
   $check = 1;
}
// pornofilter end

//$query = "select real_name from phorum_users where user_id = '$userid'";
//$user = $db->query($query)->fetch_object()->real_name;

$user = $username;

if ($user=='') {$check=0;}

// if everything is ok

if ($check==1)
{
$ok=1;

$dato = date('U');
$ip = $_SERVER['REMOTE_ADDR'];

// check whether the user trys to vote for his own picture

$query = "select bruker from gal_images where id = '$id'";
$author = $db->query($query)->fetch_object()->bruker;

$imgauthor = substr($author,0,strpos($author,' -'));

if ($imgauthor == $userid) {
 $ok = 0;
?>
 <script type="text/javascript"> alert('Du kan ikke stemme p\u00E5 ditt eget bilde. '); </script>
 <script type="text/javascript">parent.TINY.box.hide();</script>;
<?php
}
 else {

        // check whether this user har voted for this picture before
        
        $query = "select user_id from gal_comments where url = '$url' and user_id = '$userid'";
		@$check = $db->query($query)->fetch_object()->user_id;
        
        if (isset($check)) {
                               $ok=0;
                               ?>
                           <script type="text/javascript">alert('Du har allerede stemt p\u00E5 dette bildet. '); </script>
                           <script type="text/javascript">parent.TINY.box.hide();</script>;
                          <?php
                               }
      }

        if ($ok==1)
        {
        	$query = "INSERT INTO gal_comments (url, tekst, poeng, bruker, dato, ip, user_id, clean_url) VALUES ('$url','$tekst','$poeng','$user','$dato','$ip','$userid','$clean_url')";
        	$result = mysqli_query($db, $query);
        	
        	$query = "UPDATE gal_images SET poeng=poeng+'$poeng' WHERE id='$id'";
        	$result = mysqli_query($db, $query);
        	
        	$query = "UPDATE gal_images SET stemmer=stemmer+1 WHERE id='$id'";
        	$result = mysqli_query($db, $query);
        ?>
        <script type="text/javascript">alert('Din stemme er registrert.');</script>;
        <script type="text/javascript">parent.TINY.box.hide();</script>;
        <?php
        }

}
?>
</body>
</html>