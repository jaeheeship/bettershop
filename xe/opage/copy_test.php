<?php

/*
	$file = "test.xml";
	echo "$file copy start\n";

	if(copy($file, $file.'.bak)){
		echo "$file copy success\n";
	else {
		echo "$file copy falied\n";
	}
	*/

	echo 'this is test=> ';
	$file = 'test.xml';
	echo $file.' copy start';
	
	copy($file, '/var/www/html/xe14/files/cache/blogapi/'.$file.'.bak');
	
	$from = '/var/www/html/xe14/./files/cache/blogapi/jinyong/2883/201210147180.png';
	$to = '/var/www/html/xe14/./files/attach/images/149/739/003/eb7d63f606b773be9c0c2ee6cd971432.png';
	
	copy($from, $to);
	
	// ./files/cache/blogapi/jinyong/2883/201210147180.png</from><to>./files/attach/images/149/739/003/eb7d63f606b773be9c0c2ee6cd971432.png
?>
