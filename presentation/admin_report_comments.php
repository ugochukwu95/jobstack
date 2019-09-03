<?php
	class AdminReportComments {
		public $mComments = array();
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mLinkToReportCommentAdmin;

		public function __construct() {
			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToReportCommentAdmin = Link::ToReportCommentAdmin($this->mPagination);
		}
		public function init() {
			$this->mComments = Catalog::GetReportedComments($this->mPagination, $this->mrTotalPages);
			for ($i=0; $i<count($this->mComments); $i++) {
				$this->mComments[$i]['report_comment_details'] = Link::ToReportCommentDetailsAdmin($this->mComments[$i]['report_id']);
			}
			

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToReportCommentAdmin($this->mPagination + 1);
				}
			}

			if ($this->mPagination > 1) {
				// Building the previous link
				$this->mLinkToPreviousPage = Link::ToReportCommentAdmin($this->mPagination - 1);
			}
		}
	}
?>