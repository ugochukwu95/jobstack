<?php
	class MoreCompanyReviews {
		public $mCompanyId;
		public $mReviews = array();
		public $mrTotalPages;
		public $mPostListPages = array();
		public $mPage = 1;
		public $mLinkToMoreCompanyReviews;
		public $mLinkToCompany;
		public $mLinkToLoginPage;
		public $mSiteUrl;
		public $mCustomerId;
		public $mEnableAddJobReviewForm;
		public $mReviewerName;
		public $mAvatar;
		public $mTotalReviews;
		public $mCompanyName;

		public function __construct() {
			if (isset($_GET['MoreCompanyReviews'])) {
				$this->mCompanyId = (int)$_GET['MoreCompanyReviews'];
			}
			else {
				trigger_error('MoreCompanyReviewsId not set', E_USER_ERROR);
			}

			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToMoreCompanyReviews = Link::ToMoreCompanyReviews($this->mCompanyId, $this->mPage);
			$this->mLinkToCompany = Link::ToCompany($this->mCompanyId);
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mSiteUrl = Link::Build('');
			$this->mCustomerId = (int)Customer::GetCurrentCustomerId();
			$this->mCompanyName = Catalog::GetCompanyName($this->mCompanyId);
		}

		public function init() {
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

			$this->mReviews = Catalog::GetMoreCompanyReviews($this->mCompanyId, $this->mPage, $this->mrTotalPages);
			for ($i=0; $i<count($this->mReviews); $i++) {
				$this->mReviews[$i]['link_to_user_profile'] = Link::ToUserProfile($this->mReviews[$i]['customer_id']);
			}
			$this->mTotalReviews = Catalog::CountCompanyReviews($this->mCompanyId);

			// Pagination functionality
			if ($this->mrTotalPages > 1) {
				// Build the Next link
				if ($this->mPage < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToMoreCompanyReviews($this->mCompanyId, $this->mPage+1);
				}
				if ($this->mPage > 1) {
					$this->mLinkToPreviousPage = Link::ToMoreCompanyReviews($this->mCompanyId, $this->mPage-1);
				}

				// Build the pages links
				for ($i = 1; $i <= $this->mrTotalPages; $i++) {
					$this->mPostListPages[] = Link::ToMoreCompanyReviews($this->mCompanyId, $i);
				}
			}
		}
	}
?>