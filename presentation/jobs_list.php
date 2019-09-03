<?php
	class JobsList {
		public $mPage = 1;
		public $mrTotalPages;
		public $mLinkToNextPage;
		public $mLinkToPreviousPage;
		public $mJobs = array();
		public $mJobListPages = array();
		public $mErrorMessage;
		public $mSearchString;
		public $mSearchDescription = '';
		public $mAllWords = 'off';
		public $mCompanySearch = 'off';
		public $mLinkToAllJobs;
		public $mCardColor;
		public $mIsFrontPage = 'no';
		public $mSiteUrl;
		public $mLinkToUserProfile;
		public $mLinkToCartPage;
		public $mLinkToLoginPage;
		public $mLinkToTodayJobs;
		public $mLinkToYesterdayJobs;
		public $mLinkToThisWeekJobs;
		public $mLinkToLastThirtyDaysJobs;
		public $mJobsPageName = 'All Jobs';
		public $mLocationId;
		public $mLocationName;
		public $mCountJobs;

		public function __construct() {
			if (isset($_GET['Page'])) {
				$this->mPage = (int)$_GET['Page'];
			}
			if ($this->mPage < 1) {
				trigger_error('Incorrect page value');
			}
			// Retrieve the search string and AllWords from the query string
			if (isset ($_GET['SearchResults'])) {
				$this->mSearchString = trim(str_replace('-', ' ', $_GET['SearchString']));
				$this->mAllWords = isset ($_GET['AllWords']) ? $_GET['AllWords'] : 'off';
				$this->mCompanySearch = isset ($_GET['CompanySearch']) ? $_GET['CompanySearch'] : 'off';       
			}
			
			if (isset($_GET['JobsBelongingToLocation'])) {
			    $this->mLocationId = (int)$_GET['LocationId'];
			    $this->mLocationName = (string)$_GET['JobsBelongingToLocation'];
			}

			$this->mLinkToUserProfile = Link::ToUserProfile((int)Customer::GetCurrentCustomerId());
			$this->mLinkToAllJobs = Link::ToJobsPage();
			$this->mLinkToCartPage = Link::ToCartPage();
			$this->mSiteUrl = Link::Build('');
			$this->mLinkToLoginPage = Link::ToLoginPage();
			$this->mLinkToTodayJobs = Link::ToTodayJobsPage();
			$this->mLinkToYesterdayJobs = Link::ToYesterdayJobsPage();
			$this->mLinkToThisWeekJobs = Link::ToThisWeekJobsPage();
			$this->mLinkToLastThirtyDaysJobs = Link::ToLastThirtyDaysJobsPage();
		}

		public function init() {
			/* If searching the catalog, get the list of products by calling the Search business tier method */
			if (isset ($this->mSearchString)) {
				// Get search results
				$search_results = Catalog::CatalogSearch($this->mSearchString, $this->mAllWords, $this->mPage, $this->mrTotalPages);
				// Get the list of products
				$this->mJobs = $search_results['jobs'];
				if (count($this->mJobs) == 0) {
					$this->mSearchDescription = 'No results can be found';
				}
			}
			elseif (isset($_GET['JobsBelongingToLocation'])) {
			    $this->mJobs = Catalog::GetJobsBelongingToLocation($this->mLocationId, $this->mPage, $this->mrTotalPages); 
			    $this->mJobsPageName = 'Jobs in ' . Catalog::GetLocationName($this->mLocationId);
			    if (empty($this->mJobs)) {
					$this->mErrorMessage = '
					<div class="row empty-saved-jobs">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="center"><span class="grey-text text-darken-2">There are no available jobs for this location at this present time.</h5>
							<p class="center red-text text-lighten-2"><a href="'.$this->mLinkToAllJobs.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
							</p>
						</div>
					</div>';
				}
			}
			elseif (isset($_GET['Jobs'])) {
				$this->mJobs = Catalog::GetJobs($this->mPage, $this->mrTotalPages);
				$this->mJobsPageName = 'All Jobs';
			}
			elseif (isset($_GET['TodayJobs'])) {
				$this->mJobs = Catalog::GetTodayJobs($this->mPage, $this->mrTotalPages);
				$this->mJobsPageName = 'Today\'s jobs';
				if (empty($this->mJobs)) {
					$this->mErrorMessage = '
					<div class="row empty-saved-jobs">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="center"><span class="grey-text text-darken-2">There are no available jobs today.</h5>
							<p class="center red-text text-lighten-2"><a href="'.$this->mLinkToAllJobs.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
							</p>
						</div>
					</div>';
				}
			}
			elseif (isset($_GET['YesterdayJobs'])) {
				$this->mJobs = Catalog::GetYesterdayJobs($this->mPage, $this->mrTotalPages);
				$this->mJobsPageName = 'Yesterday\'s jobs';
				if (empty($this->mJobs)) {
					$this->mErrorMessage = '
					<div class="row empty-saved-jobs">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="center"><span class="grey-text text-darken-2">There are no available jobs.</h5>
							<p class="center red-text text-lighten-2"><a href="'.$this->mLinkToAllJobs.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
							</p>
						</div>
					</div>';
				}
			}
			elseif (isset($_GET['ThisWeekJobs'])) {
				$this->mJobs = Catalog::GetThisWeekJobs($this->mPage, $this->mrTotalPages);
				$this->mJobsPageName = 'This week\'s jobs';
				if (empty($this->mJobs)) {
					$this->mErrorMessage = '
					<div class="row empty-saved-jobs">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="center"><span class="grey-text text-darken-2">There are no available jobs.</h5>
							<p class="center red-text text-lighten-2"><a href="'.$this->mLinkToAllJobs.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
							</p>
						</div>
					</div>';
				}
			}
			elseif (isset($_GET['LastThirtyDaysJobs'])) {
				$this->mJobs = Catalog::GetLastThirtyDaysJobs($this->mPage, $this->mrTotalPages);
				$this->mJobsPageName = 'Last thirty days\' jobs';
				if (empty($this->mJobs)) {
					$this->mErrorMessage = '
					<div class="row empty-saved-jobs">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="center"><span class="grey-text text-darken-2">There are no available jobs.</h5>
							<p class="center red-text text-lighten-2"><a href="'.$this->mLinkToAllJobs.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
							</p>
						</div>
					</div>';
				}
			}
			else {
				$this->mJobs = Catalog::GetJobsOnFrontPage($this->mPage, $this->mrTotalPages);
				for ($i=0; $i<count($this->mJobs); $i++) {
				    $this->mJobs[$i]['jobs_count'] = count(Catalog::GetJobsBelongingToCompany($this->mJobs[$i]['company_id'], $this->mPage, $this->mrTotalPages));
				}
				$this->mIsFrontPage = "yes";
			}

			if ($this->mrTotalPages > 1) {
				if ($this->mPage < $this->mrTotalPages) {
					if (isset($_GET['SearchResults'])) {
						$this->mLinkToNextPage = Link::ToCatalogSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, $this->mPage + 1);
					}
					elseif (isset($_GET['Jobs'])) {
						$this->mLinkToNextPage = Link::ToJobsPage($this->mPage + 1, $this->mrTotalPages);
					}
					elseif (isset($_GET['TodayJobs'])) {
						$this->mLinkToNextPage = Link::ToTodayJobsPage($this->mPage + 1, $this->mrTotalPages);
					}
					elseif (isset($_GET['YesterdayJobs'])) {
						$this->mLinkToNextPage = Link::ToYesterdayJobsPage($this->mPage + 1, $this->mrTotalPages);
					}
					elseif (isset($_GET['ThisWeekJobs'])) {
						$this->mLinkToNextPage = Link::ToThisWeekJobsPage($this->mPage + 1, $this->mrTotalPages);
					}
					elseif (isset($_GET['LastThirtyDaysJobs'])) {
						$this->mLinkToNextPage = Link::ToLastThirtyDaysJobsPage($this->mPage + 1, $this->mrTotalPages);
					}
					elseif (isset($_GET['JobsBelongingToLocation'])) {
					    $this->mLinkToNextPage = Link::ToJobsBelongingToLocation($this->mLocationId, $this->mLocationName, $this->mPage + 1);
					}
					else {
						$this->mLinkToNextPage = Link::ToIndex($this->mPage + 1);
					}
				}
			}

			if ($this->mPage > 1) {
				if (isset($_GET['SearchResults'])) {
					$this->mLinkToPreviousPage = Link::ToCatalogSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, $this->mPage - 1);
				}
				elseif (isset($_GET['Jobs'])) {
					$this->mLinkToPreviousPage = Link::ToJobsPage($this->mPage - 1, $this->mrTotalPages);
				}
				elseif (isset($_GET['TodayJobs'])) {
					$this->mLinkToPreviousPage = Link::ToTodayJobsPage($this->mPage - 1, $this->mrTotalPages);
				}
				elseif (isset($_GET['YesterdayJobs'])) {
					$this->mLinkToPreviousPage = Link::ToYesterdayJobsPage($this->mPage - 1, $this->mrTotalPages);
				}
				elseif (isset($_GET['ThisWeekJobs'])) {
					$this->mLinkToPreviousPage = Link::ToThisWeekJobsPage($this->mPage - 1, $this->mrTotalPages);
				}
				elseif (isset($_GET['LastThirtyDaysJobs'])) {
					$this->mLinkToPreviousPage = Link::ToLastThirtyDaysJobsPage($this->mPage - 1, $this->mrTotalPages);
				}
				elseif (isset($_GET['JobsBelongingToLocation'])) {
				    $this->mLinkToPreviousPage = Link::ToJobsBelongingToLocation($this->mLocationId, $this->mLocationName, $this->mPage - 1);
				}
				else {
					$this->mLinkToPreviousPage = Link::ToIndex($this->mPage - 1);
				}
			}
			// Build the pages links
			for ($i = 1; $i <= $this->mrTotalPages; $i++) {
				if (isset($_GET['SearchResults'])) {
					$this->mJobListPages[] = Link::ToCatalogSearchResults($this->mSearchString, $this->mAllWords, $this->mCompanySearch, $i);
				}
				elseif (isset($_GET['Jobs'])) {
					$this->mJobListPages[] = Link::ToJobsPage($i);
				}
				elseif (isset($_GET['TodayJobs'])) {
					$this->mJobListPages[] = Link::ToTodayJobsPage($i);
				}
				elseif (isset($_GET['YesterdayJobs'])) {
					$this->mJobListPages[] = Link::ToYesterdayJobsPage($i);
				}
				elseif (isset($_GET['ThisWeekJobs'])) {
					$this->mJobListPages[] = Link::ToThisWeekJobsPage($i);
				}
				elseif (isset($_GET['LastThirtyDaysJobs'])) {
					$this->mJobListPages[] = Link::ToLastThirtyDaysJobsPage($i);
				}
				elseif (isset($_GET['JobsBelongingToLocation'])) {
				    $this->mJobListPages[] = Link::ToJobsBelongingToLocation($this->mLocationId, $this->mLocationName, $i);
				}
				else {
					$this->mJobListPages[] = Link::ToIndex($i);
				}
				
			}
			/* 404 redirect if the page number is larger than the total number of pages */
			if ($this->mPage > $this->mrTotalPages && !empty($this->mrTotalPages)) {
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

			//Add to cart functionality
			$saved_jobs_associative_array_list = SavedJobsCart::GetSavedJobsJobId();
			$saved_jobs = array();
			for ($i = 0; $i < count($saved_jobs_associative_array_list); $i++) {
				$saved_jobs[$i] = $saved_jobs_associative_array_list[$i]['job_id'];
			}

			// print_r($saved_jobs_associative_array_list);
			if (is_array($this->mJobs)) {
				for ($i = 0; $i<count($this->mJobs); $i++) {

					// Creates link to job details page
					$this->mJobs[$i]['link_to_job'] = Link::ToJob($this->mJobs[$i]['job_id']);
					$this->mJobs[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mJobs[$i]['job_id']);

					//Saved job color functionality
					if (in_array($this->mJobs[$i]['job_id'], $saved_jobs)) {
						$this->mJobs[$i]['card_color'] = 'red';
						$this->mJobs[$i]['link_to_remove_job'] = Link::ToCart(REMOVE_JOB, $this->mJobs[$i]['job_id']);
					}
					else {
						$this->mJobs[$i]['card_color'] = 'teal';
					}
				}
			}

			// Posting to your profile
			if (isset($_POST['Button_Post_With_Tag'])) {
				if (trim(htmlspecialchars($_POST['Post'])) !== '') {
					$post = trim(htmlspecialchars($_POST['Post']));
					Customer::InsertIntoPostsWithTag($post, (int)$_POST['JobId']);
				}
			}

			// Save request for continue browsing functionality
			$_SESSION['link_to_continue_browsing'] = $_SERVER['QUERY_STRING'];

		}
	}
?>