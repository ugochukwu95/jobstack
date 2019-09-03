<?php
	class JobDetails {
		public $mJob;
		public $mRecommendedJobs;
		public $mLinkToSearchResults;
		public $mSimilarJobs;
		public $mLinkToCartPage;
		public $mLinkToCompany;
		public $mLinkToMoreCompanyReviews;
		public $mCustomerId;
		public $mRelatedPosts = array();
		public $mSiteUrl;
		public $mLikedPostId;
		public $mLinkToJobDetails;
		public $mLinkToLoginPage;
		public $mLinkToPopularTags;
		public $mLinkToUserProfile;
		public $mLinkToWebsiteImage;
		public $mLinkToCareerService;
		public $mCountJobs;
		public $mPage = 1;
		public $mrTotalPages;
		public $mLinkToLogo;
		public $mTrendingLocations;
		public $mTrendingCompanies;
		public $mLinkToContactDeveloper;
		

		public $_mJob_Id;

		public function __construct() {
			if (isset($_GET['JobId'])) {
				$this->_mJob_Id = (int)$_GET['JobId'];
			}
			else {
				trigger_error('Job ID not set');
			}

			$this->mLinkToCartPage = Link::ToCartPage();
			if (Customer::GetCurrentCustomerId() != 0) {
				$this->mCustomerId = (int)Customer::GetCurrentCustomerId();
			}
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToJobDetails = Link::ToJob($this->_mJob_Id);
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mLinkToPopularTags = Link::ToPopularTags($this->_mJob_Id);
			$this->mLinkToUserProfile = Link::ToUserProfile($this->mCustomerId);
			$this->mLinkToWebsiteImage = Link::Build('images/website_images/other-job-interview.jpg');
			$this->mLinkToCareerService = Link::ToCareerService();
			$this->mLinkToLogo = Link::ToWebsiteLogo();
			$this->mLinkToContactDeveloper = Link::ToContactDeveloper();
			
			if (isset($_POST['Subscribe'])) {
			    $subscriber_name = htmlspecialchars(trim($_POST['FullName']));
			    $subscriber_email = htmlspecialchars(trim($_POST['Email']));
                
                $customer_read = Customer::GetLoginInfo($subscriber_email);
				if ((!(empty($customer_read['customer_id'])))) {
					return;
				}
				
				$hash = md5( rand(0,1000) );
				
				Catalog::InsertSubscriber($subscriber_name, $subscriber_email, $hash);
			}
		}

		public function init() {
			$this->mJob = Catalog::GetAJobSite($this->_mJob_Id);
			$this->mRecommendedJobs = Catalog::GetRecommendedJobs($this->_mJob_Id);
			$similar_jobs = Catalog::GetSixSimilarJobs($this->mJob['position_name'], $this->_mJob_Id);
			$this->mSimilarJobs = $similar_jobs['jobs'];
			$similar_jobs_count = $similar_jobs['items_count'];
			if ($similar_jobs_count > 6) {
			    $this->mLinkToSearchResults = Link::ToCatalogSearchResults($this->mJob['position_name'], 'off', 'off');
			}
			$this->mRelatedPosts = Customer::GetOnlineRelatedPosts($this->_mJob_Id, $this->mCustomerId);
			$this->mLikedPostId = Customer::GetLikedPostId($this->mCustomerId);
			$this->mCountJobs = count(Catalog::GetJobsBelongingToCompany($this->mJob['company_id'], $this->mPage, $this->mrTotalPages));

			$liked_post = array();
			for ($i=0; $i<count($this->mLikedPostId); $i++) {
				$liked_post[$i] = $this->mLikedPostId[$i]['post_id'];
			}
			for ($i=0; $i<count($this->mRelatedPosts); $i++) {
				if (in_array($this->mRelatedPosts[$i]['post_id'], $liked_post)) {
					$this->mRelatedPosts[$i]['is_liked'] = 'yes';
				}
				else {
					$this->mRelatedPosts[$i]['is_liked'] = 'no';
				}

				$this->mRelatedPosts[$i]['total_likes'] = Customer::GetTotalLikedPosts($this->mRelatedPosts[$i]['post_id']);
				$this->mRelatedPosts[$i]['link_to_user'] = Link::ToUserProfile($this->mRelatedPosts[$i]['customer_id']);
				$this->mRelatedPosts[$i]['link_to_post_details'] = Link::ToPostDetails($this->mRelatedPosts[$i]['customer_id'], $this->mRelatedPosts[$i]['post_id']);
				$this->mRelatedPosts[$i]['post'] = $this->_mLinkify($this->mRelatedPosts[$i]['post']);
				$this->mRelatedPosts[$i]['comments_count'] = Customer::GetPostCommentsCount($this->mRelatedPosts[$i]['post_id']);
				$this->mRelatedPosts[$i]['post_images'] = Catalog::GetImagePosts($this->mRelatedPosts[$i]['post_id']);
			}

			if (isset($_POST['Like'])) {
				Customer::InsertLikesPosts(null, (int)$_POST['PostId']);
			}
			elseif (isset($_POST['Dislike'])) {
				Customer::DeleteLikesPosts(null, (int)$_POST['PostId']); 
			}

			// Add-to-cart Link
			$this->mJob['link_to_add_job'] = Link::ToCart(ADD_JOB, $this->_mJob_Id);
			$this->mJob['link_to_company'] = Link::ToCompany($this->mJob['company_id']);
			$this->mLinkToMoreCompanyReviews = Link::ToMoreCompanyReviews($this->mJob['company_id']);
			if (!empty($this->mJob['rating'])) {
				$this->mJob['rating'] = ceil($this->mJob['rating']);
			}
			
			if (isset($this->mJob['company_image'])) {
				$this->mJob['company_image'] = link::Build('images/company_logo/'.$this->mJob['company_image']);
			}

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];

			$saved_jobs = SavedJobsCart::GetSavedJobsJobId();
			for ($i = 0; $i < count($saved_jobs); $i++) {
				$saved_jobs[$i] = $saved_jobs[$i]['job_id'];
			}

			if (in_array($this->mJob['job_id'], $saved_jobs)) {
				$this->mJob['card_color'] = 'red';
			}
			else {
				$this->mJob['card_color'] = 'teal';
			}

			//Add to cart functionality
			$saved_jobs_associative_array_list = SavedJobsCart::GetSavedJobsJobId();
			$saved_jobs = array();
			for ($i = 0; $i < count($saved_jobs_associative_array_list); $i++) {
				$saved_jobs[$i] = $saved_jobs_associative_array_list[$i]['job_id'];
			}

			// print_r($saved_jobs_associative_array_list);
            
            // Similar jobs functionality
			for ($i = 0; $i < count($this->mSimilarJobs); $i++) {
            
				// Creates link to job details page
				$this->mSimilarJobs[$i]['link_to_job'] = Link::ToJob($this->mSimilarJobs[$i]['job_id']);
				$this->mSimilarJobs[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mSimilarJobs[$i]['job_id']);

				//Saved job color functionality
				if (in_array($this->mSimilarJobs[$i]['job_id'], $saved_jobs)) {
					$this->mSimilarJobs[$i]['card_color'] = 'red';
					$this->mSimilarJobs[$i]['link_to_remove_job'] = Link::ToCart(REMOVE_JOB, $this->mSimilarJobs[$i]['job_id']);
				}
				else {
					$this->mSimilarJobs[$i]['card_color'] = 'teal';
				}
			}
			
			// Recommended jobs functionality
			for ($i = 0; $i < count($this->mRecommendedJobs); $i++) {

				// Creates link to job details page
				$this->mRecommendedJobs[$i]['link_to_job'] = Link::ToJob($this->mRecommendedJobs[$i]['job_id']);
				$this->mRecommendedJobs[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mRecommendedJobs[$i]['job_id']);

				//Saved job color functionality
				if (in_array($this->mRecommendedJobs[$i]['job_id'], $saved_jobs)) {
					$this->mRecommendedJobs[$i]['card_color'] = 'red';
					$this->mRecommendedJobs[$i]['link_to_remove_job'] = Link::ToCart(REMOVE_JOB, $this->mRecommendedJobs[$i]['job_id']);
				}
				else {
					$this->mRecommendedJobs[$i]['card_color'] = 'teal';
				}
			}

			// Posting to your profile
			if (isset($_POST['Button_Post_With_Tag'])) {
				if (trim(htmlspecialchars($_POST['Post'])) !== '') {
					$post = trim(htmlspecialchars($_POST['Post']));
					Customer::InsertIntoPostsWithTag($post, (int)$_POST['JobId']);
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