<?php
	require_once PRESENTATION_DIR . 'admin_login.php';
	$admin_login = new AdminLogin();

	echo '
	<script src="https://www.google.com/recaptcha/api.js?render=6LfSQqsUAAAAAAW5zFnZetn1eGuqtCI24yfuWsXr"></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute("6LfSQqsUAAAAAAW5zFnZetn1eGuqtCI24yfuWsXr", {action: "contact"}).then(function(token) {
				var recaptchaResponse = document.getElementById("recaptchaResponse");
				recaptchaResponse.value = token;
			});
		});
	</script>
	<div class="container section">
		<div class="row">
			<div class="col s12 l8 offset-l2">
				<div class="card white">
					<div class="card-content black-text">
						<span class="card-title teal-text text-darken-1">Admin Login </span>';
						if ($admin_login->mLoginMessage != '') {
							echo '<p class="red-text">'.$admin_login->mLoginMessage.'</p>';
						}
						echo '
						<div class="row">
							<form class="col s12" method="post" action="'.$admin_login->mLinkToAdmin.'">
								<div class="row">
									<div class="input-field col s12">
										<input id="Username" type="text" name="username">
										<label for="Username">Username</label>
									</div>
									<div class="input-field col s12">
										<input id="password" type="password" name="password">
										<label for="password">Password</label>
									</div>
								</div>
								<input type="submit" class="center waves-effect waves-light btn" name="submit" value="Login" />
								<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	';
?>