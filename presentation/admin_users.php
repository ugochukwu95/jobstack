<?php
	class AdminUsers {
		public $mUsers = array();
		public $mErrorMessage;
		public $mLinkToUsersAdmin;
		public $mAllWords = 'off';
		public $mUsersSearch = 'on';
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mSearchString;
		public $mSearchDescription;
		public $mAvatar = array();
		public $mLinkToUsersPostsAdmin;

		public function __construct() {
			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			if (isset($_GET['SearchResults'])) {
				$this->mSearchString = trim($_GET['SearchString']);
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
			}

			$this->mLinkToUsersAdmin = Link::ToUsersAdmin($this->mPagination);
		}
		public function init() {

			// If searching users
			if (isset($this->mSearchString)) {
				$search_results = Catalog::userSearch($this->mSearchString, $this->mAllWords, $this->mPagination, $this->mrTotalPages);

				$this->mUsers = $search_results['users'];

				if (empty($this->mUsers)) {
					$this->mSearchDescription = 'Your search for: "'.$this->mSearchString.'" generated no results.';
				}
				else {
					for ($i=0; $i<count($this->mUsers); $i++) {
						$this->mAvatar[$this->mUsers[$i]['customer_id']] = $this->mUsers[$i]['avatar'];
						$this->mUsers[$i]['link_to_user_posts'] = Link::ToUserPostsAdmin($this->mUsers[$i]['customer_id']);
					}
				}
			} 
			else {
				$this->mUsers = Catalog::GetUsersAdmin($this->mPagination, $this->mrTotalPages);
				for ($i=0; $i<count($this->mUsers); $i++) {
					$this->mAvatar[$this->mUsers[$i]['customer_id']] = $this->mUsers[$i]['avatar'];
					$this->mUsers[$i]['link_to_user_posts'] = Link::ToUserPostsAdmin($this->mUsers[$i]['customer_id']);
				}
			}

			if (isset($_POST['Delete_User'])) {
				Catalog::DeleteUser((int)$_POST['UserId']);
				if (isset($this->mAvatar[(int)$_POST['UserId']])) {
					$target_dir = SITE_ROOT . '\images\profile_pictures\\';
					unlink($target_dir . basename($this->mAvatar[(int)$_POST['UserId']]));
				}
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					if (isset($_GET['SearchResults'])) {
						$this->mLinkToNextPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, null, $this->mUsersSearch, $this->mPagination + 1);
					}
					else {
						$this->mLinkToNextPage = Link::ToUsersAdmin($this->mPagination + 1);
					}
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				if (isset($_GET['SearchResults'])) {
					$this->mLinkToPreviousPage = Link::ToSearchResults($this->mSearchString, $this->mAllWords, null, $this->mUsersSearch, $this->mPagination - 1);
				}
				else {
					$this->mLinkToPreviousPage = Link::ToUsersAdmin($this->mPagination - 1);
				}
			}
		}
	}
?>