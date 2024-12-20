<?php
 $dir=$_POST['dir'];
 $fil=$_POST['fil'];

$newurl = '../../'.$dir.'/'.$fil;

unlink ($newurl) ;

echo "<script>parent.location.href='../../filelist.php?d=".$dir."'</script>";


?>