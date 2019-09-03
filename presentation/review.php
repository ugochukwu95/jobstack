<?php
	class Review {
		public $mJobId;
		public $mReviews;
		public $mTotalReviews;
		public $mReviewerName;
		public $mAvatar;
		public $mCustomerId;
		public $mEnableAddJobReviewForm;
		public $mLinkToJob;
		public $mLinkToLoginPage;
		public $mLinkToMoreJobReviews;
		public $mSiteUrl;

		public function __construct() {
			if (isset($_GET['JobId'])) {
				$this->mJobId = (int)$_GET['JobId'];
			}
			else {
				trigger_error('JobId not set', E_USER_ERROR);
			}
			$this->mLinkToJob = Link::ToJob($this->mJobId);
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mSiteUrl = Link::Build('');
			$this->mCustomerId = (int)Customer::GetCurrentCustomerId();
			$this->mLinkToMoreJobReviews = Link::ToMoreJobReviews($this->mJobId);
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

			$this->mReviews = Catalog::GetJobReviews($this->mJobId, REVIEWS_PER_PAGE);
			$this->mTotalReviews = count($this->mReviews);
			for ($i=0; $i<count($this->mReviews); $i++) {
				$this->mReviews[$i]['link_to_user'] = Link::ToUserProfile($this->mReviews[$i]['customer_id']);
				$this->mReviews[$i]['review'] = $this->_mLinkify($this->mReviews[$i]['review']);
			}
		}
		private function _mLinkify($text) {
			$exp = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=-_|!:,.;]*[A-Z0-9+&@#\/%=-_|])/i', "<a href='$1' class='red-text text-lighten-2' target='_blank'>$1</a>", $text);
			$exp = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/im', "$1<a href='http://$2' class='red-text text-lighten-2' target='_blank'>$2</a>", $exp);
			return $exp;
		}
	}
?>