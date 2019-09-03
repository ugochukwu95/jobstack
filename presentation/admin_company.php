<?php
	class AdminCompanies {
		public $mCompanies = array();
		public $mCompaniesCount;
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mCompaniesListPages = array();
		public $mErrorMessage;
		public $mLinkToCompaniesAdmin;
		public $mCompanyDescription;
		public $mCompanyName;
		public $mCompanyLink;
		public $mCompanyImage;
		public $mSearchDescription;
		public $mAllWords = 'off';
		public $mCompanySearch = 'on';
		public $mSearchString;
		public $mIgnoredWords = array();

		private $_mAction;
		private $_mActionedCompanyId;

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
					$this->_mActionedCompanyId = (int)substr($key, $last_underscore + 1);

					break;
				}
			}

			if (isset($_GET['SearchResults'])) {
				$this->mSearchString = trim($_GET['SearchString']);
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
			}

			$this->mLinkToCompaniesAdmin = Link::ToCompaniesAdmin($this->mPagination);
		}

		public function init() {

			// If searching the catalog
			if (isset($this->mSearchString)) {
				$search_results = Catalog::companySearch($this->mSearchString, $this->mAllWords, $this->mPagination, $this->mrTotalPages);

				$this->mCompanies = $search_results['companies'];
				$this->mIgnoredWords = $search_results['ignored_words'];

				if (empty($this->mCompanies)) {
					$this->mSearchDescription = 'Your search for: "'.$this->mSearchString.'" generated no results.';
				}
			} 
			else {
				$this->mCompanies = Catalog::GetCompanies($this->mPagination, $this->mrTotalPages);
			}

			if ($this->_mAction == 'add_comp') {
				$this->mCompanyName = $_POST['name'];
				$this->mCompanyDescription = $_POST['description'];
				$this->mCompanyLink = $_POST['link'];
				$this->mCompanyImage = $_POST['image'];

				if (is_null($this->mCompanyName)) {
					$this->mErrorMessage = 'Company Name cannot be empty';
				}

				if (is_null($this->mErrorMessage)) {
					Catalog::AddCompany($this->mCompanyName, $this->mCompanyDescription, $this->mCompanyLink, $this->mCompanyImage);
					header('Location: ' . $this->mLinkToCompaniesAdmin);
				}
			}

			if ($this->_mAction == 'edit_comp'){
				header('Location: ' . htmlspecialchars_decode(Link::ToCompanyDetailsAdmin($this->_mActionedCompanyId)));
				exit();
			}

			if ($this->_mAction == 'delete_comp') {
				$status = Catalog::DeleteCompany($this->_mActionedCompanyId);
				if ($status != 1) {
					$this->mErrorMessage = 'An error occurred';
				}
				else {
					header('Location: ' . $this->mLinkToCompaniesAdmin);
				}
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					if (isset($_GET['SearchResults'])) {
						$this->mLinkToNextPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, null, $this->mPagination + 1);
					}
					else {
						$this->mLinkToNextPage = Link::ToCompaniesAdmin($this->mPagination + 1);
					}
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				if (isset($_GET['SearchResults'])) {
					$this->mLinkToPreviousPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, null, $this->mPagination - 1);
				}
				$this->mLinkToPreviousPage = Link::ToCompaniesAdmin($this->mPagination - 1);
			}

			for ($i=1; $i<=$this->mrTotalPages; $i++) {
				if (isset($_GET['SearchResults'])) {
					$this->mCompaniesListPages[] = Link::ToSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, null, $i);
				}
				else {
					$this->mCompaniesListPages[] = Link::ToCompaniesAdmin($i);
				}
			}

			$this->mCompaniesCount = (int)count($this->mCompanies);
		}
	}
?>