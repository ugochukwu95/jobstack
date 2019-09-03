<?php
	class PasswordHasher {

		private function __construct() {}

		public static function Hash($password, $withPrefix = true) {
			if ($withPrefix) {
				$hashed_password = password_hash(HASH_PREFIX.$password, PASSWORD_DEFAULT);
			}
			else {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			}
			return $hashed_password;
		}
	}
?>