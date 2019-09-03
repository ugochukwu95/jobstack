<?php
	class FirstPage {
		public $mLinkToSearch;
		public $mLinkToAllJobsUrl;
		public $mLinkToAllCompaniesUrl;
		public $mLinkToSavedJobsUrl;
		public $mLinkToTrendingChatter;
		public $mHighestHiringCompanies;
		public $mTrendingPositions;
		public $mPosts;
		public $mrTotalPages;
		public $mPage = 1;
		public $mPeopleYouFollow = array();
		public $mSiteUrl;
		public $mLikedPostId;
		public $_mUserId;
		public $mLinkToLoginPage;
		public $mLinkToLogo;
		public $mTrendingLocations;
		public $mTrendingCompanies;
		public $mLinkToTodayJobs;
		public $mLinkToYesterdayJobs;
		public $mLinkToThisWeekJobs;

		public function __construct() {
			$this->mLinkToSearch = Link::ToCatalogSearch();
			$this->mLinkToAllJobsUrl = Link::ToJobsPage();
			$this->mLinkToSavedJobsUrl = Link::ToCart();
			$this->mLinkToAllCompaniesUrl = Link::ToCompanies();
			$this->mLinkToTrendingChatter = Link::ToTrendingChatter();
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mLinkToLogo = Link::ToWebsiteLogo();
			$this->mLinkToTodayJobs = Link::ToTodayJobsPage();
			$this->mLinkToYesterdayJobs = Link::ToYesterdayJobsPage();
			$this->mLinkToThisWeekJobs = Link::ToThisWeekJobsPage();
			$this->mSiteUrl = Link::Build("");
			if (Customer::GetCurrentCustomerId() != 0) {
				$this->_mUserId = (int)Customer::GetCurrentCustomerId();
			}
		}
 
		public function init() {

			$this->mPosts = Customer::GetFrontPageCustomerPosts($this->mPage, $this->mrTotalPages);

			$this->mLikedPostId = Customer::GetLikedPostId($this->_mUserId);
			
			// Liked button functionality
			$liked_post = array();
			for ($i=0; $i<count($this->mLikedPostId); $i++) {
				$liked_post[$i] = $this->mLikedPostId[$i]['post_id'];
			}

			for ($j=0; $j<count($this->mPosts); $j++) {
				if ($this->_mUserId != 0) {
					if (in_array($this->mPosts[$j]['post_id'], $liked_post)) {
						$this->mPosts[$j]['is_liked'] = 'yes';
					}
					else {
						$this->mPosts[$j]['is_liked'] = 'no';
					}
				}

				$this->mPosts[$j]['total_likes'] = Customer::GetTotalLikedPosts($this->mPosts[$j]['post_id']);
				$this->mPosts[$j]['link_to_user'] = Link::ToUserProfile($this->mPosts[$j]['customer_id']);
				$this->mPosts[$j]['link_to_post_details'] = Link::ToPostDetails($this->mPosts[$j]['customer_id'], $this->mPosts[$j]['post_id']);
				$this->mPosts[$j]['post'] = $this->_mLinkify($this->mPosts[$j]['post']);
				$this->mPosts[$j]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mPosts[$j]['job_id']);
				$this->mPosts[$j]['comments_count'] = Customer::GetPostCommentsCount($this->mPosts[$j]['post_id']);
				$this->mPosts[$j]['post_images'] = Catalog::GetImagePosts($this->mPosts[$j]['post_id']);
			}

			if (isset($_POST['Like'])) {
				Customer::InsertLikesPosts(null, (int)$_POST['PostId']);
			}
			elseif (isset($_POST['Dislike'])) {
				Customer::DeleteLikesPosts(null, (int)$_POST['PostId']); 
			}

			// Delete post functionality
			if (isset($_POST['Delete_Post'])) {
				Customer::DeleteCustomerPost((int)$_POST['PostId'], null);
				Catalog::DeleteImagePosts((int)$_POST['PostId']);
			}

			// Hide post funnctionality
			if (isset($_POST['Hide_Post'])) {
				Customer::InsertHiddenPost((int)$_POST['PostId'], null);
			}

			// Block User functionality
			if (isset($_POST['Block_Post'])) {
				Customer::InsertBlockedCustomer(null, (int)$_POST['BlockCustomerId']);
			}

			// Report Functionality
			if (isset($_POST['Report_Post'])) {
				Customer::ReportPost((int)$_POST['CustomerId'], (int)$_POST['PostId']);
			}

			// Follow customer functionality
			if (isset($_POST['Follow_User'])) {
				Customer::FollowCustomer(null, (int)$_POST['FollowCustomerId']);
			}

			// unfollow customer functionality
			if (isset($_POST['Unfollow_User'])) {
				Customer::UnfollowCustomer(null, (int)$_POST['UnfollowCustomerId']);
			}

			// people you follow functionality
			if (Customer::GetCurrentCustomerId() !== 0) {
				$people_you_follow = Customer::GetPeopleYouFollow(Customer::GetCurrentCustomerId());
				for ($j=0; $j<count($people_you_follow); $j++) {
					$this->mPeopleYouFollow[$j] = $people_you_follow[$j]['follow_customer_id'];
				}
			}
			// Jobs by location functionality
			$this->mTrendingLocations = Catalog::GetHighestRecruitingLocations();
			for ($i=0; $i<count($this->mTrendingLocations); $i++) {
			    $this->mTrendingLocations[$i]['link_to_location'] = Link::ToJobsBelongingToLocation($this->mTrendingLocations[$i]['job_location_id'], 
			    $this->mTrendingLocations[$i]['location_name']);
			    $this->mTrendingLocations[$i]['jobs_count'] = Catalog::CountJobsInLocation($this->mTrendingLocations[$i]['job_location_id']);
			}
			
			// Jobs by company functionality
			$this->mTrendingCompanies = Catalog::GetHighestRecruitingCompanies();
			for ($i=0; $i<count($this->mTrendingCompanies); $i++) {
			    $this->mTrendingCompanies[$i]['link_to_company'] = Link::ToCompany($this->mTrendingCompanies[$i]['company_id']);
			    $this->mTrendingCompanies[$i]['jobs_count'] = Catalog::CountJobsInCompany($this->mTrendingCompanies[$i]['company_id']);
			    $this->mTrendingCompanies[$i]['image'] = Link::Build('images/company_logo/'. $this->mTrendingCompanies[$i]['image']);
			}
		}

		private function _mLinkify($text) {
			$exp = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=-_|!:,.;]*[A-Z0-9+&@#\/%=-_|])/i', '<a href="$1" class="red-text text-lighten-2" target="_blank">$1</a>', $text);
			$exp = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/im', '$1<a href="http://$2" class="red-text text-lighten-2" target="_blank">$2</a>', $exp);
			return $exp;
		}
	}
?>