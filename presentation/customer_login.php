<?php
	class CustomerLogin {
		public $mErrorMessage;
		public $mLinkToLogin;
		public $mEmail = '';
		public $mPassword = '';
		public $mHandle = '';
		public $mFullName = '';
		public $mLinkToContinueBrowsing;
		public $mLinkToLogo;
		public $mLinkToCommunityImage;
		
		public function __construct() {
			$this->mLinkToLogin = Link::ToLoginPage();
			$this->mLinkToLogo = Link::ToWebsiteLogo();
			$this->mLinkToCommunityImage = Link::Build('images/website_images/join-our-communty.jpg');
		}

		public function init() {

			if (isset($_SESSION['link_to_continue_browsing'])) {
				$continue_browsing = Link::QueryStringToArray($_SESSION['link_to_continue_browsing']);

				$page = 1;


				if (isset($continue_browsing['Page'])) {
					$page = $continue_browsing['Page'];
				}

				if (isset($continue_browsing['JobId'])) {
					$this->mLinkToContinueBrowsing = Link::ToJob($continue_browsing['JobId']);
				}
				elseif (isset($continue_browsing['Jobs'])) {
					$this->mLinkToContinueBrowsing = Link::ToJobsPage($page);
				}
				elseif (isset($continue_browsing['Companies'])) {
					$this->mLinkToContinueBrowsing = Link::ToCompanies($page);
				}
				elseif (isset($continue_browsing['CompanyId'])) {
					$this->mLinkToContinueBrowsing = Link::ToCompany($continue_browsing['CompanyId']);
				}
				elseif (isset($continue_browsing['UserProfile'])) {
					$this->mLinkToContinueBrowsing = Link::ToUserProfile($continue_browsing['UserProfile']);
				}
				elseif (isset($continue_browsing['PostId']) && isset($continue_browsing['UserId'])) {
					$this->mLinkToContinueBrowsing = Link::ToPostDetails($continue_browsing['UserId'], $continue_browsing['PostId']);
				}
				elseif (isset($continue_browsing['TrendingChatter'])) {
					$this->mLinkToContinueBrowsing = Link::ToTrendingChatter($page);
				}
				elseif (isset($continue_browsing['PopularTags'])) {
					$this->mLinkToContinueBrowsing = Link::ToPopularTags($continue_browsing['PopularTags'], $page);
				}
				else {
					$this->mLinkToContinueBrowsing = Link::ToIndex($page);
				}
			}
			
			if (isset($_POST['Login'])) {
				$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = '6LfSQqsUAAAAAIk2keHjKoycSrTUN9Qzhq5XnpzB';
				$recaptcha_response = $_POST['recaptcha_response'];

				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				$recaptcha = json_decode($recaptcha);

				if (isset($recaptcha->score) && $recaptcha->score >= 0.5) {
					$login_status = Customer::IsValid(trim(htmlspecialchars($_POST['login_email'])), trim(htmlspecialchars($_POST['login_password'])));
					
					switch($login_status) {
						case 2: 
							$this->mErrorMessage = 'Unrecognized Email';
							$this->mEmail = trim(htmlspecialchars($_POST['login_email']));
						break;
						case 1:
							$this->mErrorMessage = 'Unrecognized Password';
							$this->mEmail = trim(htmlspecialchars($_POST['login_email']));
						break;
						case 0:
							$redirect_to_link = $this->mLinkToContinueBrowsing;
							header('Location:' . $redirect_to_link);
							exit();
					}
				}
				else {
					$this->mErrorMessage = ':-( Something went wrong. It seems Google thinks your\'re a robot. <u><a href="https://developers.google.com/recaptcha/docs/v3" class="white-text" target="_blank">Find out more</a></u>';
				}
			}

			if (isset($_POST['Register'])) {
				$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = '6LfSQqsUAAAAAIk2keHjKoycSrTUN9Qzhq5XnpzB';
				$recaptcha_response = $_POST['recaptcha_response'];

				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				$recaptcha = json_decode($recaptcha);

				if (isset($recaptcha->score) && $recaptcha->score >= 0.5) {
					$customer_read = Customer::GetLoginInfo(htmlspecialchars($_POST['register_email']));

					if ((!(empty($customer_read['customer_id'])))) {
						$this->mErrorMessage = 'Email already taken';
						return;
					}

					if (!empty($_POST['register_handle'])) {
						$customer_handle = Customer::GetHandle();
						$handle_array = array();
						for ($i=0; $i<count($customer_handle); $i++) {
							$handle_array[$i] = $customer_handle[$i]['handle'];
						}
						if (in_array(htmlspecialchars($_POST['register_handle']), $handle_array)) {
							$this->mErrorMessage = 'Handle already taken';
							return;
						}
					}

					if (empty($_POST['register_email'])) {
						$this->mErrorMessage = 'Email address cannot be empty';
						return;
					}

					if (empty($_POST['register_password'])) {
						$this->mErrorMessage = 'Password cannot be empty';
						return;
					}

					if (!empty($_POST['register_password'])) {
						$password = htmlspecialchars($_POST['register_password']);

						// Validate password strength
						$uppercase = preg_match('@[A-Z]@', $password);
						$lowercase = preg_match('@[a-z]@', $password);
						$number = preg_match('@[0-9]@', $password);
						$specialChars = preg_match('@[^\w]@', $password);

						if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
							$this->mErrorMessage = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one number, and one special character.';
							return;
						}
					}

					if (empty($this->mErrorMessage)) {
						$this->mEmail = htmlspecialchars($_POST['register_email']);
						$this->mPassword = htmlspecialchars($_POST['register_password']);
						if (empty($_POST['register_handle'])) {
							$this->mHandle = substr(uniqid(rand(), true), 0, 8);
						}
						else {
							$this->mHandle = htmlspecialchars($_POST['register_handle']);
						}
						$this->mFullName = htmlspecialchars($_POST['register_full_name']);
						if (empty($this->mFullName)) {
							$this->mFullName = null;
						}

						$customer_id = Customer::Add($this->mEmail, $this->mPassword, $this->mHandle, $this->mFullName);
						if (is_numeric($customer_id)) {
							$redirect_to_link = $this->mLinkToContinueBrowsing;
							header('Location:' . $redirect_to_link);
							exit();
						}
						else {
							$this->mErrorMessage = 'Something went wrong';
							return;
						}
					}
				}
				else {
					$this->mErrorMessage = ':-( Something went wrong. It seems Google thinks your\'re a robot. <u><a href="https://developers.google.com/recaptcha/docs/v3" class="white-text" target="_blank">Find out more</a></u>';
				}
			}
		}
	}

?>