<?php

           # Connect to DB
           include('../configi.php');
		$db = new mysqli($dbserver, $dbuserid, $dbpw, $dbase);
           # SQL Statement
           $sql = "SELECT `file_data` FROM `phorum_files` WHERE file_id = 48";
           
		   $result = $db->query($sql)->fetch_object()->file_data;

           ob_clean();

// simple test image
header("Content-type: image/gif");

         
		echo(stripslashes($result));?>