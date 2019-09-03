<?php
	class Catalog {
		// Main Site Functionality
		//
		//
		//
		//



		// Catalog search functionality
		//
		//
		//
		//
		//


		// Calculates total pages for pagination functionality
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

		// Calculates total posts pages for pagination functionality
		private static function HowManyPostsPages($countSql, $countSqlParams = null) {
			$queryHashCode = md5($countSql . var_export($countSqlParams, true));

			if (isset ($_SESSION['last_count_hash']) && isset ($_SESSION['how_many_posts_pages']) && $_SESSION['last_count_hash'] === $queryHashCode) {
				// Retrieve the the cached value
				$how_many_posts_pages = $_SESSION['how_many_posts_pages'];
			}
			else {
				// Execute the query
				$items_count = DatabaseHandler::GetOne($countSql, $countSqlParams);

				// Calculate the number of pages
				$how_many_posts_pages = ceil($items_count / POSTS_PER_PAGE);
				// Save the query and its count result in the session
				$_SESSION['last_count_hash'] = $queryHashCode;
				$_SESSION['how_many_posts_pages'] = $how_many_posts_pages;
			}
			// Return the number of pages
			return $how_many_posts_pages;

		}

		// Searching the Sites Job Catalog
		public static function CatalogSearch($searchString, $allWords, $pageNo, &$rHowManyPages) {
			$search_result = array('accepted_words'=>array(), 'jobs'=>array(), 'ignored_words'=>array());

			if (empty($searchString)) {
				return $search_result;
			}

			$delimiters = ' .;,';

			$word = strtok($searchString, $delimiters);
			while ($word) {
				if (strlen($word) < FT_MIN_WORD_LEN) {
					$search_result['ignored_words'][] = $word;
				}
				else {
					$search_result['accepted_words'][] = $word;
				}
				$word = strtok($delimiters);
			}

			if (count($search_result['accepted_words']) == 0) {
				return $search_result;
			}

			// Build the search string from accepted words list
			$search_string = '';

			// If $allWords is 'on' then we append a ' +' to each word
			if (strcmp($allWords, 'on') == 0) {
				$search_string = implode(' +', $search_result['accepted_words']);
			}
			else {
				$search_string = implode(' ', $search_result['accepted_words']);
			}

			// count the number of search results
			$sql = 'CALL catalog_count_search_result(:search_string, :all_words)';
			$params = array(':search_string'=>$search_string, 'all_words'=>$allWords);

			$rHowManyPages = Catalog::HowManyPages($sql, $params);
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;

			$sql = 'CALL catalog_search(:search_string, :all_words, :short_job_description_length, :start_item, :jobs_per_page)';
			$params = array(':search_string' => $search_string, ':all_words' => $allWords, ':short_job_description_length' => SHORT_JOB_DESCRIPTION_LENGTH, ':start_item' => $start_item, ':jobs_per_page' => JOBS_PER_PAGE);

			// Execute the query
			$search_result['jobs'] = DatabaseHandler::GetAll($sql, $params);
			// Return the results
			return $search_result;

		}
		
		// Similar jobs functionality
		//
		//
		//

        public static function GetSixSimilarJobs($searchString, $jobid) {
			$search_result = array('accepted_words'=>array(), 'jobs'=>array(), 'ignored_words'=>array(), 'items_count' => array());

			if (empty($searchString)) {
				return $search_result;
			}

			$delimiters = ' .;,';

			$word = strtok($searchString, $delimiters);
			while ($word) {
				if (strlen($word) < FT_MIN_WORD_LEN) {
					$search_result['ignored_words'][] = $word;
				}
				else {
					$search_result['accepted_words'][] = $word;
				}
				$word = strtok($delimiters);
			}

			if (count($search_result['accepted_words']) == 0) {
				return $search_result;
			}

			// Build the search string from accepted words list
			$search_string = '';

			$search_string = implode(' ', $search_result['accepted_words']);
			
			// Count Similar jobs
			$sql = 'CALL catalog_count_similar_jobs(:search_string)';
			$params = array(':search_string' => $search_string);
			$items_count = DatabaseHandler::GetOne($sql, $params);

			$sql = 'CALL catalog_get_six_similar_jobs(:search_string, :similar_jobs_count, :position)';
			$params = array(':search_string' => $search_string, ':similar_jobs_count' => SIMILAR_JOBS_AMOUNT, ':position' => $jobid);

			// Execute the query
			$search_result['jobs'] = DatabaseHandler::GetAll($sql, $params);
			$search_result['items_count'] = $items_count;
			
			// Return the results
			return $search_result;

		}	

		// Job reviews functionality
		//
		//
		//
		//
		public static function GetJobReviews($jobId, $reviewsPerPage) {
			$sql = 'CALL catalog_get_job_reviews(:job_id, :reviews_per_page)';
			$params = array(':job_id' => $jobId, ':reviews_per_page' => $reviewsPerPage);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function CountJobReviews($jobId) {
			$sql = 'CALL catalog_count_job_reviews(:job_id)';
			$params = array(':job_id' => $jobId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetMoreJobReviews ($jobId, $pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_job_reviews(:job_id)';
			$params = array(':job_id' => $jobId);

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPostsPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;
			$sql = 'CALL catalog_get_more_job_reviews(:job_id, :start_item, :posts_per_page)';
			$params = array(':job_id' => $jobId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function CreateJobReview($customer_id, $job_id, $review) {
			$sql = 'CALL catalog_create_job_review(:customer_id, :job_id, :review)';
			$params = array(':customer_id' => $customer_id, ':job_id' => $job_id, ':review' => $review);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function DeleteDislikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_delete_disliked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function DeleteLikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_delete_liked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetLikedReviews($reviewId) {
			$sql = 'CALL catalog_get_liked_reviews(:review_id)';
			$params = array(':review_id' => $reviewId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetDislikedReviews($reviewId) {
			$sql = 'CALL catalog_get_disliked_reviews(:review_id)';
			$params = array(':review_id' => $reviewId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function InsertLikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_insert_liked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}


		public static function InsertDislikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_insert_disliked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, ':customer_id' => $customerId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function CustomerGetLikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_get_if_customer_liked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, 'customer_id' => $customerId);
			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function CustomerGetDislikedReview($reviewId, $customerId) {
			$sql = 'CALL catalog_get_if_customer_disliked_review(:review_id, :customer_id)';
			$params = array(':review_id' => $reviewId, 'customer_id' => $customerId);
			return DatabaseHandler::GetRow($sql, $params);
		}

		// Company review functionality
		//
		//
		//
		//
		public static function GetCompanyReviews($companyId, $reviewsPerPage) {
			$sql = 'CALL catalog_get_company_reviews(:company_id, :reviews_per_page)';
			$params = array(':company_id' => $companyId, ':reviews_per_page' => $reviewsPerPage);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function CountCompanyReviews($companyId) {
			$sql = 'CALL catalog_count_company_reviews(:company_id)';
			$params = array(':company_id' => $companyId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetMoreCompanyReviews ($companyId, $pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_company_reviews(:company_id)';
			$params = array(':company_id' => $companyId);

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPostsPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;
			$sql = 'CALL catalog_get_more_company_reviews(:company_id, :start_item, :posts_per_page)';
			$params = array(':company_id' => $companyId, ':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function CreateCompanyReview($customer_id, $companyId, $review, $rating) {
			$sql = 'CALL catalog_create_company_review(:customer_id, :company_id, :review, :rating)';
			$params = array(':customer_id' => $customer_id, ':company_id' => $companyId, ':review' => $review, ':rating' => $rating);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetJobsBelongingToCompany($companyId, $pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_jobs_belonging_to_company(:company_id)';
			$params = array(':company_id' => $companyId);

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, $params);

			// Calculate the start item
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_jobs_belonging_to_company(:company_id, :start_item, :jobs_per_page)';
			$params = array(':company_id' => $companyId, ':start_item' => $start_item, ':jobs_per_page' => JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function DeleteReview($reviewId) {
			$sql = 'CALL catalog_delete_review(:review_id)';
			$params = array(':review_id' => $reviewId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function DeleteCompanyReview($reviewId) {
			$sql = 'CALL catalog_delete_company_review(:review_id)';
			$params = array(':review_id' => $reviewId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetACompanyReview($reviewId) {
			$sql = 'CALL catalog_get_a_company_review(:review_id)';
			$params = array(':review_id' => $reviewId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		// Get highest trending tags this month
		public static function GetHighestTrendingTags() {
			$sql = 'CALL catalog_get_highest_trending_tags()';
			$params = null;
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function InsertDeveloperMessage($firstName, $lastName, $email, $phoneNumber, $message) {
			$sql = 'CALL catalog_insert_developer_message(:first_name, :last_name, :email, :phone_number, :message)';
			$params = array(':first_name' => $firstName, ':last_name' => $lastName, ':email' => $email, ':phone_number' => $phoneNumber, ':message' => $message);
			DatabaseHandler::Execute($sql, $params);
		}

        public static function InsertSubscriber($name, $email, $hash) {
            $sql = 'CALL catalog_insert_subscriber(:name, :email, :hash)';
            $params = array(':name' => $name, ':email' => $email, ':hash' => $hash);
            DatabaseHandler::Execute($sql, $params);
        }
        
        public static function GetHighestRecruitingLocations() {
            $sql = 'CALL catalog_get_highest_recruiting_locations(:HIGHEST_RECRUITING_LOCATIONS_COUNT)';
            $params = array(':HIGHEST_RECRUITING_LOCATIONS_COUNT' => HIGHEST_RECRUITING_LOCATIONS_COUNT);
            return DatabaseHandler::GetAll($sql, $params);
        }
        
        public static function CountJobsInLocation($id) {
            $sql = 'CALL catalog_count_jobs_in_location(:id)';
            $params = array(':id' => $id);
            return DatabaseHandler::GetOne($sql, $params);
        }
        public static function GetJobsBelongingToLocation($locationId, $pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_jobs_belonging_to_location(:location_id)';
			$params = array(':location_id' => $locationId);

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, $params);

			// Calculate the start item
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_jobs_belonging_to_location(:location_id, :start_item, :jobs_per_page)';
			$params = array(':location_id' => $locationId, ':start_item' => $start_item, ':jobs_per_page' => JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}
		
		public static function GetHighestRecruitingCompanies() {
		    $sql = 'CALL catalog_get_highest_recruiting_companies(:HIGHEST_RECRUITING_COMPANIES_COUNT)';
		    $params = array(':HIGHEST_RECRUITING_COMPANIES_COUNT' => HIGHEST_RECRUITING_COMPANIES_COUNT);
		    return DatabaseHandler::GetAll($sql, $params);
		}
		public static function CountJobsInCompany($id) {
            $sql = 'CALL catalog_count_jobs_belonging_to_company(:id)';
            $params = array(':id' => $id);
            return DatabaseHandler::GetOne($sql, $params);
        }
        
        // User job post functionality
        //
        //
        //
        public static function InsertUserJob($companyName, $companyWebsite, $cac, $email, $phoneNumber, $positionName, $jobCategory, $jobLocation, $appDeadline, $jobDescription) {
            $sql = 'CALL catalog_insert_user_job(:company_name, :company_website, :cac, :email, :phone_number, :position_name, :job_category, :job_location, :app_deadline, :job_description)';
            $params = array(':company_name' => $companyName, ':company_website' => $companyWebsite, ':cac' => $cac, ':email' => $email, ':phone_number' => $phoneNumber, ':position_name' => $positionName, 
                ':job_category' => $jobCategory, ':job_location' => $jobLocation, ':app_deadline' => $appDeadline, ':job_description' => $jobDescription);
            DatabaseHandler::Execute($sql, $params);
        }
        
        public static function DeleteUserJob($id) {
            $sql = 'CALL catalog_delete_user_job(:id)';
            $params = array(':id' => $id);
            DatabaseHandler::Execute($sql, $params);
        }
        
        public static function GetUsersJobs($pageNo, &$rHowManyPages) {
            // Query that returns the number of jobs
			$sql = 'CALL catalog_count_users_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			
			// Calculate the start item
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;
			
			$sql = 'CALL catalog_get_user_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
        }
        
        public static function GetUserJobDetails($id) {
            $sql = 'CALL catalog_get_user_job_details(:id)';
            $params = array(':id' => $id);
            return DatabaseHandler::GetRow($sql, $params);
        }

		// Admin jobs search functionality
		//
		//
		//
		public static function Search($searchString, $allWords, $pageNo, &$rHowManyPages) {
			$search_result = array('accepted_words'=>array(), 'jobs'=>array(), 'ignored_words'=>array());

			if (empty($searchString)) {
				return $search_result;
			}

			$delimiters = ' .;,';

			$word = strtok($searchString, $delimiters);
			while ($word) {
				if (strlen($word) < FT_MIN_WORD_LEN) {
					$search_result['ignored_words'][] = $word;
				}
				else {
					$search_result['accepted_words'][] = $word;
				}
				$word = strtok($delimiters);
			}

			if (count($search_result['accepted_words']) == 0) {
				return $search_result;
			}

			// Build the search string from accepted words list
			$search_string = '';

			// If $allWords is 'on' then we append a ' +' to each word
			if (strcmp($allWords, 'on') == 0) {
				$search_string = implode(' +', $search_result['accepted_words']);
			}
			else {
				$search_string = implode(' ', $search_result['accepted_words']);
			}

			// count the number of search results
			$sql = 'CALL jobs_count_search_result(:search_string, :all_words)';
			$params = array(':search_string'=>$search_string, 'all_words'=>$allWords);

			$rHowManyPages = Catalog::HowManyPages($sql, $params);
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			$sql = 'CALL jobs_search(:search_string, :all_words, :jobs_per_page, :start_item)';
			$params = array(':search_string' => $search_string, ':all_words' => $allWords, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE,
				':start_item' => $start_item);

			// Execute the query
			$search_result['jobs'] = DatabaseHandler::GetAll($sql, $params);

			// Return the results
			return $search_result;

		}

		// Admin company search functionality
		public static function companySearch($searchString, $allWords, $pageNo, &$rHowManyPages) {
			$search_result = array('accepted_words'=>array(), 'companies'=>array(), 'ignored_words'=>array());

			if (empty($searchString)) {
				return $search_result;
			}

			$delimiters = ' .;,';

			$word = strtok($searchString, $delimiters);

			while ($word) {
				if (strlen($word) < FT_MIN_WORD_LEN) {
					$search_result['ignored_words'][] = $word;
				}
				else {
					$search_result['accepted_words'][] = $word;
				}
				$word = strtok($delimiters);
			}

			if (count($search_result['accepted_words']) == 0) {
				return $search_result;
			}

			// Build the search string from accepted words list
			$search_string = '';

			// If $allWords is 'on' then we append a ' +' to each word
			if (strcmp($allWords, 'on') == 0) {
				$search_string = implode(' +', $search_result['accepted_words']);
			}
			else {
				$search_string = implode(' ', $search_result['accepted_words']);
			}

			// count the number of search results
			$sql = 'CALL companies_count_search_results(:search_string, :all_words)';
			$params = array(':search_string'=>$search_string, 'all_words'=>$allWords);

			$rHowManyPages = Catalog::HowManyPages($sql, $params);

			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			$sql = 'CALL companies_search(:search_string, :all_words, :short_job_description_length, :start_item, :jobs_per_page)';
			$params = array(':search_string' => $search_string, ':all_words' => $allWords, ':short_job_description_length' => SHORT_JOB_DESCRIPTION_LENGTH, ':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			// Execute the query
			$search_result['companies'] = DatabaseHandler::GetAll($sql, $params);

			// Return the results
			return $search_result;

		}

		// Admin company search functionality
		public static function userSearch($searchString, $allWords, $pageNo, &$rHowManyPages) {
			$search_result = array('accepted_words'=>array(), 'users'=>array(), 'ignored_words'=>array());

			if (empty($searchString)) {
				return $search_result;
			}

			$delimiters = ' .;,';

			$word = strtok($searchString, $delimiters);

			while ($word) {
				if (strlen($word) < FT_MIN_WORD_LEN) {
					$search_result['ignored_words'][] = $word;
				}
				else {
					$search_result['accepted_words'][] = $word;
				}
				$word = strtok($delimiters);
			}

			if (count($search_result['accepted_words']) == 0) {
				return $search_result;
			}

			// Build the search string from accepted words list
			$search_string = '';

			// If $allWords is 'on' then we append a ' +' to each word
			if (strcmp($allWords, 'on') == 0) {
				$search_string = implode(' +', $search_result['accepted_words']);
			}
			else {
				$search_string = implode(' ', $search_result['accepted_words']);
			}

			// count the number of search results
			$sql = 'CALL users_count_search_results(:search_string, :all_words)';
			$params = array(':search_string'=>$search_string, 'all_words'=>$allWords);

			$rHowManyPages = Catalog::HowManyPages($sql, $params);

			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			$sql = 'CALL users_search(:search_string, :all_words, :start_item, :users_per_page)';
			$params = array(':search_string' => $search_string, ':all_words' => $allWords, ':start_item' => $start_item, ':users_per_page' => ADMIN_JOBS_PER_PAGE);

			// Execute the query
			$search_result['users'] = DatabaseHandler::GetAll($sql, $params);

			// Return the results
			return $search_result;

		}

		public static function GetJobs ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_site_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}
		
		public static function GetTodayJobs ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_today_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_today_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function GetYesterdayJobs ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_yesterday_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_yesterday_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function GetThisWeekJobs ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_this_week_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_this_week_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function GetLastThirtyDaysJobs ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_last_thirty_days_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_last_thirty_days_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function GetHighestHiringCompany() {
			$sql = 'CALL catalog_get_highest_hiring_companies()';
			$params = null;
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetTrendingPositions() {
			$sql = 'CALL catalog_get_trending_positions()';
			$params = null;
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetJobsOnFrontPage ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_jobs_on_front_page()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_site_jobs_on_front_page(:short_job_description_length, :start_item, :jobs_per_page)';
			$params = array(':short_job_description_length' => SHORT_JOB_DESCRIPTION_LENGTH, ':start_item' => $start_item, ':jobs_per_page' => FRONT_PAGE_JOBS);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetRecommendedJobs($jobId) {
			$limit = RECOMMENDED_JOBS_PER_PAGE;
			$sql = 'CALL catalog_get_recommended_jobs(:job_id, :limit)';
			$params = array(':job_id' => $jobId, ':limit' => $limit);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetJobName($jobId) {

			$sql = 'CALL catalog_get_job_name(:job_id)';
			$params = array(':job_id' => $jobId);

			$result = DatabaseHandler::GetRow($sql, $params);
			$result = implode(' at ', $result);
			return $result;
		}

		public static function GetCompanyName($companyId) {
			$sql = 'CALL catalog_get_company_name(:company_id)';
			$params = array(':company_id' => $companyId);
			return DatabaseHandler::GetOne($sql, $params);
		}
		
		public static function GetLocationName($locationId) {
		    $sql = 'CALL catalog_get_location_name(:location_id)';
		    $params = array(':location_id' => $locationId);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetJobsAdmin($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_jobs()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_jobs(:start_item, :jobs_per_page)';
			$params = array(':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetUsersAdmin($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_users()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPostsPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * 500;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_users(:start_item, :users_per_page)';
			$params = array(':start_item' => $start_item, ':users_per_page' => 500);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetUsersPostsAdmin($userId, $pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_users_posts(:user_id)';
			$params = array(':user_id' => $userId);

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_users_posts(:user_id, :short_description, :start_item, :users_per_page)';
			$params = array(':user_id' => $userId, ':short_description' => SHORT_ADMIN_POSTS_DESCRIPTION_LENGTH, ':start_item' => $start_item, ':users_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}
		public static function UpdatePostDisplay($displayVal, $postId) {
			$sql = 'CALL catalog_update_post_display(:display_val, :post_id)';
			$params = array(':display_val' => $displayVal, ':post_id' => $postId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetReportedPosts($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_report_posts()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_report_posts(:start_item, :users_per_page)';
			$params = array(':start_item' => $start_item, ':users_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetReportedComments($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_report_comments()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_report_comments(:start_item, :users_per_page)';
			$params = array(':start_item' => $start_item, ':users_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function GetAReportPost($reportId) {
			$sql = 'CALL catalog_get_a_report_post(:report_id)';

			$params = array(':report_id' => $reportId);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function GetAReportComment($reportId) {
			$sql = 'CALL catalog_get_a_report_comment(:report_id)';

			$params = array(':report_id' => $reportId);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function InsertImageComments($commentId, $image) {
			$sql = 'CALL catalog_insert_image_comments(:comment_id, :image)';
			$params = array(':comment_id' => $commentId, ':image' => $image);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetImageComments($commentId) {
			$sql = 'CALL catalog_get_image_comments(:comment_id)';
			$params = array(':comment_id' => $commentId);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function DeleteImageComments($commentId) {
			$sql = 'CALL catalog_delete_image_comments(:comment_id)';
			$params = array(':comment_id' => $commentId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function InsertImagePosts($postId, $image) {
			$sql = 'CALL catalog_insert_image_posts(:post_id, :image)';
			$params = array(':post_id' => $postId, ':image' => $image);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetImagePosts($postId) {
			$sql = 'CALL catalog_get_image_posts(:post_id)';
			$params = array(':post_id' => $postId);
			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function DeleteImagePosts($postId) {
			$sql = 'CALL catalog_delete_image_posts(:post_id)';
			$params = array(':post_id' => $postId);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetAJob($jobId) {
			$sql = 'CALL catalog_get_a_job(:job_id)';

			$params = array(':job_id'=>$jobId);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function GetAJobSite($jobId) {
			$sql = 'CALL catalog_get_a_job_site(:job_id)';

			$params = array(':job_id'=>$jobId);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function GetACompany($companyId) {
			$sql = 'CALL catalog_get_a_company(:company_id)';

			$params = array(':company_id'=>$companyId);

			return DatabaseHandler::GetRow($sql, $params);
		}

		public static function AddJob($jobDescription, $datePosted, $dateOfExpiration, $companyId, $jobLink, $positionId, $jobLocationId, $display) {
			$sql = 'CALL catalog_add_jobs(:job_description, :date_posted, :date_of_expiriation, :company_id, :job_link, :position_id, :job_location_id, :display)';

			$params = array(':job_description'=>$jobDescription, ':date_posted'=>$datePosted, ':date_of_expiriation'=>$dateOfExpiration, ':company_id'=>$companyId, ':job_link'=>$jobLink, ':position_id'=>$positionId, ':job_location_id'=>$jobLocationId, ':display'=>$display);

			DatabaseHandler::Execute($sql, $params);
		}

		public static function UpdateJob($jobId, $jobDescription, $datePosted, $dateOfExpiration, $companyId, $jobLink, $positionId, $jobLocationId, $display) {
			$sql = 'CALL catalog_update_jobs(:job_id, :job_description, :date_posted, :date_of_expiriation, :company_id, :job_link, :position_id, :job_location_id, :display)';

			$params = array(':job_id'=>$jobId, ':job_description'=>$jobDescription, ':date_posted'=>$datePosted, ':date_of_expiriation'=>$dateOfExpiration, ':company_id'=>$companyId, ':job_link'=>$jobLink, ':position_id'=>$positionId, ':job_location_id'=>$jobLocationId, ':display'=>$display);

			DatabaseHandler::Execute($sql, $params);
		}

		public static function UpdateCompany($companyId, $companyDescription, $name, $link, $image) {
			$sql = 'CALL catalog_update_company(:company_id, :company_description, :name, :link, :image)';

			$params = array(':company_id'=>$companyId, ':company_description'=>$companyDescription, ':name'=> $name, ':link' => $link, ':image' => $image);

			DatabaseHandler::Execute($sql, $params);
		}

		public static function DeleteJob($jobId) {
			$sql = 'CALL catalog_delete_job(:job_id)';

			$params = array(':job_id'=>$jobId);

			return DatabaseHandler::GetOne($sql,$params);
		}

		public static function GetLocations() {
			$sql = 'CALL catalog_get_locations()';

			return DatabaseHandler::GetAll($sql);
		}

		public static function GetJobPositions() {
			$sql = 'CALL catalog_get_positions()';

			return DatabaseHandler::GetAll($sql);
		}

		public static function InsertPosition($name) {
			$sql = 'CALL catalog_add_position(:name)';
			$params = array(':name' => $name);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function InsertLocation($name) {
			$sql = 'CALL catalog_add_location(:name)';
			$params = array(':name' => $name);
			return DatabaseHandler::GetOne($sql, $params);
		}

		public static function GetJobCompanies() {
			$sql = 'CALL catalog_get_company_id_name()';

			return DatabaseHandler::GetAll($sql);
		}

		public static function GetJobsCount() {
			$sql = 'CALL catalog_count_jobs()';

			return DatabaseHandler::GetOne($sql);
		}

		public static function GetCompanies($pageNo, &$rHowManyPages) {

			$sql = 'CALL catalog_count_companies()';

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPages($sql, null);
			// Calculate the start item
			$start_item = ($pageNo - 1) * ADMIN_JOBS_PER_PAGE;

			// Retrieve the list of products
			$sql = 'CALL catalog_get_companies(:short_job_description_length, :start_item, :jobs_per_page)';
			$params = array(':short_job_description_length' => SHORT_JOB_DESCRIPTION_LENGTH, ':start_item' => $start_item, ':jobs_per_page' => ADMIN_JOBS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
		}

		public static function AddCompany($name, $description, $link, $image = null) {
			$sql = 'CALL catalog_add_company(:name, :description, :link, :image)';

			$params = array(':name' => $name, ':description' => $description, ':link' => $link, ':image' => $image);

			DatabaseHandler::Execute($sql, $params);
		}

		public static function DeleteCompany($companyId) {
			$sql = 'CALL catalog_delete_company(:company_id)';

			$params = array(':company_id'=>$companyId);

			return DatabaseHandler::GetOne($sql,$params);
		}

		public static function DeleteUser($userId) {
			$sql = 'CALL catalog_delete_user(:user_id)';

			$params = array(':user_id'=>$userId);

			DatabaseHandler::Execute($sql,$params);
		}

		public static function DeletePost($postId, $userId) {
			$sql = 'CALL customer_delete_post(:postId, :user_id)';

			$params = array(':post_id' => $postId, ':user_id'=>$userId);

			DatabaseHandler::Execute($sql,$params);
		}

		public static function DeleteComment($postId, $userId) {
			$sql = 'CALL customer_delete_comment(:post_id, :user_id)';

			$params = array(':post_id' => $postId, ':user_id'=>$userId);

			DatabaseHandler::Execute($sql,$params);
		}

		public static function DeleteReportPost($reportId) {
			$sql = 'CALL catalog_delete_report_post(:report_id)';

			$params = array(':report_id' => $reportId);

			DatabaseHandler::Execute($sql,$params);
		}

		public static function DeleteReportComment($reportId) {
			$sql = 'CALL catalog_delete_report_comment(:report_id)';

			$params = array(':report_id' => $reportId);

			DatabaseHandler::Execute($sql,$params);
		}
		

		public static function WarnUser($userId, $accessDenied) {
			$sql = 'CALL catalog_warn_user(:user_id, :access_denied)';

			$params = array(':user_id'=>$userId, ':access_denied' => $accessDenied);

			DatabaseHandler::Execute($sql,$params);
		}

		public static function GetDeveloperMessages ($pageNo, &$rHowManyPages) {
			// Query that returns the number of jobs
			$sql = 'CALL catalog_count_developer_messages()';
			$params = null;

			// Calculate the number of pages required to display the products
			$rHowManyPages = Catalog::HowManyPostsPages($sql, $params);
			// Calculate the start item
			$start_item = ($pageNo - 1) * POSTS_PER_PAGE;
			$sql = 'CALL catalog_get_developer_messages(:start_item, :posts_per_page)';
			$params = array(':start_item' => $start_item, ':posts_per_page' => POSTS_PER_PAGE);

			return DatabaseHandler::GetAll($sql, $params);
			
		}

		public static function DeleteDeveloperMessage ($id) {
			$sql = 'CALL catalog_delete_developer_messages(:id)';
			$params = array(':id' => $id);
			DatabaseHandler::Execute($sql, $params);
		}

		public static function GetADeveloperMessage($id) {
			$sql = 'CALL catalog_get_a_developer_message(:id)';
			$params = array(':id' => $id);
			return DatabaseHandler::GetRow($sql, $params);
		}

	}
?>