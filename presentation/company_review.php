<?php
	class CompanyReview {
		public $mCompanyId;
		public $mReviews;
		public $mTotalReviews;
		public $mReviewerName;
		public $mAvatar;
		public $mEnableAddJobReviewForm;
		public $mLinkToCompany;
		public $mLinkToLoginPage;
		public $mCustomerId;
		public $mEditReview = '';
		public $mSiteUrl;
		public $mCompanyName;
		public $mLinkToMoreCompanyReviews;

		private $_mAction;
		private $_mActionedReviewId;

		public function __construct() {

			if (isset($_GET['CompanyId'])) {
				$this->mCompanyId = (int)$_GET['CompanyId'];
			}
			else {
				trigger_error('CompanyId not set', E_USER_ERROR);
			}

			$this->mLinkToCompany = Link::ToCompany($this->mCompanyId);
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToMoreCompanyReviews = Link::ToMoreCompanyReviews($this->mCompanyId);
			$this->mCompanyName = Catalog::GetCompanyName($this->mCompanyId);
		}

		public function init() {
			// If visitor is logged in
			if (Customer::IsAuthenticated()) {

				$this->mCustomerId = (int)Customer::GetCurrentCustomerId();

				// Check if visitor is adding a review 
				if (isset($_POST['AddCompanyReview'])) {
					if (strlen(($_POST['review'])) != 0) {
						Catalog::CreateCompanyReview($this->mCustomerId, $this->mCompanyId, htmlspecialchars($_POST['review']), htmlspecialchars($_POST['group1']));
					}
				}
				

				// Display Add Review form because visitor is registered
				$this->mEnableAddJobReviewForm = true;

				$customer_data = Customer::Get();
				if ($customer_data['handle'] != '') {
					$this->mReviewerName = $customer_data['handle'];
				}
				else {
					$this->mReviewerName = $customer_data['email'];
				}
				

				// Get customer avatar
				if (!is_null($customer_data['avatar'])) {
					$this->mAvatar = $customer_data['avatar'];
				}
			} 

			if (isset($_POST['Edit_Review'])){
				Catalog::DeleteCompanyReview($_POST['ReviewId']);
			}
			if (isset($_POST['Delete_Review'])){
				Catalog::DeleteCompanyReview($_POST['ReviewId']);
			}

			$this->mReviews = Catalog::GetCompanyReviews($this->mCompanyId, REVIEWS_PER_PAGE);
			for ($i=0; $i<count($this->mReviews); $i++) {
				$this->mReviews[$i]['link_to_user_profile'] = Link::ToUserProfile($this->mReviews[$i]['customer_id']);
				$this->mReviews[$i]['review'] = $this->_mLinkify($this->mReviews[$i]['review']);
			}
			$this->mTotalReviews = count($this->mReviews);
		}
		private function _mLinkify($text) {
			$exp = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=-_|!:,.;]*[A-Z0-9+&@#\/%=-_|])/i', "<a href='$1' class='red-text text-lighten-2' target='_blank'>$1</a>", $text);
			$exp = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/im', "$1<a href='http://$2' class='red-text text-lighten-2' target='_blank'>$2</a>", $exp);
			return $exp;
		}
	}
?>