<?php
	class AdminMenu {
		public $mLinkToStoreAdmin;
		public $mLinkToStoreFront;
		public $mLinkToCompanyPage;
		public $mLinkToUsersAdmin;
		public $mLinkToUsersJobsAdmin;
		public $mLinkToLogout;
		public $mLinkToReportPostsAdmin;
		public $mLinkToReportCommentsAdmin;
		public $mLinkToDeveloperMessages;

		public function __construct() {
			$this->mLinkToStoreAdmin = Link::ToAdmin();
			$this->mLinkToStoreFront = Link::ToIndex();
			$this->mLinkToCompanyPage = Link::ToCompaniesAdmin();
			$this->mLinkToUsersAdmin = Link::ToUsersAdmin();
			$this->mLinkToUsersJobsAdmin = Link::ToUsersJobsAdmin();
			$this->mLinkToLogout = Link::ToLogout();
			$this->mLinkToReportPostsAdmin = Link::ToReportPostAdmin();
			$this->mLinkToReportCommentsAdmin = Link::ToReportCommentAdmin();
			$this->mLinkToDeveloperMessages = Link::ToDeveloperMessages();
		}
	}
?>