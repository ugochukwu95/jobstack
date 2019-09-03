<?php
	class SavedJobsCart {
		private static $_mCartId;

		private function __construct() {}

		public static function SetCartId () {
			if (self::$_mCartId == '') {
				if (isset($_SESSION['cart_id'])) {
					self::$_mCartId = $_SESSION['cart_id'];
				}
				elseif (isset($_COOKIE['cart_id'])) {
					self::$_mCartId = $_COOKIE['cart_id'];
					$_SESSION['cart_id'] = self::$_mCartId;

					// Regenerate cookie to be valid for 7 days (604800 seconds)
					setcookie('cart_id', self::$_mCartId, time() + 604800);
				}
				else {
					self::$_mCartId = md5(uniqid(rand(), true));

					// Store cart id in session
					$_SESSION['cart_id'] = self::$_mCartId;
					// Cookie will be valid for 7 days (604800 seconds)
					setcookie('cart_id', self::$_mCartId, time() + 604800);
				}
			}
		}
 
		public static function GetCartId() {
			// Ensure we have a cart id for the current visitor
			if (!isset (self::$_mCartId)) {
				self::SetCartId();
			}

			return self::$_mCartId;
		}

		// Pagination functionality
		private static function HowManyPages($countSql, $countSqlParams = null) {
			$queryHashCode = md5($countSql . var_export($countSqlParams, true));

			if (isset ($_SESSION['last_count_hash']) && isset ($_SESSION['how_many_pages']) && $_SESSION['last_count_hash'] === $queryHashCode) {
				// Retrieve the the cached value
				$how_many_pages = $_SESSION['how_many_pages'];
			}
			else {
				// Execute the query
				$items_count = DatabaseHandler::GetOne($countSql, $countSqlParams);

				// Calculate the number of pages
				$how_many_pages = ceil($items_count / JOBS_PER_PAGE);
				// Save the query and its count result in the session
				$_SESSION['last_count_hash'] = $queryHashCode;
				$_SESSION['how_many_pages'] = $how_many_pages;
			}
			// Return the number of pages
			return $how_many_pages;

		}

		public static function AddJob($jobId) {
			$sql = 'CALL saved_jobs_cart_add_job(:cart_id, :job_id)';

			$params = array(':cart_id' => self::GetCartId(), ':job_id' => $jobId);

			DatabaseHandler::GetOne($sql, $params);
		}

		public static function RemoveJob($jobId) {
			$sql = 'CALL saved_jobs_cart_remove_jobs(:cart_id, :job_id)';

			$params = array(':cart_id' => self::GetCartId(), ':job_id' => $jobId);

			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetCartJobs($pageNo, &$rHowManyPages) {

			// Query that returns the number of jobs
			$sql = 'CALL saved_jobs_cart_get_total_amount(:cart_id)';

			$params = array(':cart_id' => self::GetCartId());

			// Calculate the number of pages required to display the products
			$rHowManyPages = SavedJobsCart::HowManyPages($sql, $params);

			// Calculate the start item
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;

			$sql = 'CALL saved_jobs_cart_get_jobs(:cart_id, :in_short_description_length, :inStart_item, :inJobs_per_page)';

			$params = array(':cart_id' => self::GetCartId(), ':in_short_description_length' => SHORT_JOB_DESCRIPTION_LENGTH, 
				':inStart_item' => $start_item, ':inJobs_per_page' => JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetTotalAmount() {
			// Query that returns the number of jobs
			$sql = 'CALL saved_jobs_cart_get_total_amount(:cart_id)';

			$params = array(':cart_id' => self::GetCartId());

			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetSavedJobsJobId() {
			$sql = 'CALL saved_jobs_cart_get_job_id(:cart_id)';

			$params = array(':cart_id' => self::GetCartId());

			return DatabaseHandler::GetAll($sql, $params);
		}
	}
?>