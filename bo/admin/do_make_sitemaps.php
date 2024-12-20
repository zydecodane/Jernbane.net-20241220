<?php
$loc = "/var/www/jernbane.net/public_html";
$output = shell_exec('/bin/sh '.$loc.'/bo/admin/make_sitemaps.sh');
//echo "Sitemaps generated: ".$output;
?>
