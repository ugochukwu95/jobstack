<?php
// Set the 500 status code
header('HTTP/1.0 500 Internal Server Error');
require_once 'include/config.php';
require_once PRESENTATION_DIR . 'link.php';
$homepage_link = Link::Build('');
echo '
	<!DOCTYPE html>
	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0" media="screen,projection">
			<title>JobStack | Internal Server Error</title>
			<style>
				@font-face {
					font-family: myFirstBold;
					src: url('.$homepage_link.'styles/BebasNeue-Bold.ttf)
				}
				.bebasFont, .brand-logo {font-family: myFirstBold;}
			</style>
			<script src="https://kit.fontawesome.com/4b1f199a47.js" async></script>
		</head>

		<body class="grey-text text-darken-2">
			<div class="row">
				<div class="col s12">
					<h1 class="center">:-(</h1>
					<p class="center"><span class="bebasFont">JOBStack</span> is experiencing technical difficulties</p>
					<p class="center">Please <a href="'.$homepage_link.'" class="red-text text-lighten-2">visit us</a> soon, or <a href="mailto:'.ADMIN_ERROR_MAIL.'" class="red-text text-lighten-2">contact us</a>.
					</p>
					<p class="center">Thank you!</p>
					<p class="center">The <span class="bebasFont">JOBStack</span> team.</p>
					
				</div>
			</div>
			<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
			<script>
			    // Code to activate all Materialize components
				M.AutoInit();
			</script>
		</body>
	</html>
	';
?>
