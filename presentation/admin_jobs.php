<?php
	class AdminJobs {
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mJobsCount;
		public $mJobs = array();
		public $mJobsListPages = array();
		public $mLocations;
		public $mPositions = array();
		public $mCompanies = array();
		public $mErrorMessage;
		public $mEditItem;
		public $mLinkToJobsAdmin;
		public $mJobDescription;
		public $mDateOfExpiry;
		public $mDatePosted;
		public $mJobLink;
		public $mCompanyId;
		public $mPositionId;
		public $mLocationId;
		public $mCompanyName;
		public $mPositionName;
		public $mLocationName;
		public $mDisplayId;
		public $mSearchDescription;
		public $mAllWords = 'off';
		public $mCompanySearch = 'off';
		public $mSearchString;
		public $mIgnoredWords = array();

		private $_mAction;
		private $_mActionedJobId;

		public function __construct() {

			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			foreach ($_POST as $key => $value) {
				if (substr($key, 0, 6) == 'submit') {
					$last_underscore = strrpos($key, '_');
					$this->_mAction = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
					$this->_mActionedJobId = (int)substr($key, $last_underscore + 1);

					break;
				}
			}

			if (isset($_GET['SearchResults'])) {
				$this->mSearchString = trim($_GET['SearchString']);
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
			}

			$this->mLinkToJobsAdmin = Link::ToJobsAdmin($this->mPagination);
		}
		public function init() {

			$locations = Catalog::GetLocations();
			$location_array = array();
			for ($i=0; $i<count($locations); $i++) {
				$this->mLocations[$locations[$i]['location_id']] = $locations[$i]['location_name'];
				$location_array[$locations[$i]['location_id']] = $locations[$i]['location_name'];
			}
			$this->mLocations = json_encode($this->mLocations);

			$positions = Catalog::GetJobPositions();
			$position_array = array();
			for ($i=0; $i<count($positions); $i++) {
				$this->mPositions[$positions[$i]['position_id']] = $positions[$i]['position_name'];
				$position_array[$positions[$i]['position_id']] = $positions[$i]['position_name'];
			}
			$this->mPositions = json_encode($this->mPositions);

			$companies = Catalog::GetJobCompanies();
			$company_array = array();
			for ($i=0; $i<count($companies); $i++) {
				$this->mCompanies[$companies[$i]['company_id']] = $companies[$i]['company_name'];
				$company_array[$companies[$i]['company_id']] = $companies[$i]['company_name'];
			}
			$this->mCompanies = json_encode($this->mCompanies);
			// If searching the catalog
			if (isset($this->mSearchString)) {
				$search_results = Catalog::Search($this->mSearchString, $this->mAllWords, $this->mPagination, $this->mrTotalPages);

				$this->mJobs = $search_results['jobs'];
				$this->mIgnoredWords = $search_results['ignored_words'];

				if (empty($this->mJobs)) {
					$this->mSearchDescription = 'Your search for: "'.$this->mSearchString.'" generated no results.';
				}
			}
			else {
				$this->mJobs = Catalog::GetJobsAdmin($this->mPagination, $this->mrTotalPages);
			}

			if ($this->_mAction == 'add_jobs') {

				$this->mJobDescription = $_POST['job_description'];
				$this->mDatePosted = date('Y-m-d', strtotime($_POST['date_posted']));
				$this->mDateOfExpiry = date('Y-m-d', strtotime($_POST['date_of_expiration']));
				$this->mPositionName = trim($_POST['position_name']);
				$this->mCompanyName = trim($_POST['company_name']);
				$this->mLocationName = trim($_POST['location_name']);

				foreach ($company_array as $key=>$value) {
					if ($this->mCompanyName == trim($value)) {
						$this->mCompanyId = $key;
						break;
					}
				}

				foreach ($position_array as $key=>$value) {
					if ($this->mPositionName == trim($value)) {
						$this->mPositionId = $key;
						break;
					}
				}

				foreach ($location_array as $key=>$value) {
					if ($this->mLocationName == trim($value)) {
						$this->mLocationId = $key;
						break;
					}
				}

				if (is_null($this->mPositionId) && $_POST['position_name'] != '') {
					$this->mPositionId = (int)Catalog::InsertPosition($_POST['position_name']);
				}
				if (is_null($this->mLocationId) && $_POST['location_name'] != '') {
					$this->mLocationId = (int)Catalog::InsertLocation($_POST['location_name']);
				}
				$this->mJobLink = $_POST['job_link'];
				$this->mDisplayId = $_POST['display'];

				if ($this->mJobDescription == null) {
					$this->mErrorMessage = 'Job Description is empty empty';
				}

				if ($this->mDatePosted == null) {
					$this->mErrorMessage = 'Date Posted is empty';
				}

				if ($this->mDateOfExpiry == null) {
					$this->mErrorMessage = 'Expiry Date is empty';
				}

				if ($this->mCompanyId == null) {
					$this->mErrorMessage = 'Company ID cannot be empty';
				}

				if ($this->mPositionId == null) {
					$this->mErrorMessage = 'Position ID is empty';
				}

				if ($this->mLocationId == null) {
					$this->mErrorMessage = 'Job Location Id is empty';
				}

				if ($this->mErrorMessage == null) {
					Catalog::AddJob($this->mJobDescription,  $this->mDatePosted, $this->mDateOfExpiry, $this->mCompanyId, $this->mJobLink, $this->mPositionId, $this->mLocationId, $this->mDisplayId);
					header('Location: ' . $this->mLinkToJobsAdmin);
					exit();
				}
			}

			if ($this->_mAction == 'edit_jobs'){
				header('Location: ' . htmlspecialchars_decode(Link::ToJobDetailsAdmin($this->_mActionedJobId)));
				exit();
			}

			if ($this->_mAction == 'delete_jobs') {
				$status = Catalog::DeleteJob($this->_mActionedJobId);
				if ($status != 1) {
					$this->mErrorMessage = 'An error occurred';
				}
				else {
					header('Location: ' . $this->mLinkToJobsAdmin);
				}
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					if (isset($_GET['SearchResults'])) {
						$this->mLinkToNextPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, null, null, $this->mPagination + 1);
					}
					else {
						$this->mLinkToNextPage = Link::ToJobsAdmin($this->mPagination + 1);
					}
				}
			}

			if ($this->mPagination > 1) {
				if (isset($_GET['SearchResults'])) {
					$this->mLinkToPreviousPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, null, null, $this->mPagination - 1);
				}
				else {
					$this->mLinkToPreviousPage = Link::ToJobsAdmin($this->mPagination - 1);
				}
			}

			for ($i=1; $i<=$this->mrTotalPages; $i++) {
				if (isset($_GET['SearchResults'])) {
					$this->mJobsListPages[] = Link::ToSearchResults($this->mSearchString, $this->mAllWords, null, null, $i);
				}
				else {
					$this->mJobsListPages[] = Link::ToJobsAdmin($i);
				}
			}

			$this->mJobsCount = (int)count($this->mJobs);
		}
	}
?>