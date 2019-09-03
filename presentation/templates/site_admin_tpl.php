<?php
	require_once PRESENTATION_DIR . 'site_admin.php';
	$site_admin = new SiteAdmin();
	$site_admin->init();

echo '
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" media="screen,projection">
		<link rel="stylesheet" href="'.$site_admin->mSiteUrl.'styles/jobstack-styles.css">
		<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<title>Jobstack Admin</title>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/4b1f199a47.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	</head>

	<body class="grey-text text-darken-2">
	<header>'; 
	require_once $site_admin->mMenuCell;
	echo '
	</header>

	<main>
		';
	require_once $site_admin->mContentCell;
	echo '
	</main>
	<script>
		$(".openSearchNav").click(function(event) {
			event.preventDefault();
			$("#mySidenav").removeClass("scale-out").addClass("scale-in");
		});

		$(".closeNav").click(function(event) {
			event.preventDefault();
			$("#mySidenav").removeClass("scale-in").addClass("scale-out");
		});
		// Code to activate all Materialize components
		M.AutoInit();

	</script>
	</body>
	</html>
';
?>