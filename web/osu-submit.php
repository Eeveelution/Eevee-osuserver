<?php
	$json1 = json_encode($_POST);
	$json2 = json_encode($_GET);
	
	$file1 = fopen("post.txt", "w");
	fwrite($file1, $json1);
	fclose($file1);
	
	$file2 = fopen("get.txt", "w");
	fwrite($file2, $json2);
	fclose($file2);
	
?>