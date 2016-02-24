<?php
	include 'inc/header.php';
	include 'inc/function.php';
	include 'inc/config.php';
?>
<div class="right">
	<form name="player" method="POST">
		Choix du player : 
	        <select name="choixPlayer">
				<option value="1">html</option>
				<option value="2">vlc</option>
				<option value="3">divx</option>
			</select>
			<input type="submit" name="Submit" value="Submit" />
	</form>
</div>

<?php 

	if (isset($_GET['film']) && !empty($_GET['film']) && strlen($_GET['film']) > 4) {

		$video = urldecode($_GET['film']);

		if(isset($_POST['submit'])) {

			if(empty($_POST['choixPlayer'])) {
				$choix = 1;
			}
		}
		$choix;
		$choix = $_POST['choixPlayer'];

		choice($choix, $video);
	}

	if (!isset($_GET['film']) && empty($_GET['film']) || strlen($_GET['film']) < 5) {
		echo '<center>
					<h4>404 Toast / Media Not Found</h4>
					<h4>Go to the <a href="index.php"><u>home page</u></a>.</h4>
				</center>
				<div class="playa"></div>';
		echo '<style type="text/css">
				.right{
					display: none;
				}
			</style>';
	}

include 'inc/footer.php';
?>
