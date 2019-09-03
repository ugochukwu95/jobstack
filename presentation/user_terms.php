<?php
	Class UserTerms {
		public $mLinkToPrivacyPolicy;

		public function __construct() {
			$this->mLinkToPrivacyPolicy = Link::ToPrivacyPolicy();
		}
	}
?>