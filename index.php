<?php
	include 'inc/header.php';
	include 'inc/function.php';
	include 'inc/config.php';

	foreach($file_type as $ext) {

	   foreach(glob('files/*.'.$ext) as $video) {

	   	$file_name = basename($video);

		    echo '<div class="item-grid">';
		    	echo '<article class="item">';
		    		vignette($file_name);    
				echo '</article>';
	    }
	}
	include 'inc/footer.php';
	
?> 
