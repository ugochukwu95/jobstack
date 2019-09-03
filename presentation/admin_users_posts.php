<?php
	class AdminUsersPosts {
		public $mUserId;
		public $mLinkToUsersPostsAdmin;
		public $mPagination = 1;
		public $mrTotalPages;
		public $mPosts = array();
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mPostsListPages = array();
		public $mErrorMessage;
		public $mUserHandle;

		public function __construct() {
			if (isset($_GET['userId'])) {
				$this->mUserId = (int)$_GET['userId'];
			}
			else {
				trigger_error('UserId not set');
			}

			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToUsersPostsAdmin = Link::ToUserPostsAdmin($this->mUserId);
		}

		public function init() {
			$this->mUserHandle = Customer::GetAUserHandle($this->mUserId);
			$this->mPosts = Catalog::GetUsersPostsAdmin($this->mUserId, $this->mPagination, $this->mrTotalPages);

			if (isset($_POST['AlterDisplay'])) {
				Catalog::UpdatePostDisplay((int)$_POST['AlterDisplay'], (int)$_POST['PostId']);
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToUserPostsAdmin($this->mUserId, $this->mPagination + 1);
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				$this->mLinkToPreviousPage = Link::ToUserPostsAdmin($this->mUserId, $this->mPagination - 1);
			}

			for ($i=1; $i<=$this->mrTotalPages; $i++) {
				$this->mPostsListPages[] = Link::ToUserPostsAdmin($this->mUserId, $i);
			}
		}
	}
?>