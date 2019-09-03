<?php
	class CareerService {
		public $mSiteUrl;
		public $mLinkToCVS;
		public $mLinkToCoverLetters;
		public $mLinkToLinkedinProfile;
		public $mLinkToApplications;

		public function __construct() {
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToCVS = Link::ToCVS();
			$this->mLinkToApplications = Link::ToApplications();
			$this->mLinkToLinkedinProfile = Link::ToLinkedinProfile();
			$this->mLinkToCoverLetters = Link::ToCoverLetters();
		}
	}
?>