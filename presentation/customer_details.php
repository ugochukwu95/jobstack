<?php
	class CustomerDetails {
		public $mEmail;
		public $mHometown;
		public $mOccupation;
		public $mUniversity;
		public $mAboutYou;
		public $mAvatar;
		public $mLinkWebsite;
		public $mLinkFacebook;
		public $mLinkInstagram;
		public $mLinkTwitter;
		public $mLinkYoutube;
		public $mLinkLinkedin;
		public $mHandle;
		public $mFullName;
		public $mLinkToEditProfile;
		public $mEmailAlreadyTaken = 0;
		public $mHandleAlreadyTaken = 0;
		public $mErrorMessage;
		public $mSiteUrl;
		public $mCustomerSkills = array();

		private $_mErrors = 0;

		public function __construct() {
			$this->mSiteUrl = Link::Build('');
			$customer_data = Customer::Get();
				$this->mEmail = $customer_data['email'];
				$this->mHometown = $customer_data['hometown'];
				$this->mHandle = $customer_data['handle'];
				$this->mOccupation = $customer_data['occupation'];
				$this->mUniversity = $customer_data['university'];
				$this->mAboutYou = $customer_data['about_you'];
				$this->mAvatar = $customer_data['avatar'];
				$this->mFullName = $customer_data['full_name'];

			if (isset($_POST['sended'])) {
				if (empty($_POST['email'])) {
					$this->mEmailAlreadyTaken = 1;
					$this->_mErrors++;
				}
				else {
					$this->mEmail = htmlspecialchars($_POST['email']);
				}
				if(!empty($_POST['handle'])) {
					$this->mHandle = htmlspecialchars($_POST['handle']);
				}
				if(!empty($_POST['hometown'])) {
					$this->mHometown = htmlspecialchars($_POST['hometown']);
				}
				if(!empty($_POST['occupation'])) {
					$this->mOccupation = htmlspecialchars($_POST['occupation']);
				}
				if(!empty($_POST['university'])) {
					$this->mUniversity = htmlspecialchars($_POST['university']);
				}
				if(!empty($_POST['about_you'])) {
					$this->mAboutYou = htmlspecialchars($_POST['about_you']);
				}
			if(!empty($_POST['full_name'])) {
					$this->mFullName = htmlspecialchars($_POST['full_name']);
				}
			}

			if (isset($_POST['Skills'])) {
				$skills = htmlspecialchars($_POST['Skills']);
				if (Customer::CheckIfSkillExists($skills) == 0) {
					Customer::InsertNewSkill(null, $skills);
				}
				else {
					Customer::InsertIntoCustomerSkills(null, $skills);
				}
			}

			if (isset($_POST['RemoveSkillId'])) {
				$skillsId = htmlspecialchars($_POST['RemoveSkillId']);
				Customer::RemoveCustomerSkill(null, $skillsId);
			}

			$this->mLinkToEditProfile =  Link::ToEditProfile();
			$this->mCustomerSkills = Customer::GetCustomerSkills();
		}

		public function init() {

			if ((isset ($_POST['sended']))) {
				if (!isset($this->mEmail)) {
					$customer_read = Customer::GetLoginInfo($this->mEmail);

					if ((!(empty($customer_read['customer_id'])))) {
						$this->mEmailAlreadyTaken = 1;
						$this->mErrorMessage = 'Email already taken';
						return;
					}
				}

				if (is_null($this->mHandle)) {
					if (!empty($_POST['handle'])) {
						$customer_handle = Customer::GetHandle();
						$handle_array = array();
						for ($i=0; $i<count($customer_handle); $i++) {
							$handle_array[$i] = $customer_handle[$i]['handle'];
						}
						if (in_array($_POST['handle'], $handle_array)) {
							$this->mHandleAlreadyTaken = 1;
							$this->mErrorMessage = 'Unique handle already taken';
							return;
						}
					}					
				}

				if (isset($_FILES['avatarUpload']) && $_FILES['avatarUpload']['name'] != '') {
					$target_dir = SITE_ROOT . '/images/profile_pictures/';
					
					// upload profile picture functionality
					$target_file = $target_dir . basename($_FILES['avatarUpload']['name']);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Check if image is a actual image or fake image

					$check = getimagesize($_FILES['avatarUpload']['tmp_name']);
					if ($check == false) {
						$this->mErrorMessage = 'File is not an image.';
						return;
					}

					// check if file already exists
					if (file_exists($target_file)) {
						$this->mErrorMessage = 'Sorry, file already exists.';
						return;
					}

					if (isset($this->mAvatar)) {
						unlink($target_dir . basename($this->mAvatar));
					}

					// Check file size 
					if ($_FILES['avatarUpload']['size'] > 5000000) {
						$this->mErrorMessage = 'Sorry, your file is too large.';
						return;
					}
	 
	 				// Allow certain file formats
					if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
						$this->mErrorMessage = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed.';
						return;
					}

					if ($uploadOk == 0) {
						$this->mErrorMessage = 'Sorry, your file was not uploaded.';
					}
					else {
						if (move_uploaded_file($_FILES['avatarUpload']['tmp_name'], $target_file)) {
							$this->mAvatar = $_FILES['avatarUpload']['name'];
						}
						else {
							$this->mErrorMessage = 'Sorry, there was an error uploading your file.';
						}
					}

				}
				else {
					$this->mErrorMessage = 'File not sent to server';
				}

				Customer::UpdateAccountDetails(null, $this->mEmail, $this->mFullName, $this->mHandle, $this->mHometown, $this->mOccupation, $this->mAboutYou, $this->mAvatar, $this->mUniversity);

				header('Location: ' . $this->mLinkToEditProfile);
				exit();
			}
		}
	}
?>