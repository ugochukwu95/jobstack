<?php
session_start();

	date_default_timezone_set('Africa/Lagos');
	// Inxlude utility files
	require_once dirname(dirname(__FILE__)) . '/include/config.php';

	// include Business tier files
	require_once BUSINESS_DIR . 'error_handler.php';

	// Load the database handler
	require_once BUSINESS_DIR . 'database_handler.php';

	// include link functionality
	require_once PRESENTATION_DIR . 'link.php';

	require_once BUSINESS_DIR . 'password_hasher.php';

	require_once BUSINESS_DIR . 'customer.php';

	// Load the database handler
	require_once BUSINESS_DIR . 'catalog.php';

	require_once BUSINESS_DIR . 'saved_jobs_cart.php';

	// Set the Error Handler
	ErrorHandler::SetHandler();

	
		 $mErrorMessage;
		 $mLinkToLogin;
		 $mLinkToRegisterCustomer;
		 $mEmail = '';
		 $mPassword = '';
		 $mHandle = '';
		 $mFullName = '';


		$mLinkToLogin = Link::Build('');
		$mLinkToRegisterCustomer = Link::ToRegisterCustomer();

			if (isset($_POST['Login'])) {

				$login_status = Customer::IsValid(trim(htmlspecialchars($_POST['login_email'])), trim(htmlspecialchars($_POST['login_password'])));
				switch($login_status) {
					case 2: 
						$mErrorMessage = 'Unrecognized Email';
						echo $mErrorMessage;
					break;
					case 1:
						$mErrorMessage = 'Unrecognized Password';
						echo 'Unrecognized Password';
					break; 
					case 0:
						// $redirect_to_link = Link::Build('');
						// header('Location:' . $redirect_to_link);
						if (Customer::IsAuthenticated()) {
							echo  'reload';
						}
				}
			}
			/*if (isset($_POST['Register'])) {

				$customer_read = Customer::GetLoginInfo(htmlspecialchars($_POST['register_email']));

				if ((!(empty($customer_read['customer_id'])))) {
					$this->mErrorMessage = 'Email already taken';
					echo $this->mErrorMessage;
					return;
				}

				if (isset($_POST['register_handle'])) {
					$customer_handle = Customer::GetHandle();
					$handle_array = array();
					for ($i=0; $i<count($customer_handle); $i++) {
						$handle_array[$i] = $customer_handle[$i]['handle'];
					}
					if (in_array(htmlspecialchars($_POST['register_handle']), $handle_array)) {
						$this->mErrorMessage = 'Handle already taken';
						echo $this->mErrorMessage;
						return;
					}
				}

				if (empty($_POST['register_email'])) {
					$this->mErrorMessage = 'Email address cannot be empty';
					echo $this->mErrorMessage;
					return;
				}

				if (empty($_POST['register_password'])) {
					$this->mErrorMessage = 'Password cannot be empty';
					echo $this->mErrorMessage;
					return;
				}

				if (empty($this->mErrorMessage)) {
					$this->mEmail = htmlspecialchars($_POST['register_email']);
					$this->mPassword = htmlspecialchars($_POST['register_password']);
					$this->mHandle = htmlspecialchars($_POST['register_handle']);
					$this->mFullName = htmlspecialchars($_POST['register_full_name']);

					$customer_id = Customer::Add($this->mEmail, $this->mPassword, $this->mHandle, $this->mFullName);
					if (is_numeric($customer_id)) {
						$redirect_to_link = Link::Build('');
						header('Location:' . $redirect_to_link);
					}
					else {
						$this->mErrorMessage = 'Something went wrong';
						echo $this->mErrorMessage;
						return;
					}
				}
			}*/


	// Close database connection
	DatabaseHandler::Close();

?>