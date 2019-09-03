<?php
	class CatalogSearchBox {
		public $mSearchString;
		public $mAllWords = 'off';
		public $mCompanySearch = 'off';
		public $mLinkToSearch;
		public $mPositions;
		public $mCompanies;

		public function __construct() {
			$this->mLinkToSearch = Link::ToCatalogSearch();
            
            // Search box autocomplete functionality
            $positions = Catalog::GetJobPositions();
			for ($i=0; $i<count($positions); $i++) {
				$this->mPositions[$positions[$i]['position_id']] = $positions[$i]['position_name'];
			}
			$this->mPositions = array_values($this->mPositions);
			// $this->mPositions = json_encode($this->mPositions);
			
			$companies = Catalog::GetJobCompanies();
			for ($i=0; $i<count($companies); $i++) {
				$this->mCompanies[$companies[$i]['company_id']] = $companies[$i]['company_name'];
			}
			$this->mCompanies = array_values($this->mCompanies);
			$this->mPositions = json_encode(array_merge($this->mPositions, $this->mCompanies));

			if (isset($_GET['Search'])) {
				$this->mSearchString = trim($_POST['search_string']);
				$this->mAllWords = isset ($_POST['all_words']) ? $_POST['all_words'] : 'off';
				$this->mCompanySearch = isset ($_POST['company_search']) ? $_POST['company_search'] : 'off';

				// Clean output buffer
				ob_clean();
				// Redirect 302
				header('HTTP/1.1 302 Found');
				header('Location: ' . Link::ToCatalogSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch));
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}
			elseif (isset($_GET['SearchResults'])) {
				$this->mSearchString = trim(str_replace('-', ' ', $_GET['SearchString']));
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
				$this->mCompanySearch = isset ($_GET['CompanySearch']) ? $_GET['CompanySearch'] : 'off';
			}
			
		}
	}
?>