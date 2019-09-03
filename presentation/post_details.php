<?php
	class PostDetails {
		public $mPostDetails = array();
		public $mPeopleYouFollow = array();
		public $mLikedPostId = array();
		public $mCommentsCount = '0';
		public $mComments = array();
		public $mLikedCommentId = array();
		public $mDislikedCommentId = array();
		public $mHandleCommenter;
		public $mAvatarCommenter;
		public $mLinkToUserCommenter;
		public $mLinkToLoginPage;
		public $mErrorMessage;
		public $mCommentId;

		public $mUserId;
		public $mPostId;
		public $mLinkToPostDetails;
		public $mSiteUrl;

		public function __construct() {
			if (isset($_GET['PostId'])) {
				$this->mPostId = (int)$_GET['PostId'];
			}
			else {
				trigger_error('Post details id not set');
			}

			if (isset($_GET['UserId'])) {
				$this->mUserId = (int)$_GET['UserId'];
			}
			else {
				trigger_error('User id not set');
			}
			$this->mLinkToPostDetails = Link::ToPostDetails($this->mUserId, $this->mPostId);
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToLoginPage = Link::ToLoginPage();
		}

		private function _mLinkify($text) {
			$exp = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=-_|!:,.;]*[A-Z0-9+&@#\/%=-_|])/i', '<a href="$1" class="red-text text-lighten-2" target="_blank">$1</a>', $text);
			$exp = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/im', '$1<a href="http://$2" class="red-text text-lighten-2" target="_blank">$2</a>', $exp);
			return $exp;
		}

		public function init() {
			$this->mPostDetails = Customer::GetPostDetails($this->mPostId);
			if (empty($this->mPostDetails)) {
				// Clean output buffer
				ob_clean();
				// Load the 404 page
				include 'post_deleted.php';
				// Clear the output buffer and stop execution
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}
			$this->mPostDetails['link_to_user'] = Link::ToUserProfile($this->mPostDetails['customer_id']);
			$this->mPostDetails['total_likes'] = Customer::GetTotalLikedPosts($this->mPostDetails['post_id']);
			$this->mPostDetails['post'] = $this->_mLinkify($this->mPostDetails['post']);
			$this->mPostDetails['post_images'] = Catalog::GetImagePosts($this->mPostDetails['post_id']);
			if (!is_null($this->mPostDetails['job_id'])) {
				$this->mPostDetails['link_to_popular_tags_page'] = Link::ToPopularTags($this->mPostDetails['job_id']);
			}
			$this->mLikedPostId = Customer::GetLikedPostId(Customer::GetCurrentCustomerId());

			// Liked button functionality
			$liked_post = array();
			for ($i=0; $i<count($this->mLikedPostId); $i++) {
				$liked_post[$i] = $this->mLikedPostId[$i]['post_id'];
			}
			if (in_array($this->mPostDetails['post_id'], $liked_post)) {
				$this->mPostDetails['is_liked'] = 'yes';
			}
			else {
				$this->mPostDetails['is_liked'] = 'no';
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

			// Comments functionality
			//
			//
			//

			$this->mCommentsCount = Customer::GetPostCommentsCount($this->mPostDetails['post_id']);
			$this->mComments = Customer::GetPostComments($this->mPostDetails['post_id']);

			// Liked and Dislikes comments
			$this->mLikedCommentId = Customer::GetLikedCommentId((int)Customer::GetCurrentCustomerId());
			$liked_comment_array = array();
			for ($i=0; $i<count($this->mLikedCommentId); $i++) {
				$liked_comment_array[$i] = $this->mLikedCommentId[$i]['comment_id'];
			}
			//
			$this->mDislikedCommentId = Customer::GetDislikedCommentId((int)Customer::GetCurrentCustomerId());
			$disliked_comment_array = array();
			for ($i=0; $i<count($this->mDislikedCommentId); $i++) {
				$disliked_comment_array[$i] = $this->mDislikedCommentId[$i]['comment_id'];
			}

			//
			//

			for ($i=0; $i<count($this->mComments); $i++) {
				$this->mComments[$i]['link_to_user'] = Link::ToUserProfile($this->mComments[$i]['customer_id']);
				if (in_array($this->mComments[$i]['comment_id'], $liked_comment_array)) {
					$this->mComments[$i]['is_liked'] = 'yes';
				}
				else {
					$this->mComments[$i]['is_liked'] = 'no';
				}

				if (in_array($this->mComments[$i]['comment_id'], $disliked_comment_array)) {
					$this->mComments[$i]['is_disliked'] = 'yes';
				}
				else {
					$this->mComments[$i]['is_disliked'] = 'no';
				}

				$this->mComments[$i]['total_likes'] = Customer::GetLikedCommentsCount($this->mComments[$i]['comment_id']);
				$this->mComments[$i]['total_dislikes'] = Customer::GetDislikedCommentsCount($this->mComments[$i]['comment_id']);
				$this->mComments[$i]['comment'] = $this->_mLinkify($this->mComments[$i]['comment']);
				$this->mComments[$i]['comment_images'] = Catalog::GetImageComments($this->mComments[$i]['comment_id']);
			}

			// Get current commenter
			$this->mHandleCommenter = Customer::GetAUserHandle(Customer::GetCurrentCustomerId());
			$this->mAvatarCommenter = Customer::GetUserAvatar();
			$this->mLinkToUserCommenter = Link::ToUserProfile(Customer::GetCurrentCustomerId());

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];

			if (isset($_POST['InsertComment'])) {
				if (empty($_POST['Comment']) && !empty($_FILES['CommentImage']['name']) && $_FILES['CommentImage']['name'][0] != '') {
					for ($i=0; $i<count($_FILES['CommentImage']['name']); $i++) {
						$check = getimagesize($_FILES['CommentImage']['tmp_name'][$i]);
						if ($check == false) {
							$this->mErrorMessage = 'You must make a comment';
							return;
						}
						else {
							$this->mCommentId = Customer::InsertComment(Customer::GetCurrentCustomerId(), $this->mPostDetails['post_id'], trim(htmlspecialchars($_POST['Comment'])));
							break;
						}
					}
				}
				else {
					if (count($_FILES['CommentImage']['name']) > 4) {
						$this->mErrorMessage = 'You cannot upload more than four(4) images';
						return;
					}
					$this->mCommentId = Customer::InsertComment(Customer::GetCurrentCustomerId(), $this->mPostDetails['post_id'], trim(htmlspecialchars($_POST['Comment'])));
				}

				if (!empty($_FILES['CommentImage']['name']) && $_FILES['CommentImage']['name'][0] != '') {
					
					$target_dir = SITE_ROOT . '/images/comment_images/';
					if (count($_FILES['CommentImage']['name']) > 4) {
						$this->mErrorMessage = 'You cannot upload more than four(4) images';
						return;
					}
					for ($i=0; $i<count($_FILES['CommentImage']['name']); $i++) {
						$target_file = $target_dir . basename($_FILES['CommentImage']['name'][$i]); 
						$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
						
						// Check if image is a actual image or fake image
						$check = getimagesize($_FILES['CommentImage']['tmp_name'][$i]);
						if ($check == false) {
							$this->mErrorMessage = 'File is not an image.';
							return;
						}

						// Allow certain file formats
						if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
							$this->mErrorMessage = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed.';
							return;
						}

						if (move_uploaded_file($_FILES['CommentImage']['tmp_name'][$i], $target_file)) {
							Catalog::InsertImageComments($this->mCommentId, $_FILES['CommentImage']['name'][$i]);
						}
						else {
							$this->mErrorMessage = 'Sorry, there was an error uploading your file.';
						}
					}
				}
				header('Location:' . $this->mLinkToPostDetails);
				exit();
			}
			if (isset($_POST['Delete_Comment'])) {
				Customer::DeleteComment((int)$_POST['CommentId'], (int)Customer::GetCurrentCustomerId());
				Catalog::DeleteImageComments((int)$_POST['CommentId']);
			}
			if (isset($_POST['Hide_Comment'])) {
				Customer::HideComment((int)Customer::GetCurrentCustomerId(),(int)$_POST['CommentId']);
			}
			// Report Functionality
			if (isset($_POST['Report_Comment'])) {
				Customer::ReportComment((int)$_POST['CustomerId'], (int)$_POST['CommentId']);
			}

			// Like Comment
			if (isset($_POST['Like_Comment'])) {
				Customer::LikeComment((int)$_POST['CommentId']);
			}

			// Delete Like Comment
			if (isset($_POST['Delete_Like_Comment'])) {
				Customer::DeleteLikeComment((int)$_POST['CommentId']);
			}

			// Dislike Comment
			if (isset($_POST['Dislike_Comment'])) {
				Customer::DislikeComment((int)$_POST['CommentId']);
			}

			// Delete Like Comment
			if (isset($_POST['Delete_Dislike_Comment'])) {
				Customer::DeleteDislikeComment((int)$_POST['CommentId']);
			}
		}
	}
?>