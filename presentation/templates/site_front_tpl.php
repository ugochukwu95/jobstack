<?php
	require_once SITE_ROOT . '/include/site_title.php';
	require_once SITE_ROOT . '/presentation/site_front.php';
	
	// title of the site
	$title = new SiteTitle();
	$site_title = $title->mSiteTitle;

	// build home page links
	$homepage = new SiteFront();
	$homepage->init();
	$homepage_link = $homepage->mSiteUrl;
    $copyYear = 2019; 
    $curYear = date("Y"); 
    $today = $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
echo '
<!DOCTYPE html>
<html>
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-143051163-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag(\'js\', new Date());

		  gtag(\'config\', \'UA-143051163-1\');
		</script>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" media="screen,projection" shrink-to-fit=no>
		<meta name="description" content="'.$homepage->mPageDescription.'" />

		<meta property="og:title" content="'.$homepage->mPageTitle.'">
		<meta property="og:description" content="'.$homepage->mPageDescription.'">
		<meta property="og:image" content="'.$homepage->mLinkToLogo.'">
		<meta property="og:url" content="">
		<meta name=twitter:card" content="summary_large_image">
		<meta name="yandex-verification" content="065b77a16bce8244" />
		<meta name="google-site-verification" content="ofGjQMWBfYq8UDP6171ttvZ0GJ4z5sjD_j0TqRYECj8" />
		
		<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

		<link rel="stylesheet" href="'.$homepage_link.'styles/jobstack-styles.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="manifest" href="/manifest.json" />
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
          var OneSignal = window.OneSignal || [];
          OneSignal.push(function() {
            OneSignal.init({
              appId: "c3f7c485-063b-44d7-b2b4-ff5b263804b1",
            });
          });
        </script>
		<title>'.$homepage->mPageTitle.'</title>
		<style>
		  
            
            .right_collection_list {
                
            }
            
            .right_collection_list li:hover, .trending_stuff li:hover {
                background-color: #b2dfdb !important;
                cursor: pointer;
            }
            .card_color:hover, .trending-chatter:hover {
    	        background-color: #e0f2f1 !important;
    	    }
    	    
    	.sidenav li a:hover, .sidenav li>a:hover>i {
    	        background-color: #e0f2f1;
    	        color: #00796b !important;
    	    }
    	    
    	    
    	    .sidenav li.active {
    	        background-color: transparent;
    	    }
    	    
    	    .sidenav li.active a, .sidenav li.active>a>i {
    	        color: #00bfa5 !important;
    	    }
    	    
    	    .sidenav li>a  {
    	        font-size: 18px;
    	        font-weight: bold;
    	        height: 56px;
    	        line-height: 56px;
    	        padding: 0 24px;
    	    }
    	    .sidenav li>a>i {
    	        font-size: 24px;
    	        margin-top: 2px;
    	        height: 56px !important;
    	        line-height: 56px !important;
    	    }
    	    .sidenav li>a>.badge {
    	        font-size: 20px;
    	        margin-top: 0px;
    	        height: 56px !important;
    	        line-height: 56px !important;
    	    }
    	    
    	      body {
                display: flex;
                min-height: 100vh;
                flex-direction: column;
              }
            
              main {
                flex: 1 0 auto;
              }
        
            @media only screen and (max-width : 1007px) {
              
              .right_collection_list {
                  display: none;
              }
            }
		</style>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="'.$homepage_link.'styles/moment.min.js" defer></script>
		<script type="text/javascript" src="'.$homepage_link.'styles/livestamp.min.js" defer></script>
		<script type="text/javascript" src="'.$homepage_link.'styles/jquery.timeago.js" defer></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script type="application/ld+json">
		    {
		        "@context": "http://schema.org",
                "@type": "Organization",
                "name": "JOBSTACK",
                "url": "'.$homepage_link.'",
                "logo": "'.$homepage->mLinkToLogo.'",
                "description": "At JOBSTACK thousands of employers are seeking your talent. Find all the latest jobs in Nigeria that match your skills. Find out more information about companies in Nigeria and across over 140 countries. Find out the latest news about jobs on offer on our website and interact with fellow users.",
		        "contactPoint": {
		            "@type": "ContactPoint",
		            "telephone": "+234 (0) 8108119679",
		            "contactType": "customer service"
		        }
		    }
		</script>
	</head>

	<body class="grey lighten-5">
	<header class="">
	    <div class="navbar-fixed">
    	<nav class="white teal-text z-depth-0" style="border-bottom: 1px solid lightgrey;">
    		<div class="nav-wrapper">
    			<a href="#!" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="material-icons grey-text text-darken-2">menu</i></a>
    			<a href="'.$homepage_link.'" class="center brand-logo teal-text text-darken-2 bebasFont"><b>'.$homepage->mPageName.'</b></a>
    			<ul class="show-on-large" id="nav-mobile">
    				<li class="right"><a href="#" class="teal-text text-darken-2 openSearchNav"><i class="material-icons">search</i></a></li>
    				<li class="'.$homepage->mAllJobsActiveLink.' left hide-on-med-and-down"><a href="'.$homepage->mLinkToAllJobsUrl.'" class="teal-text text-darken-2"><i class="material-icons left">work_outline</i>All Jobs</a></li>
    				<li class="'.$homepage->mAllCompaniesActiveLink.' left hide-on-med-and-down"><a href="'.$homepage->mLinkToAllCompaniesUrl.'" class="teal-text text-darken-2"><i class="material-icons left">business</i>All Companies</a></li>

    				<li class="'.$homepage->mCareerServiceActiveLink.' right hide-on-med-and-down truncate"><a href="'.$homepage->mLinkToCareerService.'" class="teal-text text-darken-2 truncate"><i class="material-icons left">assignment_ind</i>CVs, Applications & LinkedIn Profiles</a></li>
    				<!--<li class="right hide-on-med-and-down truncate"><a href="'.$homepage->mLinkToPostJob.'" class="btn teal white-text waves-light waves-effect truncate">Post Job</a></li>-->
    			</ul> 
    		</div>
    	</nav>
    	</div>
    	<ul id="slide-out" class="sidenav white grey-text text-darken-2 z-depth-0" style="border-right:1px solid lightgrey;">
    		<li><a href="'.$homepage_link.'" class="grey-text text-darken-2 bebasFont"><img src="'.$homepage->mLinkToLogo.'" style="height:100px;width:100px;margin-top:20px;"></a><br><br></li>
    		<li class="'.$homepage->mSiteActiveLink.' flow-text"><a href="'.$homepage_link.'" class="grey-text text-darken-2 flow-text"><i class="material-icons">home</i>Home</a></li>
    		<li class="'.$homepage->mAllJobsActiveLink.'"><a href="'.$homepage->mLinkToAllJobsUrl.'" class="grey-text text-darken-2"><i class="material-icons">work</i>All Jobs</a></li>
    		<li class="'.$homepage->mTrendingChatterActiveLink.'"><a href="'.$homepage->mLinkToTrendingChatterUrl.'" class="grey-text text-darken-2"><i class="material-icons">chat</i>Trending Chatter</a></li>
    		<li class="'.$homepage->mSavedJobsLink.'"><a href="'.$homepage->mLinkToSavedJobsUrl.'" class="grey-text text-darken-2"><i class="material-icons">favorite</i>Saved Jobs <span class="badge">'.$homepage->mCartSummaryBadge.'</span></a></li>
    		<li class="'.$homepage->mAllCompaniesActiveLink.'"><a href="'.$homepage->mLinkToAllCompaniesUrl.'" class="grey-text text-darken-2"><i class="material-icons">business</i>All Companies</a></li>';
    		include $homepage->mLoginOrLoggedCell;
    		echo '
    		<li class="center truncate"><br><a href="'.$homepage->mLinkToPostJob.'" class="btn teal white-text waves-light waves-effect truncate">Post Job</a></li>
    	</ul>
    	
	</header>
	<main>
	    <!-- Search box -->
	    <div id="mySidenav" class="scale-transition scale-out search_sidenav">
	        <p class="center"><button class="closeNav red lighten-2 center btn-floating"><i class="material-icons">close</i></button></p>';
	        include 'catalog_search_box_tpl.php';
	    echo'
	    </div>
	    
	    <div class="row">
	        <div class="col l3 s12 hide-on-med-and-down">
    	        <div class="right_collection_list">
    	            <ul class="collection hide-on-med-and-down with-header white lighten-5" style="border-top:none;border-radius:8px;">
            		    <li class="collection-header white lighten-5"><h6 class="center"><strong>Highest Hiring Companies</strong></h6></li>';
            		    for ($i=0; $i<count($homepage->mTrendingCompanies); $i++) {
            		        echo '
            		        <li class="collection-item avatar white lighten-5 link_to_company_'.$i.'">
            		        <img src="'.$homepage->mTrendingCompanies[$i]['image'].'" alt="'.$homepage->mTrendingCompanies[$i]['company_name'].'. logo" class="circle">
            		        <span class="title grey-text text-darken-2"><strong><a href="'.$homepage->mTrendingCompanies[$i]['link_to_company'].'" class="grey-text text-darken-4">
            		            Jobs at '.$homepage->mTrendingCompanies[$i]['company_name'].'</a></strong></span>
            		        <p class="grey-text text-darken-1">'.$homepage->mTrendingCompanies[$i]['jobs_count'].' jobs</p></li>';
            		    }
            		echo '
            		</ul>
            	</div>
	        </div>
	        <div class="col l6 s12">
	            <div class="more_post_functionality">';
        			require_once $homepage->mContentsCell;
        			echo '
        		</div>
	        </div>
	        <div class="col l3 s12">
	            <!-- Trending locations functionality -->
        		<div class="right_collection_list">
            		<ul class="collection hide-on-med-and-down with-header white lighten-5" style="border-top:none;border-radius:8px;">
            		    <li class="collection-header white lighten-5"><h6 class="center"><strong>Highest Hiring Locations</strong></h6></li>';
                		for ($i=0; $i<count($homepage->mTrendingLocations); $i++) {
                		    echo '
                            <li class="collection-item white lighten-5 link_to_job_'.$i.'">
                            <small class="grey-text text-darken-1">'.($i+1).' Trending</small><br>
                            <strong><a href="'.$homepage->mTrendingLocations[$i]['link_to_location'].'" class="grey-text text-darken-4">
                            Jobs in '.$homepage->mTrendingLocations[$i]['location_name'].'</a></strong><br>
                            <span class="grey-text text-darken-1">'.$homepage->mTrendingLocations[$i]['jobs_count'].' jobs</span></li>
                		    ';
                		}
            		echo '
            		</ul>
            		<ul>
            		    <li><small><a href="'.$homepage->mLinkToUserTerms.'" class="red-text text-lighten-2">User Terms</a>  <a href="'.$homepage->mLinkToPrivacyPolicy.'" class="red-text text-lighten-2">Privacy Policy</a>  <a href="'.$homepage->mLinkToContactDeveloper.'" class="red-text text-lighten-2">Contact the developer</a></small></li>
            			<li><small>&copy; '.date("Y").' Jobstack - All rights reserved.</small></li>
            		</ul>
        		</div>';
        		for ($i=0; $i<count($homepage->mTrendingLocations); $i++) {
        		   echo '
        		   <script>
        		        $(document).ready(function() {
        		            $(".right_collection_list").on("click", ".link_to_job_'.$i.'", function(){
        		                window.location.href = "'.$homepage->mTrendingLocations[$i]['link_to_location'].'";
        		            });
        		        });
        		   </script>
        		   '; 
        		}
        		for ($i=0; $i<count($homepage->mTrendingCompanies); $i++) {
        		   echo '
        		   <script>
        		        $(document).ready(function() {
        		            $(".right_collection_list").on("click", ".link_to_company_'.$i.'", function(){
        		                window.location.href = "'.$homepage->mTrendingCompanies[$i]['link_to_company'].'";
        		            });
        		        });
        		   </script>
        		   '; 
        		}
	        echo '
	        </div>
	    </div>';
	echo '
	</main>
	<footer class="hide-on-large-only">
	    <ul>
		    <li><small><a href="'.$homepage->mLinkToUserTerms.'" class="red-text text-lighten-2">User Terms</a>  <a href="'.$homepage->mLinkToPrivacyPolicy.'" class="red-text text-lighten-2">Privacy Policy</a>  <a href="'.$homepage->mLinkToContactDeveloper.'" class="red-text text-lighten-2">Contact the developer</a></small></li>
			<li><small>&copy; '.date("Y").' Jobstack - All rights reserved.</small></li>
		</ul>
	</footer>
	<script>
		$(document).ready(function() {
			$(".openSearchNav").click(function(event) {
				event.preventDefault();
				$("#mySidenav").removeClass("scale-out").addClass("scale-in");
			});

			$(".closeNav").click(function(event) {
				event.preventDefault();
				$("#mySidenav").removeClass("scale-in").addClass("scale-out");
			});
			// Code to activate all Materialize components
			M.AutoInit();
			
			$("time.timeago").timeago();
			$("meta[property=\'og:url\']").attr("content", window.location.href);
		});	    
	</script>	
</html>';
?>







