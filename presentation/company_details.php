<?php
	class CompanyDetails {
		public $mCompany;
		public $mPage = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mJobs;
		public $mJobListPages = array();
		public $mSiteUrl;
		public $mLinkToCartPage;
		public $mLinkToCompany;
		public $mLinkToUserProfile;

		public $_mCompany_Id;

		public function __construct() {
			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect page value');
			}
			if (isset($_GET['CompanyId'])) {
				$this->_mCompany_Id = (int)$_GET['CompanyId'];
			}
			else {
				trigger_error('Company ID not set');
			}
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToCartPage = Link::ToCartPage();
			$this->mLinkToCompany = Link::ToCompany($this->_mCompany_Id);
			$this->mLinkToUserProfile = Link::ToUserProfile(Customer::GetCurrentCustomerId());
		}

		public function init() {
			$this->mCompany = Catalog::GetACompany($this->_mCompany_Id);

			// Posting to your profile
			if (isset($_POST['Button_Post_With_Tag'])) {
				if (trim(htmlspecialchars($_POST['Post'])) !== '') {
					$post = trim(htmlspecialchars($_POST['Post']));
					Customer::InsertIntoPostsWithTag($post, (int)$_POST['JobId']);
				}
			}
			
			if (isset($this->mCompany['image'])) {
				$this->mCompany['image'] = link::Build('images/company_logo/'.$this->mCompany['image']);
			}

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];

			$this->mJobs = Catalog::GetJobsBelongingToCompany($this->_mCompany_Id, $this->mPage, $this->mrTotalPages);

			if ($this->mrTotalPages > 1) {
				if ($this->mPage < $this->mrTotalPages) {
					if (isset($this->_mCompany_Id)) {
						$this->mLinkToNextPage = Link::ToCompany($this->_mCompany_Id, $this->mPage + 1, $this->mrTotalPages);
					}
				}
			}

			if ($this->mPage > 1) {
				if (isset($this->_mCompany_Id)) {
					$this->mLinkToPreviousPage = Link::ToCompany($this->_mCompany_Id, $this->mPage - 1, $this->mrTotalPages);
				}
			}
			// Build the pages links
			for ($i = 1; $i <= $this->mrTotalPages; $i++) {
				if (isset($this->_mCompany_Id)) {
					$this->mJobListPages[] = Link::ToCompany($this->_mCompany_Id, $i);
				}
				
			}

			//Add to cart functionality
			$saved_jobs_associative_array_list = SavedJobsCart::GetSavedJobsJobId();
			$saved_jobs = array();
			for ($i = 0; $i < count($saved_jobs_associative_array_list); $i++) {
				$saved_jobs[$i] = $saved_jobs_associative_array_list[$i]['job_id'];
			}

			for ($i = 0; $i < count($this->mJobs); $i++) {

				// Creates link to job details page
				$this->mJobs[$i]['link_to_job'] = Link::ToJob($this->mJobs[$i]['job_id']);
				$this->mJobs[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mJobs[$i]['job_id']);

				//Saved job color functionality
				if (in_array($this->mJobs[$i]['job_id'], $saved_jobs)) {
					$this->mJobs[$i]['card_color'] = 'red';
					$this->mJobs[$i]['link_to_remove_job'] = Link::ToCart(REMOVE_JOB, $this->mJobs[$i]['job_id']);
				}
				else {
					$this->mJobs[$i]['card_color'] = 'teal';
				}
			}
		}
	}
?>