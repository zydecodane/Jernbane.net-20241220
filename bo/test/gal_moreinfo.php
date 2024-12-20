<?php
$idx = $_GET['idx'];


//$query4 = "select message_id, forum_id, thread, subject from phorum_messages where body like '%$k_img[1]%' limit 5";
$query4 ="select message_id from phorum_search where search_text like '%$k_img[1]%' limit 5";
$result4 = $db->query($query4);
while ($forum = $result4->fetch_array()) { 
	$query5 = "select forum_id, thread, subject from phorum_messages where message_id = '$forum[0]' ";
	$result5 = $db->query($query5);
	$inlegg = $result5->fetch_array();
	

	
	

$postvogna_rep .= $inlegg[2].'<br />';

/*
$postvogna_rep .= '<a href="read.php?'.$forum[1].','.$forum[2].','.$forum[0].'#msg-'.$forum[0].'" target="_parent" class="galsearch" onfocus="if(this.blur)this.blur()">'.$forum[3].'</a><br />':






?>

<div id="new" style="display: none;">
hejsa<br />
<?php  
echo $idx;
?>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
</div>