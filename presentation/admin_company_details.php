<?php
	class AdminCompanyDetails {
		public $mCompany;
		public $mErrorMessage;
		public $mSuccessMessage;
		public $mLinkToCompanyDetailsAdmin;
		public $mLinkToCompaniesAdmin;

		private $_mCompany_id;

		public function __construct() {
			if (!isset($_GET['companyId'])) {
				trigger_error('Company ID not set');
			}
			else {
				$this->_mCompany_id = (int)$_GET['companyId'];
			}

			$this->mLinkToCompanyDetailsAdmin = Link::ToCompanyDetailsAdmin($this->_mCompany_id);
			$this->mLinkToCompaniesAdmin = Link::ToCompaniesAdmin();
			$this->mCompany = Catalog::GetACompany($this->_mCompany_id); // This is were i stopped
		}

		public function init() {

			if (isset($_POST['UpdateCompanyInfo'])) {
				$company_description = $_POST['company_description'];
				$name = $_POST['company_name'];
				$company_link = $_POST['company_link'];
				$company_image = empty($_POST['company_image']) ? null : $_POST['company_image'];

				if ($name == null) {
					$this->mErrorMessage = 'Company Name is empty';
					return;
				}

				if (is_null($this->mErrorMessage)) {
					Catalog::UpdateCompany($this->_mCompany_id,
						$company_description,
						$name,
						$company_link,
						$company_image
					);
					$this->mSuccessMessage = 'Successfully updated.';
					header('Location: ' . $this->mLinkToCompanyDetailsAdmin);					
					exit();

				}
			}
		}
	}
?>