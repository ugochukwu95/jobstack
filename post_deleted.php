<?php
// Set the 404 status code
header('HTTP/1.0 404 Not Found');
require_once 'include/config.php';
require_once PRESENTATION_DIR . 'link.php';
$homepage_link = Link::Build('');
echo '
	<!DOCTYPE html>
	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="'.$homepage_link.'styles/materialize.min.css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0" media="screen,projection">
			<link rel="stylesheet" href="'.$homepage_link.'styles/fontawesome-free-5.8.1-web/css/all.css">
			<title>JobStack | Not Found</title>
			<style>
				@font-face {
					font-family: myFirstBold;
					src: url('.$homepage_link.'styles/BebasNeue-Bold.ttf)
				}
				.bebasFont, .brand-logo {font-family: myFirstBold;}
			</style>
		</head>

		<body class="grey lighten-4">
			<div class="row">
				<div class="col s12">
					<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
					<h5 class="center grey-text text-darken-2">This post doesn\'t exist anymore or you have blocked this user</h5>
				</div>
			</div>
			<script type="text/javascript" src="'.$homepage_link.'styles/materialize.min.js"></script>
			<script type="text/javascript" src="'.$homepage_link.'styles/jquery.min.js"></script>
			<script>
			    // Code to activate all Materialize components
				M.AutoInit();
			</script>
		</body>
	</html>
	';
?>
