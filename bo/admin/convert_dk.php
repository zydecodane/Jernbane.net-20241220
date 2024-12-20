<?php
ini_set('max_execution_time', 600); 

include('../configi.php');

$query = "SELECT message_id, subject FROM phorum_messages where forum_id = 8 and subject like '%-cam%'";
$result = $db->query($query);

$n=0;
while ( $row = $result->fetch_object() ) {
        $message_id[$n] = $row->message_id;
        $subject[$n] = $row->subject;
    
        $newsub[$n] = str_replace('-cam', '', $subject[$n]);
    
    $n++;
}


    
for ($m = 0 ; $m<$n ; $m++) {
    
    
//  echo $message_id[$m]; echo " - "; echo $subject[$m]; echo "<br />";
//  echo $newsub[$m]; echo "<br /><hr />";
    
      $query1 = "update phorum_messages set subject = '$newsub[$m]' where message_id = '$message_id[$m]'";
      $result1 = mysqli_query($db, $query1);
        }


$db->close();
?>