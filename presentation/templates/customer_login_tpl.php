<?php
	require_once PRESENTATION_DIR . 'customer_login.php';
	$customer_login = new CustomerLogin();
	$customer_login->init();
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
		<div class="container section containerRegisterLogin">
			<div class="row">
				<div class="col s12">';
					if (!is_null($customer_login->mErrorMessage)) {
						echo '
						<div style="padding:20px;margin-bottom:15px;border-radius:4px;" class="alert white-text red lighten-3">
							<p class="errorText center">'.$customer_login->mErrorMessage.'</p>
						</div>';
					}
					echo '
					<div class="row">
						<div class="col s12 l8 offset-l2">
    	                    <div class="card white">
    	                        <div class="card-content">
    	                            <p class="center"><img src="'.$customer_login->mLinkToLogo.'" class="responsive-img" style="" alt="join-our-community"></p>
    	                            <p class="grey-text text-darken-2">Join our community to be able to create posts, like and comment on already created posts amongst other 
    	                            wonderful features.</p>
    	                            <br>
    	                            <p class="grey-text text-darken-2">For example, the "<i class="fas fa-hashtag"></i>" you see on the job boards lets you
    	                             say what you think of that particular job posting. Is the pay good? Are the staff helpful and kind?</p>
    	                        </div>
    	                    </div>
    	                </div>
					</div>
				</div>
			</div>
			<div class="row">
				<form class="col s12" method="post" action="'.$customer_login->mLinkToLogin.'">
				<div class="row">
					<div class="col s12">
						<ul class="tabs">
							<li class="tab col s6 m6 l6"><a href="#login">Login</a></li>
							<li class="tab col s6 m6 l6"><a href="#register">Register</a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div id="login" class="col s12">
					<div class="card white">
		                <div class="card-content grey-text text-darken-2">
						<div class="row">
							<div class="input-field col s12">
								<input placeholder="ie: johndoe@example.com" id="login_email" name="login_email" type="email" class="validate" value="'.$customer_login->mEmail.'" data-length="50">
								<label for="login_email">Email</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="login_password" type="password" name="login_password" class="validate" data-length="50">
								<label for="login_password">Password</label>
							</div>
						</div>
						<p class="white-text">
							<button type="submit"  name="Login" value="" class="red lighten-2 btn waves-effect waves-light">Login</button>
						</p>
						</div>
					</div>
					</div>
				</div>
				<div class="row">
					<div id="register" class="col s12">
					<div class="card white">
		                <div class="card-content grey-text text-darken-2">
						<div class="row">
							<div class="input-field col s12">
								<input placeholder="ie: johndoe@exaample.com" id="register_email" type="email" class="validate" name="register_email" value="">
								<label for="register_email">Email Address</label>
								<span class="helper-text">Important</span>';
							echo '
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="register_password" type="password" data-length="50" name="register_password" class="validate" data-length="50">
								<label for="register_password">Password</label>
								<span class="helper-text">Important Must be at least 8 characters in length, have at least an upper case letter, a number, and a special character [eg: !,@,#,$,%,^,&,*,...].</span>
							</div>
							<script>
								$("input#register_password").characterCounter();
							</script>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input placeholder="ie: King_Ugo" id="register_handle" type="text" class="validate" name="register_handle" value="">
								<label for="register_handle">Unique Handle</label>';
							echo '
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input placeholder="ie: Ugochukwu Oguejiofor" id="register_full_name" type="text" class="validate" name="register_full_name" value="">
								<label for="register_full_name">Real Name</label>
							</div>
						</div>
						<p class="white-text">
							<button type="submit" name="Register" class="white-text red lighten-2 btn waves-effect waves-light">Register</button>
						</p>
						</div>
					</div>
					</div>
				</div>
				<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
				</form>
			</div>
		</div>
	';

?>