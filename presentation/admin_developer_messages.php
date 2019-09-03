<?php
	class AdminDeveloperMessages {
		public $mMessages = array();
		public $mPagination = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mMessagesListPages = array();
		public $mLinkToAdminDeveloperMessages;

		public function __construct() {
			if (isset($_GET['Pagination'])) {
				$this->mPagination = (int)$_GET['Pagination'];
			}

			if ($this->mPagination < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToAdminDeveloperMessages = Link::ToDeveloperMessages($this->mPagination);
		}

		public function init() {
			$this->mMessages = Catalog::GetDeveloperMessages($this->mPagination, $this->mrTotalPages);
			for ($i=0; $i<count($this->mMessages); $i++) {
				$this->mMessages[$i]['link_to_message'] = Link::ToADeveloperMessage($this->mMessages[$i]['id']);
			}

			if (isset($_POST['Delete_Message'])) {
				Catalog::DeleteDeveloperMessage((int)$_POST['MessageId']);
			}

			if ($this->mrTotalPages > 1) {
				// Build the Next Link
				if ($this->mPagination < $this->mrTotalPages) {
					$this->mLinkToNextPage = Link::ToDeveloperMessages($this->mPagination + 1);
				}
			}

			if ($this->mPagination > 1) {
				$this->mLinkToPreviousPage = Link::ToDeveloperMessages($this->mPagination - 1);
			}

			for ($i=1; $i<=$this->mrTotalPages; $i++) {
				$this->mMessagesListPages[] = Link::ToDeveloperMessages($i);
			}
		}
	}
?>