<?php
	class PrivacyPolicy {
		public $mLinkToUserTerms;

		public function __construct() {
			$this->mLinkToUserTerms = Link::ToUserTerms();
		}
	}
?>