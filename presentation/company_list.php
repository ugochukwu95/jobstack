<?php
	class CompanyList {
		public $mPage = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mCompanyListPages = [];
		public $mSearchString;
		public $mSearchDescription = '';
		public $mAllWords = 'off';
		public $mCompanySearch = 'off';
		public $mCompanies;
		public $mSiteUrl;
		public $mLinkToCompanies;

		public function __construct() {
			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect Page value');
			}
			
			// Retrieve the search string and AllWords from the query string
			if (isset ($_GET['SearchResults'])) {
				$this->mSearchString = trim(str_replace('-', ' ', $_GET['SearchString']));
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
				$this->mCompanySearch = isset ($_GET['CompanySearch']) ? $_GET['CompanySearch'] : 'off';
			}
			
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToCompanies = Link::ToCompanies();
		}
		public function init() {
			if (isset($this->mSearchString)) {
				$search_results = Catalog::companySearch($this->mSearchString, $this->mAllWords, $this->mPage, $this->mrTotalPages);

				$this->mCompanies = $search_results['companies'];

				if (empty($this->mCompanies)) {
					$this->mSearchDescription = 'Your search for: "'.$this->mSearchString.'" generated no results.';
				}
			}
			else {
			    $this->mCompanies = Catalog::GetCompanies($this->mPage, $this->mrTotalPages);
			}
			

			if ($this->mrTotalPages > 1) {
				// Build the next link
				if ($this->mPage < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToCompanies($this->mPage + 1);
				}

				// Build the previous link
				if ($this->mPage > 1) {
					$this->mLinkToPreviousPage = Link::ToCompanies($this->mPage - 1);
				}
			}

			// Build the pages links
			for ($i = 1; $i <= $this->mrTotalPages; $i++) { 
				if (isset($_GET['Companies'])) {
					$this->mCompanyListPages[] = Link::ToCompanies($i);
				}
			}

			/* 404 redirect if the page number is larger than the total number of pages */
			if ($this->mPage > $this->mrTotalPages && !empty($this->mrTotalPages)) {
				// Clean output buffer
				ob_clean();
				// Load the 404 page
				include '404.php';
				// Clear the output buffer and stop execution
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}

			// Build links for product details pages
			for ($i=0; $i<count($this->mCompanies); $i++) {
				$this->mCompanies[$i]['link_to_company'] = Link::ToCompany($this->mCompanies[$i]['company_id']);
				if ($this->mCompanies[$i]['image']) {
					$this->mCompanies[$i]['image'] = Link::Build('images/company_logo/' . $this->mCompanies[$i]['image']);
				}
			}

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];
		}
	}
?>