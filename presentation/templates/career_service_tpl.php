<?php
	require_once PRESENTATION_DIR . 'career_service.php';
	$career_service = new CareerService();
	echo '
	<style>
	.collection-item:hover {
		background-color: ghostwhite;
	}
	</style>
	<div class="row">
	<div class="col s12">
	<div class="card white">
	<div class="card-content">
	<div class="row">
		<div class="col s12 m12 l4 grey-text text-darken-2">
			<h4 class="teal-text bebasFont center">CVs, Applications &amp; LinkedIn Profiles</h4>
		</div>
		<div class="col s12 m12 l8">
			<img src="'.$career_service->mSiteUrl.'images/website_images/other-job-interview.jpg" alt="job-interview-image" style="width:100%;display:block;">
		</div>
	</div>
	<div class="row">
	    <div class="col s12">
	        <p class="flow-text">Grab the recruiter\'s attention using your CV, application or LinkedIn profile.</p>
			<br>
	    </div>
	</div>
	<br>
	<div class="divider"></div>
	<br>
	<div class="row">
		<div class="col s12 grey-text text-darken-2">
			<p class="flow-text grey-text text-darken-2">Valuable time and effort is required in developing a solid application. It\'s more effective to make <strong>a few high quality, well-tailored, applications</strong> than lots of generic ones. Regardless of what Job you are interested in, <span>JOBSTACK</span> is here to provide advice on:</p>
			<br>
			<div class="row">
				<div class="col s12 m12 l8 offset-l2">
					<ul class="collection grey-text text-darken-2">
				        <li class="collection-item avatar cv">
				        	<i class="far fa-file-alt circle teal white-text"></i>
				        	<a href="'.$career_service->mLinkToCVS.'" class=" grey-text text-darken-2">CVs</a>
				        	<a href="#!" class="secondary-content"><i class="fas fa-star"></i></a>
				        </li>
				        <li class="collection-item avatar cover_letter">
				        	<i class="far fa-file-word circle teal white-text"></i>
				        	<a href="'.$career_service->mLinkToCoverLetters.'" class="grey-text text-darken-2">Covering Letters</a>
				        	<a href="#!" class="secondary-content"><i class="fas fa-star"></i></a>
				        </li>
				        <li class="collection-item avatar linkedin_profile">
				        	<i class="fab fa-linkedin circle teal white-text"></i>
				        	<a href="'.$career_service->mLinkToLinkedinProfile.'" class="grey-text text-darken-2">LinkedIn profile</a>
				        	<a href="#!" class="secondary-content"><i class="fas fa-star"></i></a>
				        </li>
				        <li class="collection-item avatar applications">
				        	<i class="fas fa-file-alt circle teal white-text"></i>
				        	<a href="'.$career_service->mLinkToApplications.'" class="grey-text text-darken-2">Applications</a>
				        	<a href="#!" class="secondary-content"><i class="fas fa-star"></i></a>
				        </li>
				    </ul>
				    <script>
				    	$(document).ready(function() {
				    		$(".cv").click(function(event) {
				    			window.location.href="'.$career_service->mLinkToCVS.'";
				    		});
				    		$(".cover_letter").click(function(event) {
				    			window.location.href="'.$career_service->mLinkToCoverLetters.'";
				    		});
				    		$(".linkedin_profile").click(function(event) {
				    			window.location.href="'.$career_service->mLinkToLinkedinProfile.'";
				    		});
				    		$(".applications").click(function(event) {
				    			window.location.href="'.$career_service->mLinkToApplications.'";
				    		});
				    	});
				    </script>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="divider"></div>
	<br>
	<div class="row">
		<div class="col s12 grey-text text-darken-2">
			<h5>Watch your internet footprint</h5>
			<p class="flow-text">Employers are increasingly searching the internet before selecting candidates, including sites such as Instagram, Twitter and Facebook. There have been cases where employers have withdrawn job offers to people who have made inappropriate or negative comments about the company or its staff.</p>
			<p class="flow-text">Make sure that whatever you write on a public website is something that you would be happy for a potential recruiter to see. TARGETjobs provides advice on <a target="_blank" href="https://targetjobs.co.uk/careers-advice/networking/273059-social-networking-and-graduate-recruitment-manage-your-online-reputation" class="red-text text-lighten-2">managing your online reputation</a>.</p>
		</div>
	</div>
	<br>
		<div class="divider"></div>
	 <br>
	 <p><small class="grey-text text-darken-2 right">Reference: Our friends at <a href="https://www.ncl.ac.uk/careers/applications/cv/" class="red-text text-lighten-2" target="_blank">Newcastle University</a>.</small></p>
	 <br>
	 <br>
		<div class="divider"></div>
	 <br>
	 </div></div></div></div>
	';
?>