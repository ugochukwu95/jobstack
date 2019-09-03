<?php
	class AdminJobDetails {
		public $mJob;
		public $mErrorMessage;
		public $mLinkToJobDetailsAdmin;
		public $mLinkToJobsAdmin;

		private $_mJob_id;

		public function __construct() {
			if (!isset($_GET['jobId'])) {
				trigger_error('Job ID not set');
			}
			else {
				$this->_mJob_id = (int)$_GET['jobId'];
			}

			$this->mLinkToJobDetailsAdmin = Link::ToJobDetailsAdmin($this->_mJob_id);
			$this->mLinkToJobsAdmin = Link::ToJobsAdmin();
			$this->mJob = Catalog::GetAJob($this->_mJob_id);
		}

		public function init() {

			if (isset($_POST['UpdateJobInfo'])) {
				$job_description = $_POST['job_description'];
				$date_posted = date('Y-m-d', strtotime($_POST['date_posted']));
				$date_of_expiration = date('Y-m-d', strtotime($_POST['date_of_expiration']));
				$company_id = $_POST['company_id'];
				$job_link = $_POST['job_link'];
				$position_id = $_POST['position_id'];
				$job_location_id = $_POST['job_location_id'];
				$display = $_POST['display'];

				if ($job_description == null) {
					$this->mErrorMessage = 'Job Description is empty';
				}

				if ($date_posted == null) {
					$this->mErrorMessage = 'Date Posted is empty';
				}

				if ($date_of_expiration == null) {
					$this->mErrorMessage = 'Expiry Date is empty';
				}

				if ($company_id == null) {
					$this->mErrorMessage = 'Company ID cannot be empty';
				}

				if ($position_id == null) {
					$this->mErrorMessage = 'Position ID is empty';
				}

				if ($job_location_id == null) {
					$this->mErrorMessage = 'Job Location Id is empty';
				}

				if (is_null($this->mErrorMessage)) {
					Catalog::UpdateJob($this->_mJob_id,
						$job_description,
						$date_posted,
						$date_of_expiration,
						$company_id,
						$job_link,
						$position_id,
						$job_location_id,
						$display
					);
					header('Location: ' . $this->mLinkToJobDetailsAdmin);
					exit();
				}
			}
		}
	}
?>