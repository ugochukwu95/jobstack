<?php
	class AdminReportPosts {
		public $mPosts = array();
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mLinkToReportPostAdmin;

		public function __construct() {
			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToReportPostAdmin = Link::ToReportPostAdmin($this->mPagination);
		}
		public function init() {
			$this->mPosts = Catalog::GetReportedPosts($this->mPagination, $this->mrTotalPages);
			for ($i=0; $i<count($this->mPosts); $i++) {
				$this->mPosts[$i]['report_post_details'] = Link::ToReportPostDetailsAdmin($this->mPosts[$i]['report_id']);
			}
			

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToReportPostAdmin($this->mPagination + 1);
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				$this->mLinkToPreviousPage = Link::ToReportPostAdmin($this->mPagination - 1);
			}
		}
	}
?>