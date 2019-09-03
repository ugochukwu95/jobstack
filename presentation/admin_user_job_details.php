<?php
	class AdminUserJobDetails {
		public $mId;
		public $mMessage = array();
		public $mLinkToAdminUserJobDetails;
		public $mLinkToAdminUsersJobs;

		public function __construct() {
			if (isset($_GET['userJobId'])) {
				$this->mId = (int)$_GET['userJobId'];
			}
			else {
				trigger_error('ID not set');
				exit();
			}
			$this->mLinkToAdminUserJobDetails = Link::ToUserJobDetailsAdmin($this->mId);
			$this->mLinkToAdminUsersJobs = Link::ToUsersJobsAdmin();
		}

		public function init() {
			$this->mMessage = Catalog::GetUserJobDetails($this->mId);
			if (isset($_POST['Delete_Job'])) {
				Catalog::DeleteUserJob((int)$_POST['ID']);
			}
		}
	}
	
?>