<?php
	class CustomerLogged {
		public $mLinkToEditProfile;
		public $mLinkToLogout;
		public $mLinkToUserProfile;
		public $mActiveLink = '';
		public $mUserProfileActive = '';
		public $mLinkToContinueBrowsing;

		public function __construct() {
			$this->mLinkToLogout = Link::Build('index.php?Logout');
			$this->mLinkToEditProfile = Link::ToEditProfile();
			$this->mLinkToUserProfile = Link::ToUserProfile(Customer::GetCurrentCustomerId());

			if (isset ($_GET['EditProfile'])) {
				$this->mActiveLink = 'active';
			}
			elseif (isset ($_GET['UserProfile'])) {
				$this->mUserProfileActive = 'active';
			}
		}

		public function init() {
			if (isset($_GET['Logout'])) {
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
					else {
						$this->mLinkToContinueBrowsing = Link::ToIndex($page);
					}
				}
				
				Customer::logout();
				header('Location:' . $this->mLinkToContinueBrowsing);

				exit();
			}
		}
	}
?>