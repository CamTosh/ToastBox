<?php

require 'imdb/imdb.class.php';

/**
 *
 * Scan folder
 *
 */

function scan($path, $video_type) {

	echo '<div class="item-grid">';

	foreach($video_type as $ext) {
		
	   foreach(glob(''.$path.'/*.'.$ext.'') as $video) {

	   		$file_name = basename($video);
			$slash = 1;
		    vignette($file_name, $slash);    
	    }
	    foreach(glob(''.$path.'/*/*.'.$ext.'') as $video) {

	   		$file_name = basename($video);
		    $slash = 2;
		    vignette($file_name, $slash);    
	    }
	    foreach(glob(''.$path.'/*/*/*.'.$ext.'') as $video) {

	   		$file_name = basename($video);
		    $slash = 3;
		    vignette($file_name, $slash);    
	    }
	}
	echo '</div>';
}

/**
 *
 * Imdb
 *
 */

function vignette($file_name, $slash) {

		if ($slash == 1) {
			echo '<li><a href="view.php?film='.urlencode($file_name).'"><h4><span class="icono-home" style="color:black;"></span> '.$file_name.'</h4></a></li><hr>';
		}
		if ($slash == 2) {
			echo '<li><a href="view.php?film='.urlencode($file_name).'"><h4><span class="icono-folder" style="color:black;"></span> '.$file_name.'</h4></a></li><hr>';
		}
		if ($slash == 3) {
			echo '<li><a href="view.php?film='.urlencode($file_name).'"><h4><span class="icono-folder" style="color:black;"></span><span class="icono-folder" style="color:black;"></span> '.$file_name.'</h4></a></li><hr>';
		}
}

/**
 *
 * Player
 *
 */

function html($video) {

	$player = '<video class="video" src="files/'.$video.'" controls></video>'; //type="'.$mime_type.'"

return $player;
}

function vlc($video) {

	$player = '<object class="video" classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab">
		        <embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2" pluginspage="http://www.videolan.org" target="files/'.$video. '" name="vlc" />
		    </object>';
return $player;
}

function divx($video) {

	$player = '<object class="video" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">
			    <param name="custommode" value="none" />
			    <param name="previewImage" value="" />
			    <param name="autoPlay" value="false" />
			    <param name="src" value="files/'.$video.'" />
			    <embed src="files/'.$video.'" 
			        type="video/divx" 
			        custommode="none" 
			        autoPlay="false" 
			        pluginspage="http://go.divx.com/plugin/download/">
			    </embed>
			</object>';
return $player;
}

/*----------  Description  ----------*/

function desc($video) {

	$oIMDB = new IMDB($video);
	echo '<div class="description"><h1>About '.$video.' ('.$oIMDB->getYear().')</h1>'.$oIMDB->getPlot().'</div>';
}

/**
 *
 * choix du player
 *
 */

function choice($choix, $video) {

	if ($choix == '1') {
		//$mime_type = mime_content_type('files/'.$video);
		//html($video, $mime_type);
		return html($video);
	}

	if ($choix == '2') {
		return vlc($video);
	}

	if ($choix == '3') {
		return divx($video);
	}
}

/**
 *
 * download button
 *
 */

function size($path, $video) {

    $bytes = sprintf('%u', filesize(''.$path.'/'.$video.''));

    if ($bytes > 0) {

        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true) {

            return sprintf('%d %s', $bytes / (1024 ** $unit), $units[$unit]);
        }
    } 

return $bytes;
}

function download($path, $video) {

	$size = size($path, $video);

	$link = '<a download href="'.$path.''.$video.'" data-filesize="'.$size.'" class="download-button">'.$video.'</a>';

return $link;
}

/**
 *
 * Convert
 *
 */

function convert($video, $path, $convertDir) {

	$fichier = explode(".", $video); 

	if (is_file($path . $video)){
		shell_exec("ffmpeg -i " . $path . $video . " -c:v libx264 -c:a libfaac -b:a 192k " . $convertDir . $fichier[0] . ".mp4");
	}
	if (is_file($convertDir . $fichier[0] . ".mp4")) {
		echo '<video class="video" type="video/mp4" src="files/'.$convertDir . $fichier[0].'.mp4" controls></video>';
	}
}
