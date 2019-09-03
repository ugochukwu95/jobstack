<?php
    class AdminUsersJobs {
        public $mUsers= array();
		public $mErrorMessage;
		public $mLinkToUsersJobsAdmin;
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mAvatar = array();

		public function __construct() {
			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToUsersJobsAdmin = Link::ToUsersJobsAdmin($this->mPagination);
		}
		public function init() {

			$this->mUsers = Catalog::GetUsersJobs($this->mPagination, $this->mrTotalPages);
			for ($i=0; $i<count($this->mUsers); $i++) {
				$this->mUsers[$i]['link_to_user_job_details'] = Link::ToUserJobDetailsAdmin($this->mUsers[$i]['id']);
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToUsersJobsAdmin($this->mPagination + 1);
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				$this->mLinkToPreviousPage = Link::ToUsersJobsAdmin($this->mPagination - 1);
			}
		}
    }
?>