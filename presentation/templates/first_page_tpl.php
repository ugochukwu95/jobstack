<?php
	require_once PRESENTATION_DIR . 'first_page.php';
	$first_page = new FirstPage();
	$first_page->init();
	echo '
	<style>
	    .search_btn {
	        padding: 60px 100px;
	        border-radius: 8px;
	        cursor: pointer;
	        white-space: nowrap;
	    }
	    
	</style>
	<script type="application/ld+json">
	    {
	        "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "Jobstack",
            "url": "https://www.jobstack.com.ng",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "https://www.jobstack.com.ng/search-results/find-{search_term}/all-words-off/",
                "query-input": "required name=search_term"
            }
	    }
	</script>
	
	<!--<div class="nav-content">
      <ul class="tabs tabs-transparent" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
        <li class="tab" itemprop="name"><a itemprop="url" target="_self" class="'.$homepage->mSiteActiveLink.'" href="'.$homepage_link.'" class="white-text text-darken-2">Home</a></li>
        <li class="tab" itemprop="name"><a itemprop="url" target="_self" class="'.$homepage->mAllJobsActiveLink.'" href="'.$homepage->mLinkToAllJobsUrl.'" class="white-text text-darken-2">All Jobs</a></li>
        <li class="tab" itemprop="name"><a itemprop="url" target="_self" class="'.$homepage->mTrendingChatterActiveLink.'" href="'.$homepage->mLinkToTrendingChatterUrl.'" class="white-text text-darken-2">Trending Chatter</a></li>
        <li class="tab" itemprop="name"><a itemprop="url" target="_self" class="'.$homepage->mAllCompaniesActiveLink.'" href="'.$homepage->mLinkToAllCompaniesUrl.'" class="white-text text-darken-2">All Companies</a></li>
      </ul>
    </div>-->
    
	<div class="row">
	    <div class="col s12">
	        <div class="card white z-depth-0">
	            <div class="card-content">
	            <br>
	                <div class="row">
	                    <div class="col s12">
    	                    <!--<br>
    	                    <p class="center"><img src="'.$first_page->mLinkToLogo.'" style="height:150px;width:150px;" alt="website_logo"></p>
    	                    <br>-->
    	                    <h3 class="center bebasFont teal-text text-darken-2">Explore Nigeria\'s favourite job board</h3>
	                    </div>
	                </div>
                	<div class="row">
                		<div class="col s12">
                			<p class="center"><a class="center teal white-text text-darken-2 btn-large btn-floating pulse openSearchNav"><strong><i class="material-icons">search</i></strong></a></p>
                		</div>
                	</div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col s12">
	        <h5 class="center grey-text text-darken-2">Featured Jobs</h5>
	    </div>
	</div>
	';
	require_once 'jobs_list_tpl.php';
	echo '
	<div class="row">
		<div class="col s12">
			<p class="center">
			<a href="'.$first_page->mLinkToAllJobsUrl.'" class="btn waves-light red lighten-2 white-text">more jobs</a> <br><br>
			<!-- <a href="'.$first_page->mLinkToTodayJobs.'" class="btn waves-light red lighten-2 white-text">Jobs Today</a> &nbsp;
			<a href="'.$first_page->mLinkToYesterdayJobs.'" class="btn waves-light red lighten-2 white-text">Jobs Yesterday</a> &nbsp;
			<a href="'.$first_page->mLinkToThisWeekJobs.'" class="btn waves-light red lighten-2 white-text">Jobs This week</a> &nbsp;-->
			</p>
		</div>
	</div>';
	echo '
	<div class="row hide-on-large-only">
	    <div class="col s12">
	    <!-- Trending locations functionality -->
		<div class="trending_stuff">
    		<ul class="collection with-header white lighten-5 z-depth-1" style="border-top:none;border-radius:8px;">
    		    <li class="collection-header white lighten-5"><h6><strong>Highest Hiring Locations</strong></h6></li>';
        		for ($i=0; $i<count($first_page->mTrendingLocations); $i++) {
        		    echo '
                    <li class="collection-item white lighten-5 link_to_job_'.$i.'">
                    <small class="grey-text text-darken-1">'.($i+1).' Trending</small><br>
                    <strong><a href="'.$first_page->mTrendingLocations[$i]['link_to_location'].'" class="grey-text text-darken-4">
                    Jobs in '.$first_page->mTrendingLocations[$i]['location_name'].'</a></strong><br>
                    <span class="grey-text text-darken-1">'.$first_page->mTrendingLocations[$i]['jobs_count'].' jobs</span></li>
        		    ';
        		}
    		echo '
    		</ul>
    		<br>
    		<ul class="collection with-header white lighten-5 z-depth-1" style="border-top:none;border-radius:8px;">
    		    <li class="collection-header white lighten-5"><h6><strong>Highest Hiring Companies</strong></h6></li>';
    		    for ($i=0; $i<count($first_page->mTrendingCompanies); $i++) {
    		        echo '
    		        <li class="collection-item avatar white lighten-5 link_to_company_'.$i.'">
    		        <img src="'.$first_page->mTrendingCompanies[$i]['image'].'" alt="'.$first_page->mTrendingCompanies[$i]['company_name'].'. logo" class="circle">
    		        <span class="title grey-text text-darken-2"><strong><a href="'.$first_page->mTrendingCompanies[$i]['link_to_company'].'" class="grey-text text-darken-4">
    		            Jobs at '.$first_page->mTrendingCompanies[$i]['company_name'].'</a></strong></span>
    		        <p class="grey-text text-darken-1">'.$first_page->mTrendingCompanies[$i]['jobs_count'].' jobs</p></li>';
    		    }
    		echo '
    		</ul>
    		</div>';
    		for ($i=0; $i<count($first_page->mTrendingLocations); $i++) {
    		   echo '
    		   <script>
    		        $(document).ready(function() {
    		            $(".trending_stuff").on("click", ".link_to_job_'.$i.'", function(){
    		                window.location.href = "'.$first_page->mTrendingLocations[$i]['link_to_location'].'";
    		            });
    		        });
    		   </script>
    		   '; 
    		}
    		for ($i=0; $i<count($first_page->mTrendingCompanies); $i++) {
    		   echo '
    		   <script>
    		        $(document).ready(function() {
    		            $(".trending_stuff").on("click", ".link_to_company_'.$i.'", function(){
    		                window.location.href = "'.$first_page->mTrendingCompanies[$i]['link_to_company'].'";
    		            });
    		        });
    		   </script>
    		   '; 
    		}
	    echo '
	    </div>
	</div>
	<br>
	<br>
	<div class="row">
	    <div class="col s12">
	        <h5 class="center grey-text text-darken-2">Featured Chatter</h5>
	    </div>
	</div>
	<div class="row">';
	for ($i=0; $i<count($first_page->mPosts); $i++) {
		echo '
		<div class="col s12 l12 card_my_stream'.$i.' post_customer_'.$first_page->mPosts[$i]['customer_id'].'">
				<div class="card white grey-text text-darken-2 z-depth-0 card-color" style="border: 1px solid lightgrey;">
					<div class="card-content card_content_my_stream'.$i.'">
						<p style="position:relative;">
							<span>';
								if (empty($first_page->mPosts[$i]['avatar'])) {
									echo '
									<a href="'.$first_page->mPosts[$i]['link_to_user'].'" class="white-text">
										<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
											<span class="white-text" style="font-size:15px;"><b>'.substr($first_page->mPosts[$i]['handle'], 0, 1).'</b></span>
										</span>
									</a>';
								}
								else {
									echo '
									<a href="'.$first_page->mPosts[$i]['link_to_user'].'">
										<img src="'.$first_page->mSiteUrl.'images/profile_pictures/'.$first_page->mPosts[$i]['avatar'].'" alt="'.$first_page->mPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
									</a>
									';
								} 
			 					echo '
							</span>
							<span class="grey-text text-darken-2" style="position:absolute;left:27px;top:0;">
								<b>&nbsp;<a href="'.$first_page->mPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
										'.$first_page->mPosts[$i]['handle'].'
								</a></b>
							</span>
							<span class="grey-text text-darken-2" style="position:absolute;top:20px;left:27px;">
								&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($first_page->mPosts[$i]['date_posted'])).'"></span>
							</span>';
							echo '
						</p>';
							if (!is_null($first_page->mPosts[$i]['job_id'])) {
								echo '
								<br>
								<h6 class="truncate" title="tag '.$first_page->mPosts[$i]['position_name'].' at '.$first_page->mPosts[$i]['company_name'].'">
									<small>
										<a class="teal-text truncate" href="'.$first_page->mPosts[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$first_page->mPosts[$i]['position_name'].' at '.$first_page->mPosts[$i]['company_name'].'
										</a>
									</small>
								</h6>
								';
							}
							else {
								echo '<br>';
							}
							echo '
							<br>
							<span style="white-space:pre-line;"><a id="postOnlineText'.$i.'" href="'.$first_page->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$first_page->mPosts[$i]['post'].'</a></span>
							<script>
								$(document).ready(function() {
									var fullReviewText'.$i.' = $("#postOnlineText'.$i.'").text();
									if ($("#postOnlineText'.$i.'").text().length > 350) {
										var extractText = $("#postOnlineText'.$i.'").text().substring(0, 350);
										$("#postOnlineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
									}
									$(".card_content_my_stream'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
										event.preventDefault();
										$("#postOnlineText'.$i.'").text(fullReviewText'.$i.');
									});
								});
							</script>
							<br><br>';
							if (!empty($first_page->mPosts[$i]['post_images']) || !is_null($first_page->mPosts[$i]['post_images'])) {
								for ($m=0; $m<count($first_page->mPosts[$i]['post_images']); $m++) {
									if (count($first_page->mPosts[$i]['post_images']) == 1) {
										echo '
											<div class="row">
												<div class="col s12">
													<img src="'.$first_page->mSiteUrl.'/images/post_images/'.$first_page->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$first_page->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
												</div>
											</div>
										';
									}
									if (count($first_page->mPosts[$i]['post_images']) == 2) {
										if ($m == 0) {
											echo '<div class="row">';
										}
										echo '
											<div class="col s6 m6 l6">
												<img src="'.$first_page->mSiteUrl.'/images/post_images/'.$first_page->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$first_page->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
											</div>
										';
										if ($m == 1) {
											echo '</div>';
										}
									}
									if (count($first_page->mPosts[$i]['post_images']) == 3) {
										if ($m == 0) {
											echo '<div class="row">';
										}
										if ($m == 0 || $m == 1)
										echo '
											<div class="col s6 m6 l6">
												<img src="'.$first_page->mSiteUrl.'/images/post_images/'.$first_page->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$first_page->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
											</div>
										';
										if ($m == 1) {
											echo '</div>';
										}
										if ($m == 2) {
											echo '
											<div class="row">
												<div class="col s12">
													<img src="'.$first_page->mSiteUrl.'/images/post_images/'.$first_page->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$first_page->mPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
												</div>
											</div>
											';
										}
									}
									if (count($first_page->mPosts[$i]['post_images']) == 4) {
										if ($m == 0 || $m == 2) {
											echo '<div class="row">';
										}
										echo '
											<div class="col s6 m6 l6">
												<img src="'.$first_page->mSiteUrl.'/images/post_images/'.$first_page->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$first_page->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
											</div>
										';
										if ($m == 1 || $m == 3) {
											echo '</div>';
										}
									}
								}
							}
							echo '
							<div class="divider"></div>
							<div style="position:relative;" id="like_functionality_'.$i.'">';
								echo '
								<a href="'.$first_page->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$first_page->mPosts[$i]['comments_count'].'</a>';
								if ($first_page->_mUserId != 0) {
									echo '
									<span style="position:absolute;left:46%;" id="like_post_functionality_'.$i.'" class="scale-transition ';
										if ($first_page->mPosts[$i]['is_liked'] == 'yes') {
											echo 'scale-out';
										}
										else {
											echo 'scale-in';
										}
										echo '
										">
											<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
									</span>
									<span style="position:absolute;left:46%;" id="dislike_post_functionality_'.$i.'" class="scale-transition ';
										if ($first_page->mPosts[$i]['is_liked'] == 'yes') {
											echo 'scale-in';
										}
										else {
											echo 'scale-out';
										}
										echo ' 
										">
										<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$i.'"></i>
									</span>';
								}
								else {
									echo '
									<span style="position:absolute;left:46%;">
										<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
									</span>';
								}
								echo '
								<span style="position:absolute;left:53%;" id="liked_text_'.$i.'"> &nbsp;'.$first_page->mPosts[$i]['total_likes'].'</span>';
								if ($first_page->_mUserId != 0) {
									echo '
									<script>
										$(document).ready(function() {
											$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
												$("#like_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
												var liked_text = $("#liked_text_'.$i.'").text();
												liked_text++;
												$("#liked_text_'.$i.'").html(" &nbsp;" + liked_text);
												$("#dislike_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
												$.post("'.$first_page->mSiteUrl.'",
												{Like: "Like", PostId: '.$first_page->mPosts[$i]['post_id'].'},
												function(data) {
													// nothing
												}
												)
											});
											$("#like_functionality_'.$i.'").on("click", "#dislike_post_functionality_'.$i.'", function(){
												$("#like_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
												var disliked_text = $("#liked_text_'.$i.'").text();
												disliked_text--;
												$("#liked_text_'.$i.'").html(" &nbsp;" + disliked_text);
												$("#dislike_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
												$.post("'.$first_page->mSiteUrl.'",
												{Dislike: "Dislike", PostId: '.$first_page->mPosts[$i]['post_id'].'},
												function(data) {
													// nothing
												}
												)
											});
										});
									</script>';
								}
								else {
									echo '
									<script>
										$(document).ready(function() {
											$("#like_functionality_'.$i.'").on("click", ".like_post_grey_'.$i.'", function(event){
												event.preventDefault();
												window.location.href = "'.$first_page->mLinkToLoginPage.'";
											});
										});
									</script>';
								}
								echo '
								<span class="right share_dropdown-trigger_'.$i.'" data-target="share_dropdown_'.$i.'"><span class="fas fa-share"></span> Share</span>
								<ul id="share_dropdown_'.$i.'" class="dropdown-content">
									<li><a href="#!" class="facebook_link_'.$i.'" target="_blank"><b><small><i class="fab fa-facebook-square"></i> Facebook</small></b></a></li>
									<li><a href="#!" target="_blank" class="twitter_link_'.$i.'"><b><small><i class="fab fa-twitter"></i> Twitter</small></b></a></li>
									<li><a href="#!" target="_blank" class="linkedin_link_'.$i.'"><b><small><i class="fab fa-linkedin"></i> LinkedIn</small></b></a></li>
									<li><a href="#!" target="_blank" class="whatsapp_link_'.$i.'" data-action="share/whatsapp/share"><b><small><i class="fab fa-whatsapp"></i> WhatsApp</small></b></a></li>
									<li><a href="#!" target="_blank" class="telegram_link_'.$i.'"><b><small><i class="fab fa-telegram"></i> Telegram</small></b></a></li>
								</ul>
								<script>
									$(document).ready(function() {
										$(".share_dropdown-trigger_'.$i.'").dropdown();
										var share_url = encodeURIComponent("'.$first_page->mPosts[$i]['link_to_post_details'].'");

										$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
										$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
										$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$first_page->mPosts[$i]['handle'].'" + "&source=JobStack");
										$(".whatsapp_link_'.$i.'").attr("href", "whatsapp://send?text=" + share_url);
										$(".telegram_link_'.$i.'").attr("href", "https://telegram.me/share/url?url=" + share_url);
									});
								</script>
							</div>
						</div>
					</div>
		</div>';
	}

	echo '
	</div>
	<div class="row">
		<div class="col s12">
			<p class="center">
			<a href="'.$first_page->mLinkToTrendingChatter.'" class="btn waves-light red lighten-2 white-text">more chatter</a>
			</p>
		</div>
	</div>
	<br>
	<div class="divider"></div>
	<br>';
?>