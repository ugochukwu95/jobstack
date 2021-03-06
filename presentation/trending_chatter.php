<?php
	class TrendingChatter {
		public $mPosts = array();
		public $mPage = 1;
		public $mrTotalPages;
		public $mPostListPages = array();
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mPeopleYouFollow = array();
		public $mHighestTrendingTags = array();
		public $mLinkToLoginPage;
		public $mPostId;
		public $mLinkToCommunityImage;
		public $mErrorMessage;

		public $mLinkToTrendingChatter;
		public $mSiteUrl;

		private $_mUserId;

		public function __construct() {
			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Invalid page number');
			}
			$this->mLinkToTrendingChatter = Link::ToTrendingChatter($this->mPage);
			$this->mSiteUrl = Link::Build('');
			$this->_mUserId = (int)Customer::GetCurrentCustomerId();
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mLinkToCommunityImage = Link::Build('images/website_images/join-our-communty.jpg');
		}

		public function init() {

			if ($this->_mUserId != 0) {
				$this->mPosts = Customer::GetOnlineCustomerPosts($this->_mUserId, $this->mPage, $this->mrTotalPages);
				$this->mLikedPostId = Customer::GetLikedPostId($this->_mUserId);
			
				// Liked button functionality
				$liked_post = array();
				for ($i=0; $i<count($this->mLikedPostId); $i++) {
					$liked_post[$i] = $this->mLikedPostId[$i]['post_id'];
				}

				for ($j=0; $j<count($this->mPosts); $j++) {
					if (in_array($this->mPosts[$j]['post_id'], $liked_post)) {
						$this->mPosts[$j]['is_liked'] = 'yes';
					}
					else {
						$this->mPosts[$j]['is_liked'] = 'no';
					}

					$this->mPosts[$j]['total_likes'] = Customer::GetTotalLikedPosts($this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['link_to_user'] = Link::ToUserProfile($this->mPosts[$j]['customer_id']);
					$this->mPosts[$j]['link_to_post_details'] = Link::ToPostDetails($this->mPosts[$j]['customer_id'], $this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mPosts[$j]['job_id']);
					$this->mPosts[$j]['comments_count'] = Customer::GetPostCommentsCount($this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['post'] = $this->_mLinkify($this->mPosts[$j]['post']);
					$this->mPosts[$j]['post_images'] = Catalog::GetImagePosts($this->mPosts[$j]['post_id']);
				}
			}
			else {
				$this->mPosts = Customer::GetOfflineCustomerPosts($this->mPage, $this->mrTotalPages);

				for ($j=0; $j<count($this->mPosts); $j++) {
					$this->mPosts[$j]['total_likes'] = Customer::GetTotalLikedPosts($this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['link_to_user'] = Link::ToUserProfile($this->mPosts[$j]['customer_id']);
					$this->mPosts[$j]['link_to_post_details'] = Link::ToPostDetails($this->mPosts[$j]['customer_id'], $this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mPosts[$j]['job_id']);
					$this->mPosts[$j]['comments_count'] = Customer::GetPostCommentsCount($this->mPosts[$j]['post_id']);
					$this->mPosts[$j]['post'] = $this->_mLinkify($this->mPosts[$j]['post']);
					$this->mPosts[$j]['post_images'] = Catalog::GetImagePosts($this->mPosts[$j]['post_id']);
				}
			}

			$this->mHighestTrendingTags = Catalog::GetHighestTrendingTags();
			for ($i=0; $i<count($this->mHighestTrendingTags); $i++) {
				$this->mHighestTrendingTags[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mHighestTrendingTags[$i]['job_id']);
			}

			if (isset($_POST['Like'])) {
				Customer::InsertLikesPosts(null, (int)$_POST['PostId']);
			}
			elseif (isset($_POST['Dislike'])) {
				Customer::DeleteLikesPosts(null, (int)$_POST['PostId']); 
			}

			// Delete post functionality
			if (isset($_POST['Delete_Post'])) {
				Customer::DeleteCustomerPost((int)$_POST['PostId'], null);
				Catalog::DeleteImagePosts((int)$_POST['PostId']);
			}

			// Hide post funnctionality
			if (isset($_POST['Hide_Post'])) {
				Customer::InsertHiddenPost((int)$_POST['PostId'], null);
			}

			// Block User functionality
			if (isset($_POST['Block_Post'])) {
				Customer::InsertBlockedCustomer(null, (int)$_POST['BlockCustomerId']);
			}

			// Report Functionality
			if (isset($_POST['Report_Post'])) {
				Customer::ReportPost((int)$_POST['CustomerId'], (int)$_POST['PostId']);
			}

			// Follow customer functionality
			if (isset($_POST['Follow_User'])) {
				Customer::FollowCustomer(null, (int)$_POST['FollowCustomerId']);
			}

			// unfollow customer functionality
			if (isset($_POST['Unfollow_User'])) {
				Customer::UnfollowCustomer(null, (int)$_POST['UnfollowCustomerId']);
			}

			// people you follow functionality
			if (Customer::GetCurrentCustomerId() !== 0) {
				$people_you_follow = Customer::GetPeopleYouFollow(Customer::GetCurrentCustomerId());
				for ($j=0; $j<count($people_you_follow); $j++) {
					$this->mPeopleYouFollow[$j] = $people_you_follow[$j]['follow_customer_id'];
				}
			}

			// Posting to your profile
			if (isset($_POST['Button_Post'])) {
				if (empty($_POST['post_to_your_profile']) && !empty($_FILES['PostImage']['name']) && $_FILES['PostImage']['name'][0] != '') {
					for ($i=0; $i<count($_FILES['PostImage']['name']); $i++) {
						$check = getimagesize($_FILES['PostImage']['tmp_name'][$i]);
						if ($check == false) {
							$this->mErrorMessage = 'You must make a comment';
							return;
						}
						else {
							$this->mPostId = Customer::InsertIntoPosts(trim(htmlspecialchars($_POST['post_to_your_profile'])));
							break;
						}
					}
				}
				else {
					if (count($_FILES['PostImage']['name']) > 4) {
						$this->mErrorMessage = 'You cannot upload more than four(4) images';
						return;
					}
					$this->mPostId = Customer::InsertIntoPosts(trim(htmlspecialchars($_POST['post_to_your_profile'])));
				}

				if (!empty($_FILES['PostImage']['name']) && $_FILES['PostImage']['name'][0] != '') {
					
					$target_dir = SITE_ROOT . '/images/post_images/';
					if (count($_FILES['PostImage']['name']) > 4) {
						$this->mErrorMessage = 'You cannot upload more than four(4) images';
						return;
					}
					for ($i=0; $i<count($_FILES['PostImage']['name']); $i++) {
						$target_file = $target_dir . basename($_FILES['PostImage']['name'][$i]); 
						$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
						
						// Check if image is a actual image or fake image
						$check = getimagesize($_FILES['PostImage']['tmp_name'][$i]);
						if ($check == false) {
							$this->mErrorMessage = 'File is not an image.';
							return;
						}

						// Allow certain file formats
						if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
							$this->mErrorMessage = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed.';
							return;
						}

						if (move_uploaded_file($_FILES['PostImage']['tmp_name'][$i], $target_file)) {
							Catalog::InsertImagePosts($this->mPostId, $_FILES['PostImage']['name'][$i]);
						}
						else {
							$this->mErrorMessage = 'Sorry, there was an error uploading your file.';
						}
					}
				}
				header('Location:' .$this->mLinkToTrendingChatter);
				exit();
			}

			// Pagination functionality
			if ($this->mrTotalPages > 1) {
				// Build the Next link
				if ($this->mPage < $this->mrTotalPages) {
					if (isset($_GET['TrendingChatter'])) {
						$this->mLinkToNextPage = Link::ToTrendingChatter($this->mPage + 1);
					} 
				}
				if ($this->mPage > 1) {
					if (isset($_GET['TrendingChatter'])) {
						$this->mLinkToPreviousPage = Link::ToTrendingChatter($this->mPage - 1);
					} 
				}

				// Build the pages links
				for ($i = 1; $i <= $this->mrTotalPages; $i++) {
					if (isset($_GET['TrendingChatter'])) {
						$this->mPostListPages[] = Link::ToTrendingChatter($i);
					}
				} 
			}

			if (Customer::GetCurrentCustomerId() !== 0) {
				$people_you_follow = Customer::GetPeopleYouFollow(Customer::GetCurrentCustomerId());
				for ($j=0; $j<count($people_you_follow); $j++) {
					$this->mPeopleYouFollow[$j] = $people_you_follow[$j]['follow_customer_id'];
				}
			}

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];
		}

		private function _mLinkify($text) {
			$exp = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=-_|!:,.;]*[A-Z0-9+&@#\/%=-_|])/i', '<a href="$1" class="red-text text-lighten-2" target="_blank">$1</a>', $text);
			$exp = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/im', '$1<a href="http://$2" class="red-text text-lighten-2" target="_blank">$2</a>', $exp);
			return $exp;
		}
	}
?>