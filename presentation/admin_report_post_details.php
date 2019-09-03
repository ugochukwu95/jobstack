<?php
	class AdminReportPostDetails {
		public $mLinkToAdminReportPost;
		public $mPost = array();
		public $mReportId;
		public $mErrorMessage;
		public $mWarnedUser;

		public function __construct() {
			if (isset($_GET['ReportId'])) {
				$this->mReportId = (int)$_GET['ReportId'];
			}
			else {
				trigger_error('ReportId not set');
			}

			$this->mLinkToAdminReportPost = Link::ToReportPostAdmin();
			$this->mLinkToAdminReportPostDetails = Link::ToReportPostDetailsAdmin($this->mReportId);
		}
		public function init() {
			$this->mPost = Catalog::GetAReportPost($this->mReportId);
			$this->mWarnedUser = $this->mPost['access_denied'];

			if (isset($_POST['Warn'])) {
				$this->mWarnedUser = (int)$_POST['AccessDenied'];
				$this->mWarnedUser++;
				Catalog::WarnUser((int)$_POST['Warn'], $this->mWarnedUser);
			}

			if (isset($_POST['Delete_Post'])) {
				Catalog::DeletePost((int)$_POST['Delete_Post'], (int)$_POST['UserId']);
			}

			if (isset($_POST['Delete_Report'])) {
				Catalog::DeleteReportPost((int)$_POST['Delete_Report']);
			}
		}
	}
?>