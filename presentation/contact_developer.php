<?php
	class ContactDeveloper {
		public $mLinkToContactDeveloper;

		public function __construct() {
			$this->mLinkToContactDeveloper = Link::ToContactDeveloper();
		}

		public function init() {
			if (isset($_POST['SubmitContact'])) {
				
				$first_name = trim(htmlspecialchars($_POST['FirstName']));
				$last_name = trim(htmlspecialchars($_POST['LastName']));
				$message = trim(htmlspecialchars($_POST['Message']));
				$email = trim(htmlspecialchars($_POST['Email']));
				if (is_null($_POST['PhoneNumber'])) {
					$phone_number = null;
				}
				else {
					$phone_number = trim(htmlspecialchars($_POST['PhoneNumber']));
				}

				Catalog::InsertDeveloperMessage($first_name, $last_name, $email, $phone_number, $message);
			}
		}
	}
?>