<?php
    class PostJob {
        public $mErrorMessage = null;
        public $mSuccessMessage = null;
        public $mLinkToUserPostJob;
        public $mCompanyName;
        public $mCompanyWebsite;
        public $mCAC;
        public $mEmail;
        public $mPhoneNumber;
        public $mPositionName;
        public $mJobCategory;
        public $mJobLocation;
        public $mAppDeadline;
        public $mJobDescription;
        
        public function __construct() {
            $this->mLinkToUserPostJob = Link::ToUserJobPost();
        }
        
        public function init() {
            if (isset($_POST['PostJob'])) {
                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = '6LfSQqsUAAAAAIk2keHjKoycSrTUN9Qzhq5XnpzB';
				$recaptcha_response = $_POST['recaptcha_response'];

				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				$recaptcha = json_decode($recaptcha);

				if (isset($recaptcha->score) && $recaptcha->score >= 0.5) {
                    if (!empty($_POST['company_name'])) {
                        $this->mCompanyName = trim(htmlspecialchars($_POST['company_name']));
                    }
                    else {
                        $this->mErrorMessage = 'Company Name is required';
                    }
                    
                    if (!empty($_POST['company_website'])) {
                        $this->mCompanyWebsite = trim(htmlspecialchars($_POST['company_website']));
                    }
                    else {
                        $this->mCompanyWebsite = null;
                    }
                    
                    if (!empty($_POST['cac'])) {
                        $this->mCAC = trim(htmlspecialchars($_POST['cac']));
                    }
                    else {
                        $this->mCAC = null;
                    }
                    
                    if (!empty($_POST['email'])) {
                        $email = trim(htmlspecialchars($_POST['email']));
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $this->mEmail = $email;
                            $this->mErrorMessage = 'Email address is invalid';
                        }
                        else {
                            $this->mEmail = $email;
                        }
                    }
                    else {
                        $this->mErrorMessage = 'Email address is required';
                    }
                    
                    if (!empty($_POST['phone_number'])) {
                        $this->mPhoneNumber = trim(htmlspecialchars($_POST['phone_number']));
                    }
                    else {
                        $this->mPhoneNumber = null;
                    }
                    
                    if (!empty($_POST['position_name'])) {
                        $this->mPositionName = trim(htmlspecialchars($_POST['position_name']));
                    }
                    else {
                        $this->mErrorMessage = 'Job Title is required';
                    }
                    
                    if (!empty($_POST['job_category'])) {
                        $this->mJobCategory = trim(htmlspecialchars($_POST['job_category']));
                    }
                    else {
                        $this->mErrorMessage = 'Job Category field cannot be empty';
                    }
                    
                    if (!empty($_POST['job_location'])) {
                        $this->mJobLocation = trim(htmlspecialchars($_POST['job_location']));
                    }
                    else {
                        $this->mErrorMessage = 'Job Location is required';
                    }
                    
                    if (!empty($_POST['app_deadline'])) {
                        $this->mAppDeadline = trim(htmlspecialchars($_POST['app_deadline']));
                    }
                    else {
                        $this->mErrorMessage = 'Date of expiration is required';
                    }
                    
                    if (!empty($_POST['job_description'])) {
                        $this->mJobDescription = trim(htmlspecialchars($_POST['job_description']));
                    }
                    else {
                        $this->mErrorMessage = 'Job Description is required';
                    }
                    
                    
                    if (is_null($this->mErrorMessage)) {
                        Catalog::InsertUserJob($this->mCompanyName, $this->mCompanyWebsite, $this->mCAC, $this->mEmail, $this->mPhoneNumber, $this->mPositionName, $this->mJobCategory, $this->mJobLocation, $this->mAppDeadline, $this->mJobDescription);
                        $this->mSuccessMessage = 'Submitted Successfully';
                        return;
                    }
				}
				else {
					$this->mErrorMessage = ':-( Something went wrong. It seems Google thinks your\'re a robot. <u><a href="https://developers.google.com/recaptcha/docs/v3" class="white-text" target="_blank">Find out more</a></u>';
				}
            }
        }
    }
?>