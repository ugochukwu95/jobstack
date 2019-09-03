<?php
	class Link {
		public static function Build($link) {
			$base = 'https://' . getenv('SERVER_NAME');

			if (defined('HTTP_SERVER_PORT') && HTTP_SERVER_PORT != '80') {
				// Append server port
				$base .= ':' . HTTP_SERVER_PORT;
			}
			
			$link = $base . VIRTUAL_LOCATION . $link;
			
			// Escape html
			return $link;
		}

		public static function QueryStringToArray($queryString) {
			$result = array();


			if ($queryString != '') {
				$elements = explode('&', $queryString);
				
				foreach($elements as $key => $value) {
					$element = explode('=', $value);
					$result[urldecode($element[0])] = isset($element[1]) ? urldecode($element[1]) : ''; 
				}
			}
			return $result;
		}

		// Prepares a string to be included in an URL
		public static function CleanUrlText($string) {
			// Remove all characters that aren't a-z, 0-9, dash, underscore or space
			$not_acceptable_characters_regex = '#[^-a-zA-Z0-9_ ]#';
			$string = preg_replace($not_acceptable_characters_regex, '', $string);
			// Remove all leading and trailing spaces
			$string = trim($string);
			// Change all dashes, underscores and spaces to dashes
			$string = preg_replace('#[-_ ]+#', '-', $string);
			// Return the modified string
			return strtolower($string);
		}

		public static function CheckRequest() {
			$properUrl = '';
			if (isset ($_GET['Search']) || isset($_GET['SearchResults']) || isset ($_GET['CartAction']) || isset ($_POST['Login']) || isset ($_GET['Logout']) || isset ($_GET['EditProfile']) || isset ($_GET['Login']) || isset ($_GET['UserTerms']) || isset ($_GET['PrivacyPolicy']) || isset ($_GET['ContactDeveloper']) || isset ($_GET['CareerService']) || isset ($_GET['CVS']) || isset ($_GET['CoverLetters']) || isset ($_GET['LinkedinProfile']) || isset ($_GET['Applications'])  || isset ($_GET['UserJobPost'])) {
				return ;
			}
			elseif (isset($_GET['JobId'])) {
				$properUrl = self::ToJob($_GET['JobId']);
			}
			elseif (isset($_GET['Jobs'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToJobsPage($_GET['Page']);
				}
				else {
					$properUrl = self::ToJobsPage();
				}
			}
			elseif (isset($_GET['TodayJobs'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToTodayJobsPage($_GET['Page']);
				}
				else {
					$properUrl = self::ToTodayJobsPage();
				}
			}
			elseif (isset($_GET['YesterdayJobs'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToYesterdayJobsPage($_GET['Page']);
				}
				else {
					$properUrl = self::ToYesterdayJobsPage();
				}
			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToThisWeekJobsPage($_GET['Page']);
				}
				else {
					$properUrl = self::ToThisWeekJobsPage();
				}
			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToLastThirtyDaysJobsPage($_GET['Page']);
				}
				else {
					$properUrl = self::ToLastThirtyDaysJobsPage();
				}
			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    if (isset($_GET['Page'])) {
					$properUrl = self::ToJobsBelongingToLocation($_GET['LocationId'], $_GET['JobsBelongingToLocation'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToJobsBelongingToLocation($_GET['LocationId'], $_GET['JobsBelongingToLocation']);
				}
			}
			elseif (isset($_GET['JobsBelongingToCompany'])) {
			    if (isset($_GET['Page'])) {
					$properUrl = self::ToJobsBelongingToCompany($_GET['CompanyId'], $_GET['JobsBelongingToCompany'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToJobsBelongingToCompany($_GET['CompanyId'], $_GET['JobsBelongingToCompany']);
				}
			}
			elseif (isset($_GET['CompanyId'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToCompany($_GET['CompanyId'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToCompany($_GET['CompanyId']);
				}
			}
			elseif (isset($_GET['Companies'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToCompanies($_GET['Page']);
				}
				else {
					$properUrl = self::ToCompanies();
				}
			}
			elseif (isset ($_GET['TrendingChatter'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToTrendingChatter($_GET['Page']);
				}
				else {
					$properUrl = self::ToTrendingChatter();
				}
			}
			elseif (isset ($_GET['PopularTags'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToPopularTags($_GET['PopularTags'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToPopularTags($_GET['PopularTags']);
				}
			}
			elseif (isset ($_GET['MoreJobReviews'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToMoreJobReviews($_GET['MoreJobReviews'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToMoreJobReviews($_GET['MoreJobReviews']);
				}
			}
			elseif (isset ($_GET['MoreCompanyReviews'])) {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToMoreCompanyReviews($_GET['MoreCompanyReviews'], $_GET['Page']);
				}
				else {
					$properUrl = self::ToMoreCompanyReviews($_GET['MoreCompanyReviews']);
				}
			}
			elseif (isset($_GET['UserProfile'])) {
				if (isset($_GET['MyPosts'])) {
					if (isset($_GET['Page'])) {
						$properUrl = self::ToUserProfile($_GET['UserProfile'], $_GET['MyPosts'], null, null, $_GET['Page']);
					}
					else {
						$properUrl = self::ToUserProfile($_GET['UserProfile'], $_GET['MyPosts']);
					}
				}
				elseif (isset($_GET['LikedPosts'])) {
					if (isset($_GET['Page'])) {
						$properUrl = self::ToUserProfile($_GET['UserProfile'], null, $_GET['LikedPosts'], null, $_GET['Page']);
					}
					else {
						$properUrl = self::ToUserProfile($_GET['UserProfile'], null, $_GET['LikedPosts']);
					}
				}
				elseif (isset($_GET['About'])) {
					$properUrl = self::ToUserProfile($_GET['UserProfile'], null, null, $_GET['About']);
				}
				else {
					$properUrl = self::ToUserProfile($_GET['UserProfile']); 
				}
			}
			elseif (isset($_GET['PostId']) && isset($_GET['UserId'])) {
				$properUrl = self::ToPostDetails($_GET['UserId'], $_GET['PostId']);
			}
			else {
				if (isset($_GET['Page'])) {
					$properUrl = self::ToIndex($_GET['Page']);
				}
				else {
					$properUrl = self::ToIndex();
				}
			}

			/* Remove the virtual location from the requested URL so we can compare paths */
			$requested_url = self::Build(substr($_SERVER['REQUEST_URI'], 1));

			// 404 redirect if the requested job doesn't exist
			if (strstr($properUrl, '/-')) {
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

			// 301 redirect to the proper URL if necessary
			if ($requested_url != $properUrl) {
				// Clean output buffer
				ob_clean();
				// Redirect 301
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $properUrl);
				// Clear the output buffer and stop execution
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}
		}

		public static function ToCompanies($page=1) {
			$link = 'all-companies/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToCompany($companyId, $page=1) {
			$link = self::CleanUrlText(Catalog::GetCompanyName($companyId)) . '-c' . $companyId . '/';

			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			
			return self::Build($link);
		}

		public static function ToUserProfile($userId, $myPosts = null, $likedPosts = null, $about = null, $page=1) {
			$link = self::CleanUrlText(Customer::GetAUserHandle($userId)) . '-u' . $userId .'/';

			if (!is_null($myPosts)) {
				$link .= 'my-posts-' . $myPosts .'/';
				if ($page > 1) {
					$link .= 'page-' . $page . '/';
				}
			}

			if (!is_null($likedPosts)) {
				$link .= 'liked-posts-' . $likedPosts .'/';
				if ($page > 1) {
					$link .= 'page-' . $page . '/';
				}
			}

			if (!is_null($about)) {
				$link .= 'about-' . $about .'/';
			}

			return self::Build($link); 
		}

		public static function ToPostDetails($userId, $postId) {
			$link = 'post-by-' . self::CleanUrlText(Customer::GetAUserHandle($userId)) . '-u' . $userId .'-p' . $postId .'/';

			return self::Build($link);
		}

		public static function ToJobsPage($page=1) {
			$link = 'all-jobs/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToTodayJobsPage($page=1) {
			$link = 'today-jobs/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToYesterdayJobsPage($page=1) {
			$link = 'yesterday-jobs/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToThisWeekJobsPage($page=1) {
			$link = 'this-week-jobs/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToLastThirtyDaysJobsPage($page=1) {
			$link = 'last-thirty-days-jobs/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}
		
		public static function ToJobsBelongingToLocation($id, $location_name, $page=1) {
		    $location = self::CleanUrlText($location_name);
		    $link = 'jobs-in-'. $location . '-bl' . $id . '/';
		    if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
		    return self::Build($link);
		}
		public static function ToJobsBelongingToCompany($id, $company_name, $page=1) {
		    $company = self::CleanUrlText($company_name);
		    $link = 'jobs-at-'. $company . '-bc' . $id . '/';
		    if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
		    return self::Build($link);
		}

		public static function ToJob($jobId) {
			$link = self::CleanUrlText(Catalog::GetJobName($jobId)) . '-j' . $jobId . '/';
			
			return self::Build($link);
		}

		public static function ToIndex($page = 1) {
			$link = '';

			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToCart($action = 0, $target = null) {
			$link = '';

			 switch($action) {
			 	case ADD_JOB:
			 		$link = 'index.php?CartAction=' . ADD_JOB .'&JobId=' . $target;
			 		break;
			 	case REMOVE_JOB:
			 		$link = 'index.php?CartAction=' . REMOVE_JOB . '&JobId=' . $target;
			 		break;
			 	default:
			 		$link = 'cart-details/';
			 }

			 return self::Build($link);
		}

		public static function ToCartPage($page=1) {
			$link = 'cart-details/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToLoginPage() {
			$link = 'login/';
			return self::Build($link);
		}

		public static function ToEditProfile() {
			return self::Build('edit-profile/');
		}

		public static function ToTrendingChatter($page=1) {
			$link = 'trending-chatter/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToPopularTags($jobId, $page=1) {
			$link = 'popular-tags-' . $jobId . '/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link);
		}

		public static function ToMoreJobReviews($jobId, $page=1) {
			$link = 'more-job-reviews-' . $jobId . '/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link); 
		}

		public static function ToMoreCompanyReviews($companyId, $page=1) {
			$link = 'more-company-reviews-' . $companyId . '/';
			if ($page > 1) {
				$link .= 'page-' . $page . '/';
			}
			return self::Build($link); 
		}

		public static function ToUserTerms() {
			$link = 'user-terms';
			return self::Build($link);
		}

		public static function ToPrivacyPolicy() {
			$link = 'privacy-policy';
			return self::Build($link);
		}

		public static function ToContactDeveloper() {
			$link = 'contact-developer';
			return self::Build($link);
		}

		public static function ToWebsiteLogo() {
			$link = 'images/profile_pictures/jobstack_logo.png';
			return self::Build($link);
		}
		
		public static function ToCareerService() {
			$link = 'cvs-applications-linkedin-profiles';
			return self::Build($link);
		}

		public static function ToCVS() {
			$link = 'cvs';
			return self::Build($link);
		}

		public static function ToCoverLetters() {
			$link = 'cover-letters';
			return self::Build($link);
		}

		public static function ToLinkedinProfile() {
			$link = 'linkedin-profile';
			return self::Build($link);
		}

		public static function ToApplications() {
			$link = 'applications';
			return self::Build($link);
		}
		
		public static function ToUserJobPost() {
			$link = 'user-job-post';
			return self::Build($link);
		}

		// Admin Functionality
		//
		//
		//
		//

		public static function ToAdmin($params='') {
			$link = 'admin.php';

			if ($params != '') {
				$link .= '?'.$params;
			}
			return self::Build($link);
		}

		// Create link to the jobs administration page
		public static function ToJobsAdmin($pagination = null) {
			$link = 'Page=Jobs';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
			
		}


		public static function ToJobDetailsAdmin($params) {
			$link = 'Page=JobDetails&jobId='.$params;
			return self::ToAdmin($link);
		}

		public static function ToCompaniesAdmin($pagination = null) {
			$link = 'Page=Companies';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
			
		}

		public static function ToCompanyDetailsAdmin($params) {
			$link = 'Page=CompanyDetails&companyId='.$params;
			return self::ToAdmin($link);
		}

		public static function ToUsersAdmin($pagination = 1) {
			$link = 'Page=Users';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}

		public static function ToUserPostsAdmin($params, $pagination = 1) {
			$link = 'Page=UserPosts&userId='.$params;
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}
		
		public static function ToUsersJobsAdmin($pagination = 1) {
			$link = 'Page=UsersJobs';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}
		
		public static function ToUserJobDetailsAdmin($params) {
			$link = 'Page=UserJobDetails&userJobId='.$params;
			return self::ToAdmin($link);
		}

		public static function ToReportPostAdmin($pagination = 1) {
			$link = 'Page=ReportPosts';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}

		public static function ToReportCommentAdmin($pagination = 1) {
			$link = 'Page=ReportComments';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}

		public static function ToReportPostDetailsAdmin($params) {
			$link = 'Page=ReportPostDetails&ReportId='.$params;
			return self::ToAdmin($link);
		}

		public static function ToReportCommentDetailsAdmin($params) {
			$link = 'Page=ReportCommentDetails&ReportId='.$params;
			return self::ToAdmin($link);
		}

			// Create logout link
		public static function ToLogout() {
			return self::ToAdmin('Page=Logout');
		}

		public static function ToDeveloperMessages($pagination=1) {
			$link = 'Page=DeveloperMessages';
			if ($pagination > 1) {
				$link .= '&Pagination=' . $pagination;
			}
			return self::ToAdmin($link);
		}

		public static function ToADeveloperMessage($id) {
			return self::ToAdmin('Page=ADeveloperMessage&MessageId='.$id);
		}

		// public static function ToIndex() {
			// return self::Build('');
		// }

		public static function ToSearch() {
			return self::Build('admin.php?Search');
		}

		public static function ToCatalogSearch() {
			return self::Build('index.php?Search');
		}

		// Create link to index.php search result page
		public static function ToCatalogSearchResults($searchString, $allWords, $companySearch, $page = 1) {
			$link = 'search-results/find';

			if (empty($searchString)) {
				$link .= '/';
			}
			else {
				$link .= '-' . self::CleanUrlText($searchString) . '/';
				$link .= 'all-words-' . $allWords . '/';
    			$link .= 'company-search-' . $companySearch . '/';
    			
    			if ($page > 1) {
    				$link .= 'page-' . $page . '/';
    			}
			}

			return self::Build($link);
		}

		// Create link to admin.php search result page
		public static function ToSearchResults($searchString, $allWords, $companySearch = null, $userSearch = null, $page = 1) {
			$link = 'admin.php?SearchResults';

			if (empty($searchString)) {
				return self::ToAdmin();
			}
			else {
				$link .= '&SearchString='.$searchString;
				$link .= '&AllWords='.$allWords;
				$link .= '&CompanySearch='.$companySearch;
				$link .= '&UserSearch='.$userSearch;

				if ($page > 1) {
					$link .= '&Pagination='.$page;
				}
			}
			return self::Build($link);
		}

	}
?>