<?php
	$file = fopen("get.txt", "w");
	fwrite($file, json_encode($_GET));
	fclose($file);
	
	$file1 = fopen("post.txt", "w");
	fwrite($file1, json_encode($_POST));
	fclose($file1);
	
	echo "http://osu.ppy.sh/";
?>