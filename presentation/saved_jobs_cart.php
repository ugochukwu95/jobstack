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

		public static function AddJob($jobId) {
			$sql = 'CALL saved_jobs_cart(:cart_id, :job_id)';

			$params = array(':cart_id' => self::GetCartId(), ':job_id' => $jobId);

			DatabaseHandler::Execute($sql, $params);
		}
	}
?>