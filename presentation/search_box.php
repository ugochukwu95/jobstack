<?php
	class SearchBox {
		public $mSearchString;
		public $mAllWords = 'off';
		public $mLinkToSearch;
		public $mCompanySearch = 'off';
		public $mUserSearch = 'off';


		public function __construct() {
			$this->mLinkToSearch = Link::ToSearch();

			if (isset($_GET['Search'])) {
				$this->mSearchString = trim($_POST['search_string']);
				$this->mAllWords = isset ($_POST['all_words']) ? $_POST['all_words'] : 'off';
				$this->mCompanySearch = isset ($_POST['company_search']) ? $_POST['company_search'] : 'off';
				$this->mUserSearch = isset ($_POST['user_search']) ? $_POST['user_search'] : 'off';

				// Clean output buffer
				ob_clean();
				// Redirect 302
				header('HTTP/1.1 302 Found');
				header('Location: ' . Link::ToSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, $this->mUserSearch));
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}
			elseif (isset($_GET['SearchResults'])) {
				$this->mSearchString = trim(str_replace('-', ' ', $_GET['SearchString']));
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
				$this->mCompanySearch = isset ($_GET['CompanySearch']) ? $_GET['CompanySearch'] : 'off';
				$this->mUserSearch = isset ($_GET['UserSearch']) ? $_GET['UserSearch'] : 'off';
			}
		}
	}
?>