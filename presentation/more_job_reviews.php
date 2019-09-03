<?php
	class MoreJobReviews {
		public $mJobId;
		public $mReviews = array();
		public $mrTotalPages;
		public $mPostListPages = array();
		public $mPage = 1;
		public $mLinkToMoreJobReviews;
		public $mLinkToJob;
		public $mLinkToLoginPage;
		public $mSiteUrl;
		public $mCustomerId;
		public $mEnableAddJobReviewForm;
		public $mReviewerName;
		public $mAvatar;
		public $mTotalReviews;
		public $mJobName;

		public function __construct() {
			if (isset($_GET['MoreJobReviews'])) {
				$this->mJobId = (int)$_GET['MoreJobReviews'];
			}
			else {
				trigger_error('MoreJobReviewsId not set', E_USER_ERROR);
			}

			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToMoreJobReviews = Link::ToMoreJobReviews($this->mJobId, $this->mPage);
			$this->mLinkToJob = Link::ToJob($this->mJobId);
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mSiteUrl = Link::Build('');
			$this->mCustomerId = (int)Customer::GetCurrentCustomerId();
			$this->mJobName = Catalog::GetJobName($this->mJobId);
		}

		public function init() {
			// If visitor is logged in
			if (Customer::IsAuthenticated()) {

				// Check if visitor is adding a review 
				if (isset($_POST['AddJobReview'])) {
					if (strlen(($_POST['review'])) != 0) {
						Catalog::CreateJobReview(Customer::GetCurrentCustomerId(), $this->mJobId, htmlspecialchars($_POST['review']));
					}
					
				}
				if (isset($_POST['InLikes'])) {
						Catalog::InsertLikedReview(((int)$_POST['ReviewId']), Customer::GetCurrentCustomerId());
				}

				if (isset($_POST['InDislikes'])) {
					Catalog::InsertDislikedReview(((int)$_POST['ReviewId']), Customer::GetCurrentCustomerId());
				}

				if (isset($_POST['DeleteLikedReview'])) {
					Catalog::DeleteLikedReview(((int)$_POST['ReviewId']), Customer::GetCurrentCustomerId());
				}

				if (isset($_POST['DeleteDislikedReview'])) {
					Catalog::DeleteDislikedReview(((int)$_POST['ReviewId']), Customer::GetCurrentCustomerId());
				}

				// Display Add Review form because visitor is registered
				$this->mEnableAddJobReviewForm = true;

				$customer_data = Customer::Get();
				if (!is_null($customer_data['handle'])) {
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
				Catalog::DeleteReview($_POST['ReviewId']);
			}
			if (isset($_POST['Delete_Review'])){
				Catalog::DeleteReview($_POST['ReviewId']);
			}

			$this->mReviews = Catalog::GetMoreJobReviews($this->mJobId, $this->mPage, $this->mrTotalPages);
			$this->mTotalReviews = Catalog::CountJobReviews($this->mJobId);
			for ($i=0; $i<count($this->mReviews); $i++) {
				$this->mReviews[$i]['link_to_user'] = Link::ToUserProfile($this->mReviews[$i]['customer_id']);
			}

			// Pagination functionality
			if ($this->mrTotalPages > 1) {
				// Build the Next link
				if ($this->mPage < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToMoreJobReviews($this->mJobId, $this->mPage+1);
				}
				if ($this->mPage > 1) {
					$this->mLinkToPreviousPage = Link::ToMoreJobReviews($this->mJobId, $this->mPage-1);
				}

				// Build the pages links
				for ($i = 1; $i <= $this->mrTotalPages; $i++) {
					$this->mPostListPages[] = Link::ToMoreJobReviews($this->mJobId, $i);
				}
			}
		}
	}
?>