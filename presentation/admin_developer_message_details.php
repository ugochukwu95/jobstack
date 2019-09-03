<?php
	class AdminDeveloperMessageDetails {
		public $mMessageId;
		public $mMessage = array();
		public $mLinkToDeveloperMessageDetails;
		public $mLinkToDeveloperMessages;

		public function __construct() {
			if (isset($_GET['MessageId'])) {
				$this->mMessageId = (int)$_GET['MessageId'];
			}
			else {
				trigger_error('ID not set');
				exit();
			}
			$this->mLinkToDeveloperMessageDetails = Link::ToADeveloperMessage($this->mMessageId);
			$this->mLinkToDeveloperMessages = Link::ToDeveloperMessages();
		}

		public function init() {
			$this->mMessage = Catalog::GetADeveloperMessage($this->mMessageId);
			if (isset($_POST['Delete_Message'])) {
				Catalog::DeleteDeveloperMessage((int)$_POST['MessageId']);
			}
		}
	}
	
?>