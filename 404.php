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
			<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0" media="screen,projection">
			<title>JobStack | Not Found</title>
			<style>
				@font-face {
					font-family: myFirstBold;
					src: url('.$homepage_link.'styles/BebasNeue-Bold.ttf)
				}
				.bebasFont, .brand-logo {font-family: myFirstBold;}
			</style>
		</head>

		<body class="grey-text text-darken-2">
			<div class="row">
				<div class="col s12">
					<h1 class="center">:-(</h1><br><br>
					<h5 class="center">The page that you have requested doesn\'t exist on <span class="bebasFont">JOBStack</span></h5>
					<p class="center">Please check for more jobs <a href="'.$homepage_link.'" class="red-text text-lighten-2">here</a>, or <a href="mailto:'.ADMIN_ERROR_MAIL.'">contact us</a> if you need further assistance.
					</p>
					<p class="center">Thank you!</p>
					<p class="center">The <span class="bebasFont">JOBStack</span> team.</p>
					
				</div>
			</div>
			<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
			<script src="https://kit.fontawesome.com/4b1f199a47.js" async></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
			<script>
			    // Code to activate all Materialize components
				M.AutoInit();
			</script>
		</body>
	</html>
	';
?>
