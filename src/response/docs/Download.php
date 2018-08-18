<?php 
function download($filename){
	$content=@file_get_contents($filename);
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".basename($filename));
	echo $content;
}
?>