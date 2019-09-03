<?php
	class AdminReportCommentDetails {
		public $mLinkToAdminReportComment;
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

			$this->mLinkToAdminReportComment = Link::ToReportCommentAdmin();
			$this->mLinkToAdminReportCommentDetails = Link::ToReportCommentDetailsAdmin($this->mReportId);
		}
		public function init() {
			$this->mPost = Catalog::GetAReportComment($this->mReportId);
			$this->mWarnedUser = $this->mPost['access_denied'];

			if (isset($_POST['Warn'])) {
				$this->mWarnedUser = (int)$_POST['AccessDenied'];
				$this->mWarnedUser++;
				Catalog::WarnUser((int)$_POST['Warn'], $this->mWarnedUser);
			}

			if (isset($_POST['Delete_Comment'])) {
				Catalog::DeleteComment((int)$_POST['Delete_Comment'], (int)$_POST['UserId']);
			}

			if (isset($_POST['Delete_Report'])) {
				Catalog::DeleteReportComment((int)$_POST['Delete_Report']);
			}
		}
	}
?>