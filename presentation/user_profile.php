<?php
	class UserProfile {
		public $mCustomer;
		public $mLinkToUserProfile;
		public $mLinkToMyPosts;
		public $mLinkToLikedPosts;
		public $mLinkToAbout;
		public $mCustomerSkills;
		public $mPage = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mPostListPages = array();
		public $mMyStream = array();
		public $mLikedPosts = array();
		public $mPeopleYouFollow = array();
		public $mPeopleYouBlocked = array();
		public $mLikedPostId = array();
		public $mPeopleThatBlockedYou = array();
		public $mSiteUrl;
		public $mContentsCell = 'my_posts_tpl.php';
		public $mActiveMyPostsLink = '';
		public $mActiveLikedPostsLink = '';
		public $mActiveAboutLink = '';
		public $mLinkToEditProfile;
		public $mLinkToLoginPage;
		public $mAccessDeniedStatus;
		public $mErrorMessage;
		public $mPostId;

		private $_mUserProfile;

		public function __construct() {
			if (isset($_GET['UserProfile'])) {
				$this->_mUserProfile = (int)$_GET['UserProfile'];
			}
			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect Page value');
			}

			$this->mLinkToUserProfile = Link::ToUserProfile($this->_mUserProfile);
			$this->mLinkToMyPosts = Link::ToUserProfile($this->_mUserProfile, 'y');
			$this->mLinkToLikedPosts = Link::ToUserProfile($this->_mUserProfile, null, 'y');
			$this->mLinkToAbout = Link::ToUserProfile($this->_mUserProfile, null, null, 'y');
			$this->mLinkToEditProfile = Link::ToEditProfile();
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToLoginPage = Link::ToLoginPage();
		}

		public function init() {
			$this->mCustomer = Customer::Get($this->_mUserProfile);

			if (empty($this->mCustomer)) {
				// Clean output buffer
				ob_clean();
				// Load the 404 page
				include '404.php';
				// Clear the output buffer and stop execution
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}
			$this->mCustomerSkills = Customer::GetCustomerSkills($this->_mUserProfile);
			$this->mLikedPostId = Customer::GetLikedPostId(Customer::GetCurrentCustomerId());

			// Liked button functionality
			$liked_post = array();
			for ($i=0; $i<count($this->mLikedPostId); $i++) {
				$liked_post[$i] = $this->mLikedPostId[$i]['post_id'];
			}

			if (isset($this->mCustomer['avatar'])) {
				$this->mCustomer['avatar'] = link::Build('images/profile_pictures/'.$this->mCustomer['avatar']);
			}

			if (isset($_GET['MyPosts'])) {
				$this->mMyStream = Customer::GetCustomerPosts($this->_mUserProfile, $this->mPage, $this->mrTotalPages);

				for ($j=0; $j<count($this->mMyStream); $j++) {
					if (in_array($this->mMyStream[$j]['post_id'], $liked_post)) {
						$this->mMyStream[$j]['is_liked'] = 'yes';
					}
					else {
						$this->mMyStream[$j]['is_liked'] = 'no';
					}

					$this->mMyStream[$j]['total_likes'] = Customer::GetTotalLikedPosts($this->mMyStream[$j]['post_id']);
					$this->mMyStream[$j]['link_to_user'] = Link::ToUserProfile($this->mMyStream[$j]['customer_id']);
					$this->mMyStream[$j]['link_to_post_details'] = Link::ToPostDetails($this->mMyStream[$j]['customer_id'], $this->mMyStream[$j]['post_id']);
					$this->mMyStream[$j]['post'] = $this->_mLinkify($this->mMyStream[$j]['post']);
					$this->mMyStream[$j]['comments_count'] = Customer::GetPostCommentsCount($this->mMyStream[$j]['post_id']);
					if (!is_null($this->mMyStream[$j]['job_id'])) {
						$this->mMyStream[$j]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mMyStream[$j]['job_id']);
					}
					$this->mMyStream[$j]['post_images'] = Catalog::GetImagePosts($this->mMyStream[$j]['post_id']);
					
				}
				$this->mContentsCell = 'my_posts_tpl.php';
				$this->mActiveMyPostsLink = 'active';
			}
			elseif (isset($_GET['LikedPosts'])) {
				$this->mLikedPosts = Customer::GetLikedPosts($this->_mUserProfile, $this->mPage, $this->mrTotalPages);

				for ($k=0; $k<count($this->mLikedPosts); $k++) {
					if (in_array($this->mLikedPosts[$k]['post_id'], $liked_post)) {
						$this->mLikedPosts[$k]['is_liked'] = 'yes';
					}
					else {
						$this->mLikedPosts[$k]['is_liked'] = 'no';
					}

					$this->mLikedPosts[$k]['total_likes'] = Customer::GetTotalLikedPosts($this->mLikedPosts[$k]['post_id']);
					$this->mLikedPosts[$k]['link_to_user'] = Link::ToUserProfile($this->mLikedPosts[$k]['customer_id']);
					$this->mLikedPosts[$k]['link_to_post_details'] = Link::ToPostDetails($this->mLikedPosts[$k]['customer_id'], $this->mLikedPosts[$k]['post_id']);
					$this->mLikedPosts[$k]['post'] = $this->_mLinkify($this->mLikedPosts[$k]['post']);
					$this->mLikedPosts[$k]['comments_count'] = Customer::GetPostCommentsCount($this->mLikedPosts[$k]['post_id']);
					if (!is_null($this->mLikedPosts[$k]['job_id'])) {
						$this->mLikedPosts[$k]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mLikedPosts[$k]['job_id']);
					}
					$this->mLikedPosts[$k]['post_images'] = Catalog::GetImagePosts($this->mLikedPosts[$k]['post_id']);
				}
				$this->mContentsCell = 'liked_posts_tpl.php';
				$this->mActiveLikedPostsLink = 'active';
			}
			elseif (isset($_GET['About'])) {
				$this->mContentsCell = 'about_user_tpl.php';
				$this->mActiveAboutLink = 'active';
			}
			else {
				$this->mMyStream = Customer::GetCustomerPosts($this->_mUserProfile, $this->mPage, $this->mrTotalPages);
				for ($j=0; $j<count($this->mMyStream); $j++) {
					if (in_array($this->mMyStream[$j]['post_id'], $liked_post)) {
						$this->mMyStream[$j]['is_liked'] = 'yes';
					}
					else {
						$this->mMyStream[$j]['is_liked'] = 'no';
					}

					$this->mMyStream[$j]['total_likes'] = Customer::GetTotalLikedPosts($this->mMyStream[$j]['post_id']);
					$this->mMyStream[$j]['link_to_user'] = Link::ToUserProfile($this->mMyStream[$j]['customer_id']);
					$this->mMyStream[$j]['link_to_post_details'] = Link::ToPostDetails($this->mMyStream[$j]['customer_id'], $this->mMyStream[$j]['post_id']);
					$this->mMyStream[$j]['post'] = $this->_mLinkify($this->mMyStream[$j]['post']);
					$this->mMyStream[$j]['comments_count'] = Customer::GetPostCommentsCount($this->mMyStream[$j]['post_id']);
					if (!is_null($this->mMyStream[$j]['job_id'])) {
						$this->mMyStream[$j]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mMyStream[$j]['job_id']);
					}
					$this->mMyStream[$j]['post_images'] = Catalog::GetImagePosts($this->mMyStream[$j]['post_id']);
				}
				$this->mActiveMyPostsLink = 'active';
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

			// Unblock User functionality
			if (isset($_POST['Unblock_Post'])) {
				Customer::DeleteBlockedCustomer(null, (int)$_POST['UnblockCustomerId']);
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

			// Blocking functionality
			if (Customer::GetCurrentCustomerId() !== 0) {
				$people_you_blocked = Customer::GetPeopleYouBlocked(Customer::GetCurrentCustomerId());
				for ($j=0; $j<count($people_you_blocked); $j++) {
					$this->mPeopleYouBlocked[$j] = $people_you_blocked[$j]['blocked_customer_id'];
				}
			}
			// Has User blocked you?
			if (Customer::GetCurrentCustomerId() !== 0) {
				$people_that_blocked_you = Customer::GetPeopleYouBlocked($this->mCustomer['customer_id']);
				for ($j=0; $j<count($people_that_blocked_you); $j++) {
					$this->mPeopleThatBlockedYou[$j] = $people_that_blocked_you[$j]['blocked_customer_id'];
				}
			}

			// Posting to your profile
			if (isset($_POST['Button_Post'])) {

				if (empty($_POST['post_to_your_profile']) && !empty($_FILES['PostImage']['name']) && $_FILES['PostImage']['name'][0] != '') {
					for ($i=0; $i<count($_FILES['PostImage']['name']); $i++) {
						$check = getimagesize($_FILES['PostImage']['tmp_name'][$i]);
						if ($check == false) {
							$this->mErrorMessage = 'You must make a comment or not accepting type of image';
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
						if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'svg') {
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
				header('Location:' .$this->mLinkToUserProfile);
				exit();
			} 
			
			// Pagination functionality
			if ($this->mrTotalPages > 1) {
				// Build the Next link
				if ($this->mPage < $this->mrTotalPages) {
					if (isset($_GET['MyPosts'])) {
						$this->mLinkToNextPage = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $this->mPage + 1);
					} 
					elseif (isset($_GET['LikedPosts'])) {
						$this->mLinkToNextPage = Link::ToUserProfile($this->_mUserProfile, null, 'y', null, $this->mPage + 1);
					}
					else {
						$this->mLinkToNextPage = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $this->mPage + 1);
					}
				}
				if ($this->mPage > 1) {
					if (isset($_GET['MyPosts'])) {
						$this->mLinkToPreviousPage = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $this->mPage - 1);
					} 
					elseif (isset($_GET['LikedPosts'])) {
						$this->mLinkToPreviousPage = Link::ToUserProfile($this->_mUserProfile, null, 'y', null, $this->mPage - 1);
					}
					else {
						$this->mLinkToPreviousPage = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $this->mPage - 1);
					}
				}

				// Build the pages links
				for ($i = 1; $i <= $this->mrTotalPages; $i++) {
					if (isset($_GET['MyPosts'])) {
						$this->mPostListPages[] = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $i);
					}
					elseif (isset($_GET['LikedPosts'])) {
						$this->mPostListPages[] = $this->mLinkToPreviousPage = Link::ToUserProfile($this->_mUserProfile, null, 'y', null, $i);
					}
					else {
						$this->mPostListPages[] = Link::ToUserProfile($this->_mUserProfile, 'y', null, null, $i);
					}
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