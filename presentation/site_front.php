<?php
	class SiteFront {
		public $mSiteUrl;
		public $mLinkToAllJobsUrl;
		public $mLinkToAllCompaniesUrl;
		public $mLinkToSavedJobsUrl;
		public $mLinkToTrendingChatterUrl;
		public $mContentsCell = 'first_page_tpl.php';
		public $mCartSummaryBadge = 0;
		public $mPageTitle;
		public $mLoginOrLoggedCell = 'customer_login_link_tpl.php';
		public $mProfilePicture;
		public $mLinkToLogin;
		public $mLinkToUserProfile;
		public $mLinkToUserTerms;
		public $mLinkToPrivacyPolicy;
		public $mLinkToContactDeveloper;
		public $mLinkToCareerService;
		public $mPageDescription;
		public $mLinkToLogo;
		public $mTrendingLocations;
		public $mTrendingCompanies;
		public $mPageName = 'Jobstack';
		public $mPositions = array();
		public $mLinkToPostJob;

		// Active Links
		public $mSiteActiveLink = '';
		public $mAllJobsActiveLink = '';
		public $mSavedJobsLink = '';
		public $mAllCompaniesActiveLink = '';
		public $mTrendingChatterActiveLink = '';
		public $mCareerServiceActiveLink = '';


		public function __construct() {
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToAllJobsUrl = Link::ToJobsPage();
			$this->mLinkToSavedJobsUrl = Link::ToCart();
			$this->mLinkToAllCompaniesUrl = Link::ToCompanies();
			$this->mLinkToLogin = Link::ToLoginPage();
			$this->mLinkToTrendingChatterUrl = Link::ToTrendingChatter();
			$this->mLinkToUserTerms = Link::ToUserTerms();
			$this->mLinkToPrivacyPolicy = Link::ToPrivacyPolicy();
			$this->mLinkToContactDeveloper = Link::ToContactDeveloper();
			$this->mLinkToLogo = Link::ToWebsiteLogo();
			$this->mLinkToCareerService = Link::ToCareerService();
			$this->mLinkToPostJob = Link::ToUserJobPost();
			
			if ((Customer::GetCurrentCustomerId()) != 0) {
				$this->mLinkToUserProfile = Link::ToUserProfile(Customer::GetCurrentCustomerId());
			}

			if (isset($_GET['Jobs'])) {
				$this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['YesterdayJobs'])) {
				$this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['TodayJobs'])) {
				$this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				$this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				$this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    $this->mAllJobsActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['JobId'])) {
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['CartAction'])) {
				$this->mSavedJobsLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif(isset($_GET['EditProfile'])) {
				$this->mSiteActiveLink = '';
			}
			elseif(isset($_GET['UserProfile'])) {
				$this->mSiteActiveLink = '';
			}
			elseif(isset($_GET['PostId'])) {
				$this->mSiteActiveLink = '';
			}
			elseif(isset($_GET['Companies'])) {
				$this->mAllCompaniesActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['CompanyId'])) {
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['UserTerms'])) {
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['PrivacyPolicy'])) {
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['ContactDeveloper'])) {
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['TrendingChatter'])) {
				$this->mTrendingChatterActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['CareerService'])) {
				$this->mCareerServiceActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['CVS'])) {
				$this->mCareerServiceActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['CoverLetters'])) {
				$this->mCareerServiceActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['LinkedinProfile'])) {
				$this->mCareerServiceActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['Applications'])) {
				$this->mCareerServiceActiveLink = 'active';
				$this->mSiteActiveLink = '';
			}
			elseif (isset($_GET['UserJobPost'])) {
			    $this->mSiteActiveLink = '';
			}
			else{
				$this->mSiteActiveLink = 'active';
			}
		}

		public function init() {
			if (Customer::IsAuthenticated()) {
				$this->mLoginOrLoggedCell = 'customer_logged_tpl.php';
			}
			if (isset ($_GET['EditProfile'])) {
				$this->mContentsCell = 'customer_details_tpl.php';
				$this->mPageName = 'Edit Profile';
			}
			elseif (isset($_GET['UserProfile'])) {
				$this->mContentsCell = 'user_profile_tpl.php';
				$this->mPageName = 'Profile';
			}
			elseif (isset($_GET['PostId']) && isset($_GET['UserId'])) {
				$this->mContentsCell = 'post_details_tpl.php';
				$this->mPageName = 'Post';
			}
			elseif (isset($_GET['Jobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
				$this->mPageName = 'All Jobs';
			}
			elseif (isset($_GET['TodayJobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
				$this->mPageName = 'Today\'s Jobs';
			}
			elseif (isset($_GET['YesterdayJobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
				$this->mPageName = 'Yesterday\'s Jobs';
			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
				$this->mPageName = 'This Week\'s Jobs';
			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
				$this->mPageName = 'Last Thirty Day\'s Jobs';
			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    $this->mContentsCell = 'jobs_list_tpl.php';
			    $this->mPageName = 'Jobs in '. Catalog::GetLocationName((int)$_GET['LocationId']);
			}
			elseif (isset($_GET['Jobs'])) {
				$this->mContentsCell = 'jobs_list_tpl.php';
			}
			elseif (isset($_GET['JobId'])) {
				$this->mContentsCell = 'job_details_tpl.php';
				$this->mPageName = 'Job Details';
			}
			elseif (isset($_GET['Companies'])) {
				$this->mContentsCell = 'company_list_tpl.php';
				$this->mPageName = 'All Companies';
			}
			elseif (isset($_GET['CompanyId'])) {
				$this->mContentsCell = 'company_details_tpl.php';
				$this->mPageName = 'Company Details';
			}
			// Load search result page if we're searching the catalog
			elseif (isset ($_GET['SearchResults'])) {
				$this->mContentsCell = 'catalog_search_result_tpl.php';
				$this->mPageName = 'Search Results';
			}
			
			elseif (isset ($_GET['CartAction'])) {
				$this->mContentsCell = 'cart_details_tpl.php';
				$this->mPageName = 'Saved Jobs';
			}

			elseif (isset($_GET['Login'])) {
				$this->mContentsCell = 'customer_login_tpl.php';
				$this->mPageName = 'Login or Register';
			}
			elseif (isset($_GET['TrendingChatter'])) {
				$this->mContentsCell = 'trending_chatter_tpl.php';
				$this->mPageName = 'Trending Chatter';
			}
			elseif (isset($_GET['PopularTags'])) {
				$this->mContentsCell = 'popular_tags_tpl.php';
				$this->mPageName = 'Thread';
			}
			elseif (isset($_GET['MoreJobReviews'])) {
				$this->mContentsCell = 'more_job_reviews_tpl.php';
				
			}
			elseif (isset($_GET['MoreCompanyReviews'])) {
				$this->mContentsCell = 'more_company_reviews_tpl.php';	
				$this->mPageName = 'Company Reviews';
			}
			elseif (isset($_GET['UserTerms'])) {
				$this->mContentsCell = 'user_terms_tpl.php';
				$this->mPageName = 'End Use Licence Agreement';
			}
			elseif (isset($_GET['PrivacyPolicy'])) {
				$this->mContentsCell = 'privacy_policy_tpl.php';
				$this->mPageName = 'Privacy Policy';
			}
			elseif (isset($_GET['ContactDeveloper'])) {
				$this->mContentsCell = 'contact_developer_tpl.php';
				$this->mPageName = 'Contact Ugo Oguejiofor';
			}
			elseif (isset($_GET['CareerService'])) {
				$this->mContentsCell = 'career_service_tpl.php';
				$this->mPageName = 'Career Service';
			}
			elseif (isset($_GET['CVS'])) {
				$this->mContentsCell = 'cvs_tpl.php';	
				$this->mPageName = 'CVs';
			}
			elseif (isset($_GET['CoverLetters'])) {
				$this->mContentsCell = 'cover_letters_tpl.php';	
				$this->mPageName = 'Cover Letters';
			}
			elseif (isset($_GET['LinkedinProfile'])) {
				$this->mContentsCell = 'linkedin_profile_tpl.php';	
				$this->mPageName = 'LinkedIn Profile';
			}
			elseif (isset($_GET['Applications'])) {
				$this->mContentsCell = 'applications_tpl.php';
				$this->mPageName = 'Applications';
			}
			elseif (isset($_GET['UserJobPost'])) {
			    $this->mContentsCell = 'post_job_tpl.php';
				$this->mPageName = 'Post Job';
			}
			
			// Load the page title
			$this->mPageTitle = $this->_GetPageTitle();
			$this->mPageDescription = $this->_GetPageDescription();
			$this->mCartSummaryBadge = SavedJobsCart::GetTotalAmount();

			if ((Customer::GetCurrentCustomerId()) != 0) {
				$avatar = Customer::GetUserAvatar();
				if (!is_null($avatar)) {
					$this->mProfilePicture = '<li><a href="'.$this->mLinkToUserProfile.'" class="white-text"><i class="fas fa-user"></i></a></li>';
				}
				else {
					$this->mProfilePicture = '<li><a href="'.$this->mLinkToUserProfile.'" class="white-text"><i class="fas fa-user"></i></a></li>';
				}
			}
			else {
				$this->mProfilePicture = '';
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

		private function _GetPageTitle() {
			$page_title = 'Job Search | Find Nigerian jobs on Jobstack';

			if (isset($_GET['JobId'])) {
				$page_title = 'Jobstack | '. Catalog::GetJobName($_GET['JobId']);
			}
			elseif (isset($_GET['Jobs'])) {
				$page_title = 'Jobstack | All Jobs in Nigeria';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}

			}
			elseif (isset($_GET['YesterdayJobs'])) {
				$page_title = 'Jobstack | Yesterday\'s Jobs in Nigeria';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}

			}
			elseif (isset($_GET['TodayJobs'])) {
				$page_title = 'Jobstack | Today\'s Jobs in Nigeria';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}

			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				$page_title = 'Jobstack | This Week\'s Jobs in Nigeria';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}

			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				$page_title = 'Jobstack | Last Thirty Day\'s Jobs in Nigeria';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}

			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    $location = (int)$_GET['LocationId'];
			    $page_title = 'Jobstack | Jobs in ' . Catalog::GetLocationName($location);

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset($_GET['CompanyId'])) {
				$page_title = 'Jobstack | '. Catalog::GetCompanyName((int)$_GET['CompanyId']);

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset($_GET['Companies'])) {
				$page_title = 'Jobstack | All Companies';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset ($_GET['CartAction'])) {
				$page_title = 'Jobstack | Saved Jobs';
			}
			elseif (isset ($_GET['UserTerms'])) {
				$page_title = 'Jobstack | User Terms';
			}
			elseif (isset ($_GET['PrivacyPolicy'])) {
				$page_title = 'Jobstack | Privacy Policy';
			}
			elseif (isset ($_GET['ContactDeveloper'])) {
				$page_title = 'Jobstack | Contact Developer';
			}
			elseif (isset ($_GET['SearchResults'])) {
				$page_title = 'Jobstack | ';
				// Display the search string
				$page_title .= trim(str_replace('-', ' ', $_GET['SearchString'])) . ' (';
				// Display "all-words search " or "any-words search"
				$all_words = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
				$page_title .= (($all_words == 'on') ? 'all' : 'any') . '-words search';
				// Display page number
				if (isset ($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ', page ' . ((int)$_GET['Page']);
				}
				$page_title .= ')';
			}
			elseif (isset ($_GET['Login'])) {
				$page_title = 'Jobstack | Login';
			}
			elseif (isset ($_GET['EditProfile'])) {
				$page_title = 'Jobstack | @'.Customer::GetAUserHandle((int)Customer::GetCurrentCustomerId()) . ' - Edit Profile';
			}
			elseif (isset ($_GET['UserProfile'])) {
				$page_title = 'Jobstack | @'.Customer::GetAUserHandle((int)$_GET['UserProfile']) . ' - Profile';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset ($_GET['TrendingChatter'])) {
				$page_title = 'Jobstack | Trending Chatter';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset($_GET['PopularTags'])) {
				$page_title = 'Jobstack | Posts about ';
				$page_title .= Catalog::GetJobName((int)$_GET['PopularTags']);

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}	
			}
			elseif (isset($_GET['MoreJobReviews'])) {
				$page_title = 'Jobstack | ';
				$page_title .= Catalog::GetJobName((int)$_GET['MoreJobReviews']);
				$page_title .= ' - More Job Reviews';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}	
			}
			elseif (isset($_GET['MoreCompanyReviews'])) {
				$page_title = 'Jobstack | ';
				$page_title .= Catalog::GetCompanyName((int)$_GET['MoreCompanyReviews']);
				$page_title .= ' - More Company Reviews';

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}	
			}
			elseif (isset ($_GET['PostId']) && isset ($_GET['UserId'])) {
				$page_title = 'Jobstack | @'.Customer::GetAUserHandle((int)$_GET['UserId']) . ' - Post:' .(int)$_GET['PostId'];

				if (isset($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			elseif (isset ($_GET['CareerService'])) {
				$page_title = 'Jobstack | CVs, Applications & LinkedIn Profiles';
			}
			elseif (isset ($_GET['CVS'])) {
				$page_title = 'Jobstack | CVs';
			}
			elseif (isset ($_GET['CoverLetters'])) {
				$page_title = 'Jobstack | CoverLetters';
			}
			elseif (isset ($_GET['LinkedinProfile'])) {
				$page_title = 'Jobstack | LinkedIn Profiles';
			}
			elseif (isset ($_GET['Applications'])) {
				$page_title = 'Jobstack | Applications';
			}
			elseif (isset ($_GET['UserJobPost'])) {
				$page_title = 'Jobstack | Post Job';
			}
			else {
				if (isset ($_GET['Page']) && ((int)$_GET['Page']) > 1) {
					$page_title .= ' - Page ' . ((int)$_GET['Page']);
				}
			}
			return $page_title;
		}

		private function _GetPageDescription() {
			$page_description = 'Thousands of employers are seeking your talent. Jobstack is Nigeria\'s fastest-growing job site, with new daily vacancies across all industries.';

			if (isset($_GET['JobId'])) {
				$page_description = 'Apply for '. Catalog::GetJobName($_GET['JobId']) .' at Jobstack';
			}
			elseif (isset($_GET['Jobs'])) {
				$page_description = 'Find all the latest jobs in Nigeria that match your skills';
			}
			elseif (isset($_GET['TodayJobs'])) {
				$page_description = 'Find all jobs in Nigeria posted today that match your skills';
			}
			elseif (isset($_GET['YesterdayJobs'])) {
				$page_description = 'Find all jobs in Nigeria posted yesterday that match your skills';
			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				$page_description = 'Find all the latest jobs in Nigeria posted this week that match your skills';
			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				$page_description = 'Find all the latest jobs in Nigeria posted this month that match your skills';
			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    $location = (int)$_GET['LocationId'];
			    $page_description = 'Find all the latest jobs in '.Catalog::GetLocationName($location).' posted this month that match your skills';
			}
			elseif (isset($_GET['CompanyId'])) {
				$page_description = 'Get information about '. Catalog::GetCompanyName((int)$_GET['CompanyId']) .', including jobs, user reviews and much more.';
			}
			elseif (isset($_GET['Companies'])) {
				$page_description = 'Find out more information about companies in Nigeria and across over 140 countries';
			}
			elseif (isset ($_GET['CartAction'])) {
				$page_description = 'Find jobs you have saved';
			}
			elseif (isset ($_GET['Login'])) {
				$page_description = 'Login and enjoy the more functionalities provided by our website.';
			}
			elseif (isset ($_GET['EditProfile'])) {
				$page_description = 'Edit your profile: @'.Customer::GetAUserHandle((int)Customer::GetCurrentCustomerId());
			}
			elseif (isset ($_GET['UserProfile'])) {
				$page_description = 'Find out more about @'.Customer::GetAUserHandle((int)$_GET['UserProfile']);
			}
			elseif (isset ($_GET['TrendingChatter'])) {
				$page_description = 'Find out the latest news about jobs on offer on our website and interact with fellow users.';
			}
			elseif (isset ($_GET['UserTerms'])) {
				$page_description = 'Jobstack User Terms';
			}
			elseif (isset ($_GET['PrivacyPolicy'])) {
				$page_description = 'Jobstack Privacy Policy';
			}
			elseif (isset ($_GET['Contact Developer'])) {
				$page_description = 'Jobstack - Contact Developer';
			}
			elseif (isset($_GET['PopularTags'])) {
				$page_description = 'Get the latest information about ' . Catalog::GetJobName((int)$_GET['PopularTags']);
			}
			elseif (isset($_GET['MoreJobReviews'])) {
				$page_description = 'Jobstack | ';
				$page_description .= Catalog::GetJobName((int)$_GET['MoreJobReviews']);
				$page_description .= ' - More Job Reviews';
			}
			elseif (isset($_GET['MoreCompanyReviews'])) {
				$page_description = 'Jobstack | ';
				$page_description .= Catalog::GetCompanyName((int)$_GET['MoreCompanyReviews']);
				$page_description .= ' - More Company Reviews';
			}
			elseif (isset ($_GET['PostId']) && isset ($_GET['UserId'])) {
				$page_description = 'Find out what @' . Customer::GetAUserHandle((int)$_GET['UserId']) . ' posted on Jobstack';
			}
			elseif (isset ($_GET['CareerService'])) {
				$page_description = 'Jobstack - Make sure that it\'s your CV, application form or profile that grabs the recruiter\'s attention.';
			}
			elseif (isset ($_GET['CVS'])) {
				$page_description = 'Jobstack - Learn how to design or build a CV that grabs the recruiter\'s attention';
			}
			elseif (isset ($_GET['CoverLetters'])) {
				$page_description = 'Jobstack - Learn how to design or build a cover letter that grabs the recruiter\'s attention';
			}
			elseif (isset ($_GET['LinkedinProfile'])) {
				$page_description = 'Jobstack - Learn how to design or build your Linkedin profile to grabs the recruiter\'s attention';
			}
			elseif (isset ($_GET['Applications'])) {
				$page_description = 'Jobstack - Learn how to answer application questions';
			}
			elseif (isset ($_GET['UserJobPost'])) {
				$page_description = 'Jobstack - Post a job for free';
			}
			else {
			    $page_description = 'Thousands of employers are seeking your talent. Jobstack is Nigeria\'s fastest-growing job site, with new daily vacancies across all industries.';
			}
			return $page_description;
		}

	}
?>