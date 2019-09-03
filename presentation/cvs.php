<?php
	class CVS {
		public $mLinkToCVS;
		public $mLinkToCoverLetters;
		public $mLinkToLinkedinProfile;
		public $mLinkToApplications;

		public function __construct() {
			$this->mLinkToApplications = Link::ToApplications();
			$this->mLinkToCVS = Link::ToCVS();
			$this->mLinkToLinkedinProfile = Link::ToLinkedinProfile();
			$this->mLinkToCoverLetters = Link::ToCoverLetters();
		}
	}
?>