<?php
$file_name = $_GET["file"];
$file_url = 'http://localhost/montoya/assets/public/'.$file_name;
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url);

?>