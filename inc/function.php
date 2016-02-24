<?php

require 'imdb/imdb.class.php';

/**
 *
 * Imdb
 *
 */

function vignette($file_name) {

	$oIMDB = new IMDB($file_name);

	if ($oIMDB->isReady) {
	    echo '<a href="view.php?film='.urlencode($file_name).'"><img src="inc/imdb/' . $oIMDB->getPoster('small', true) . '"></a> <h4>About the movie</h4>'; 
	    if ($oIMDB->getSeasons() != "n/A") {
	  		echo '<p>' . $oIMDB->getSeasons() . '</p>';
		}
		echo '<p>' . $oIMDB->getPlot() . '</p>';
	} else {
	  	echo '<p>Movie not found!</p>';
	    echo '<a href="view.php?film='.urlencode($file_name).'"><img src="inc/imdb/posters/not-found.jpg">';
		echo '<h4>'.$file_name.'</h4></a>'; 
	}
}

/**
 *
 * Player
 *
 */

function html($video) {

	$player = '<video class="video" src="files/'.$video.'" controls/>'; //type="'.$mime_type.'"

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

/**
 *
 * choix du player
 *
 */


function choice($choix, $video) {

	if ($choix == '1'){
		//$mime_type = mime_content_type('files/'.$video);
		//html($video, $mime_type);
		return html($video);
	}

	if ($choix == '2'){
		return vlc($video);
	}

	if ($choix == '3'){
		return divx($video);
	}
}

/**
 *
 * download button
 *
 */

function size($video) {

    $bytes = sprintf('%u', filesize('files/'.$video.''));

    if ($bytes > 0) {

        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true) {

            return sprintf('%d %s', $bytes / (1024 ** $unit), $units[$unit]);
        }
    } 

return $bytes;
}

function download($video) {

	$size = size($video);

	$link = '<a download href="files/'.$video.'" data-filesize="'.$size.'" class="download-button">'.$video.'</a>';

return $link;
}