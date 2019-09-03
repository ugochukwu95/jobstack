<?php
	class AdminLogin {
		public $mUsername;
		public $mLoginMessage = '';
		public $mLinkToAdmin;
		public $mLinkToIndex;

		public function __construct() {
			if (isset($_POST['submit'])) {
			    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = '6LfSQqsUAAAAAIk2keHjKoycSrTUN9Qzhq5XnpzB';
				$recaptcha_response = $_POST['recaptcha_response'];

				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				$recaptcha = json_decode($recaptcha);

				if (isset($recaptcha->score) && $recaptcha->score >= 0.5) {
    				if ($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
    					$_SESSION['admin_logged'] = true;
    					header('Location: ' . Link::ToAdmin());
    					exit();
    				}
    				else {
    					$this->mLoginMessage = 'Login failed. Please try again';
    				}
				}
				else {
					$this->mLoginMessage = ':-( Something went wrong. It seems Google thinks your\'re a robot. <u><a href="https://developers.google.com/recaptcha/docs/v3" class="white-text" target="_blank">Find out more</a></u>';
				}
			}
			$this->mLinkToAdmin = Link::ToAdmin();
			$this->mLinkToIndex = Link::ToIndex();
		}
	}
?>