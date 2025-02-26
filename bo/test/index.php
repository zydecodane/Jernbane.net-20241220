<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TinyBox2 - JavaScript Modal Windows</title>

<script type="text/javascript" src="tinybox.js"></script>
</head>
<body>
<style>
.tbox {position:absolute; display:none; padding:14px 17px; z-index:900}
.tinner {padding:15px; -moz-border-radius:5px; border: 4px solid maroon; background:#fff url(images/preload.gif) no-repeat 50% 50%;}
.tmask {position:absolute; display:none; top:0px; left:0px; height:100%; width:100%; background:#000; z-index:800}
.tclose {position:absolute; top:0px; right:0px; width:30px; height:30px; cursor:pointer; background:url(images/close.png) no-repeat}
.tclose:hover {background-position:0 -30px}

#error {background:#ff6969; color:#fff; text-shadow:1px 1px #cf5454; border-right:1px solid #000; border-bottom:1px solid #000; padding:0}
#error .tcontent {padding:10px 14px 11px; border:1px solid #ffb8b8; -moz-border-radius:5px; border-radius:5px}
#success {background:#2ea125; color:#fff; text-shadow:1px 1px #1b6116; border-right:1px solid #000; border-bottom:1px solid #000; padding:10; -moz-border-radius:0; border-radius:0}
#bluemask {background:#4195aa}
#frameless {padding:0}
#frameless .tclose {left:6px}


</style>



<li onclick="TINY.box.show({url:'../voteform.php',width:600,height:410})" style="cursor:pointer;">voteform</li>
</div>
</body>
</html>