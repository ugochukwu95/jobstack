<?php
	class Customer {

		private static $_mCustomerId;

		/*public static function SetCustomerId() {
			if (isset($_SESSION['customer_id'])) {
				self::$_mCustomerId = $_SESSION['customer_id'];
				return 1;
			}
			elseif (isset($_COOKIE['customer_id'])) {
				self::$_mCustomerId = $_COOKIE['customer_id'];
				$_SESSION['customer_id'] = self::$_mCustomerId;

				setcookie('customer_id', self::$_mCustomerId, time() + 604800);
				return 1;
			}
			else {
				return 0;
			}
		}*/

		public static function IsAuthenticated() {
			
			if (!empty($_SESSION['customer_id'])) {
				return 1;
			}
			elseif (!empty($_COOKIE['remember'])) {
				list($selector, $authenticator) = explode(':', $_COOKIE['remember']);
				$row = self::GetAuthTokens($selector);
				if (hash_equals($row['token'], hash('sha256', base64_decode($authenticator)))) {
					$_SESSION['customer_id'] = $row['customer_id'];
				}
				return 1;
			}
			else {
				return 0;
			}
		}

		public static function GetLoginInfo($email) {
			$sql = 'CALL customer_get_login_info(:email)';

			$params = array(':email' => $email);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function IsValid($email, $password) {
			$customer = self::GetLoginInfo($email);

			if (empty($customer['customer_id'])) {
				return 2;
			}

			$customer_id = $customer['customer_id'];
			$hashed_password = $customer['password'];

			if ((password_verify(HASH_PREFIX.$password, $hashed_password)) == false) {
				return 1;
			}
			else {
				setcookie('user', '', time() + 3600, '/');
				
				if (count($_COOKIE) > 0) {
					$selector = base64_encode(random_bytes(9));
					$authenticator = random_bytes(33);
					setcookie('remember', $selector . ':' . base64_encode($authenticator), time() + (86400 *30), '/');
					self::InsertAuthTokens($selector, hash('sha256', $authenticator), $customer_id, date('Y-m-d\TH:i:s', time() + time() + (86400 *30)));
				}

				$_SESSION['customer_id'] = $customer_id;
				
				self::$_mCustomerId = $customer_id;

				return 0;
			}
		}
		public static function logout() {
			self::DeleteAuthTokens((int)$_SESSION['customer_id']);
			self::$_mCustomerId = '';
			unset($_SESSION['customer_id']);
			setcookie('remember', '', time() - 3600, '/');
		}

		public static function GetCurrentCustomerId() {
			if (self::IsAuthenticated()) {
				if (!empty($_SESSION['customer_id'])) {
					return $_SESSION['customer_id'];
				}
				elseif (!empty($_COOKIE['remember'])) {
					list($selector, $authenticator) = explode(':', $_COOKIE['remember']);
					$row = self::GetAuthTokens($selector);
					if (hash_equals($row['token'], hash('sha256', base64_decode($authenticator)))) {
						$_SESSION['customer_id'] = $row['customer_id'];
						return $_SESSION['customer_id'];
					}
				}
			}
			else {
				return 0;
			}
		}

		public static function Add($email, $password, $handle, $fullName, $addAndLogin = true) {
			$hashed_password = PasswordHasher::Hash($password);

			$sql = 'CALL customer_add(:email, :password, :handle, :full_name)';

			$params = array(':email' => $email, ':password' => $hashed_password, ':handle' => $handle, ':full_name' => $fullName);

			$customer_id = DatabaseHandler::GetOne($sql, $params);

			if ($addAndLogin == true) {
				setcookie('user', '', time() + 3600, '/');
				
				if (count($_COOKIE) > 0) {
					$selector = base64_encode(random_bytes(9));
					$authenticator = random_bytes(33);
					setcookie('remember', $selector . ':' . base64_encode($authenticator), time() + (86400 *30), '/');
					self::InsertAuthTokens($selector, hash('sha256', $authenticator), $customer_id, date('Y-m-d\TH:i:s', time() + time() + (86400 *30)));
				}

				$_SESSION['customer_id'] = $customer_id;
				
			}
			return $customer_id;
		}

		public static function Get($customerId = null) {
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}
			
			$sql = 'CALL customer_get_customer(:customer_id)';
			$params = array (':customer_id' => $customerId);
			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function InsertAuthTokens($selector, $token, $customerId, $expires) {
			$sql = 'CALL customer_insert_auth_token(:selector, :token, :customer_id, :expires)';
			$params = array(':selector' => $selector, ':token' => $token, ':customer_id' => $customerId, ':expires' => $expires);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetAuthTokens($selector) {
			$sql = 'CALL customer_get_auth_token(:selector)';
			$params = array(':selector' => $selector);
			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function DeleteAuthTokens($customerId) {
			$sql = 'CALL customer_delete_auth_token(:customer_id)';
			$params = array(':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function UpdateAccountDetails($customerId = null, $email, $fullName, $handle, $hometown, $occupation, $aboutYou,
													$avatar, $university) {
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}
			$sql = 'CALL customer_update_account(:customerId, :email, :fullName, :handle, :hometown, :occupation, :aboutYou,
					:avatar, :university)';
			$params = array(':customerId' => $customerId, ':email' => $email, ':fullName' => $fullName, ':handle' => $handle, ':hometown' => $hometown, ':occupation' => $occupation, ':aboutYou' => $aboutYou, ':avatar' => $avatar, ':university' => $university);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetHandle() {
			$sql = 'CALL customer_get_handle()';
			$params = null;
			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetAUserHandle($customerId) {
			$sql = 'CALL customer_get_a_user_handle(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function GetUserAvatar($customerId = null) {
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}
			$sql = 'CALL customer_get_avatar(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		// skill functionality
		//
		//
		public static function CheckIfSkillExists($skill) {
			$sql = 'CALL customer_get_skills(:skill)';
			$params = array(':skill' => $skill);
			$skills = DatabaseHandler::GetRow($sql, $params);
			if (empty($skills)) {
				return 0;
			}
			else {
				return 1;
			}
		}
		public static function InsertNewSkill($customerId = null, $skill) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_new_skill(:customer_id, :skill)';
			$params = array(':customer_id' => $customerId, ':skill' => $skill);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function InsertIntoCustomerSkills($customerId = null, $skill) {
			
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_skills(:skill)';
			$params = array(':skill' => $skill);
			$skills = DatabaseHandler::GetRow($sql, $params);
			$skillsId = $skills['skills_id'];

			$sql = 'CALL customer_insert_into_customer_skills(:customer_id, :skill_id)';
			$params = array(':customer_id' => $customerId, ':skill_id' => $skillsId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function RemoveCustomerSkill($customerId = null, $skillsId) {
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_remove_skill(:customer_id, :skills_id)';
			$params = array(':customer_id' => $customerId, ':skills_id' =>$skillsId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function GetCustomerSkills($customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_customer_skills(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}
		// posts functionality
		//
		//
		//
		//
		//

		private static function HowManyPages($countSql, $countSqlParams) {
			// Create a hash for the sql query
			$queryHashCode = md5($countSql . var_export($countSqlParams, true));
			// Verify if we have the query results in cache
			if (isset ($_SESSION['last_post_count_hash']) && isset ($_SESSION['how_many_posts_pages']) && $_SESSION['last_post_count_hash'] === $queryHashCode) {
				// Retrieve the the cached value
				$how_many_pages = $_SESSION['how_many_posts_pages'];
			}
			else {
				// Execute the query
				$items_count = DatabaseHandler::GetOne($countSql, $countSqlParams);
				// Calculate the number of pages
				$how_many_pages = ceil($items_count / POSTS_PER_PAGE);
				// Save the query and its count result in the session
				$_SESSION['last_post_count_hash'] = $queryHashCode;
				$_SESSION['how_many_posts_pages'] = $how_many_pages;
			}
				// Return the number of pages
				return $how_many_pages;
		}

		public static function GetCustomerPosts($customerId = null, $pageNo, &$rHowManyPages) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			// Query that returns the number of posts
			$sql = 'CALL customer_count_customer_posts(:customer_id)';
			$params = array (':customer_id' => $customerId);

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_customer_posts(:customer_id, :start_item, :posts_per_page)';
			$params = array(':customer_id' => $customerId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE); 

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetOnlineCustomerPosts($customerId = null, $pageNo, &$rHowManyPages) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			// Query that returns the number of posts
			$sql = 'CALL customer_count_online_posts(:customer_id)';
			$params = array (':customer_id' => $customerId);

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_online_posts(:customer_id, :start_item, :posts_per_page)';
			$params = array(':customer_id' => $customerId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE); 

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetLikedPosts($customerId = null, $pageNo, &$rHowManyPages) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			// Query that returns the number of posts
			$sql = 'CALL customer_count_liked_posts(:customer_id)';
			$params = array (':customer_id' => $customerId);

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_liked_posts(:customer_id, :start_item, :posts_per_page)';
			$params = array(':customer_id' => $customerId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE); 

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetOfflineCustomerPosts($pageNo, &$rHowManyPages) {

			// Query that returns the number of posts
			$sql = 'CALL customer_count_offline_posts()';
			$params = null;

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_offline_posts(:start_item, :posts_per_page)';
			$params = array(':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE); 

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetFrontPageCustomerPosts($pageNo, &$rHowManyPages) {

			// Query that returns the number of posts
			$sql = 'CALL customer_count_offline_posts()';
			$params = null;

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * FRONT_PAGE_POSTS;

			$sql = 'CALL customer_get_offline_posts(:start_item, :posts_per_page)';
			$params = array(':start_item' => $start_item, ':posts_per_page' => FRONT_PAGE_POSTS); 

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetOnlinePopularTagsDetails($jobId, $customerId = null, $pageNo, &$rHowManyPages) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			// Query that returns the number of posts
			$sql = 'CALL customer_count_online_popular_tag_details(:job_id, :customer_id)';
			$params = array (':job_id' => $jobId, ':customer_id' => $customerId);

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_online_popular_tag_details(:customer_id, :job_id, :start_item, :posts_per_page)';
			$params = array(':customer_id' => $customerId, ':job_id' => $jobId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE);  

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetOfflinePopularTagsDetails($jobId, $pageNo, &$rHowManyPages) {

			// Query that returns the number of posts
			$sql = 'CALL customer_count_offline_popular_tag_details(:job_id)';
			$params = array (':job_id' => $jobId);

			// Calculate the number of pages required to display the posts
			$rHowManyPages = Customer::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;

			$sql = 'CALL customer_get_offline_popular_tag_details(:job_id, :start_item, :posts_per_page)';
			$params = array(':job_id' => $jobId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE); 

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetOnlineRelatedPosts($jobId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_online_popular_tag_details(:customer_id, :job_id, :start_item, :posts_per_page)';
			$params = array(':customer_id' => $customerId, ':job_id' => $jobId, ':start_item' => 0, ':posts_per_page' => 3);  

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetPeopleYouFollow($customerId) {
			$sql = 'CALL customer_get_people_you_follow(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetPeopleYouBlocked($customerId) {
			$sql = 'CALL customer_get_people_you_blocked(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function FollowCustomer($customerId = null, $followCustomerId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_follow_user(:customer_id, :follow_customer_id)';
			$params = array(':customer_id' => $customerId, ':follow_customer_id' => $followCustomerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function UnfollowCustomer($customerId = null, $unfollowCustomerId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_unfollow_user(:customer_id, :unfollow_customer_id)';
			$params = array(':customer_id' => $customerId, ':unfollow_customer_id' => $unfollowCustomerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function InsertIntoPosts($post, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_user_post(:customer_id, :post)';
			$params = array(':customer_id' => $customerId, ':post' => $post);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function InsertIntoPostsWithTag($post, $jobId, $customerId = null) {
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_user_post_with_tag(:customer_id, :post, :job_id)';
			$params = array(':customer_id' => $customerId, ':post' => $post, ':job_id' => $jobId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		
		public static function DeleteLikesPosts($customerId = null, $postId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_likes_posts(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function InsertLikesPosts($customerId = null, $postId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_likes_posts(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function GetLikedPostId($customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_liked_post_id(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetTotalLikedPosts($postId) {
			$sql = 'CALL count_liked_customer_posts(:post_id)';
			$params = array(':post_id' => $postId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function GetPostDetails($postId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_a_post(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			return DatabaseHandler::GetRow($sql, $params);
		}
		public static function GetPostCommentsCount($postId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_count_post_comments(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, 'customer_id' => $customerId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function GetPostComments($postId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_post_comments(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function InsertComment($customerId = null, $postId, $comment) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_into_comments(:customer_id, :post_id, :comment)';
			$params = array(':customer_id' => $customerId, ':post_id' => $postId, ':comment' => $comment);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function HideComment($customerId, $commentId) {
			$sql = 'CALL customer_hide_comment(:customer_id, :comment_id)';
			$params = array(':customer_id' => $customerId, ':comment_id' => $commentId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function DeleteComment($commentId, $customerId = null) {
			
			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_comment(:comment_id, :customer_id)';
			$params = array(':comment_id' => $commentId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function ReportComment($customerId, $commentId) {
			$sql = 'CALL customer_report_comment(:customer_id, :comment_id)';
			$params = array(':customer_id' => $customerId, ':comment_id' => $commentId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function LikeComment($commentId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_like_comment(:comment_id, :customer_id)';
			$params = array(':comment_id' => $commentId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function DeleteLikeComment($commentId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_like_comment(:comment_id, :customer_id)';
			$params = array(':comment_id' => $commentId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function DislikeComment($commentId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_dislike_comment(:comment_id, :customer_id)';
			$params = array(':comment_id' => $commentId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function DeleteDislikeComment($commentId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_dislike_comment(:comment_id, :customer_id)';
			$params = array(':comment_id' => $commentId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function GetLikedCommentsCount($commentId) {
			$sql = 'CALL customer_count_like_comments(:comment_id)';
			$params = array(':comment_id' => $commentId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function GetDislikedCommentsCount($commentId) {
			$sql = 'CALL customer_count_dislike_comments(:comment_id)';
			$params = array(':comment_id' => $commentId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		public static function GetLikedCommentId($customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_liked_comment_id(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function GetDislikedCommentId($customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_get_disliked_comment_id(:customer_id)';
			$params = array(':customer_id' => $customerId);
			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function DeleteCustomerPost($postId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_post(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function InsertHiddenPost($postId, $customerId = null) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_hidden_post(:post_id, :customer_id)';
			$params = array(':post_id' => $postId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function InsertBlockedCustomer($customerId = null, $blockedCustomerId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_insert_blocked_customer(:customer_id, :blocked_customer_id)';
			$params = array(':customer_id' => $customerId, ':blocked_customer_id' => $blockedCustomerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function DeleteBlockedCustomer($customerId = null, $unblockedCustomerId) {

			if (is_null($customerId)) {
				$customerId = self::GetCurrentCustomerId();
			}

			$sql = 'CALL customer_delete_blocked_customer(:customer_id, :unblocked_customer_id)';
			$params = array(':customer_id' => $customerId, ':unblocked_customer_id' => $unblockedCustomerId);
			DatabaseHandler::Execute($sql, $params);
		}
		public static function ReportPost($customerId, $postId) {
			$sql = 'CALL customer_report_post(:customer_id, :post_id)';
			$params = array(':customer_id' => $customerId, ':post_id' => $postId);
			DatabaseHandler::Execute($sql, $params);
		}
	}
?>
