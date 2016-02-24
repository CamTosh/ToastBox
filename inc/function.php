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
	echo '<video class="video" src="files/'.$video.'" controls/>'; //type="'.$mime_type.'"
}

function vlc($video) {
	echo '<object class="video" classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab">
		        <embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2" pluginspage="http://www.videolan.org" target="files/'.$video. '" name="vlc" />
		    </object>';
}

function divx($video) {
	echo '<object class="video" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">
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
}

function choice($choix, $video) {
	if ($choix == '1'){
		//$mime_type = mime_content_type('files/'.$video);
		//html($video, $mime_type);
		html($video);
	}

	if ($choix == '2'){
		vlc($video);
	}

	if ($choix == '3'){
		divx($video);
	}
}