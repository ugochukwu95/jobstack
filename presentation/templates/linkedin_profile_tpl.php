<?php
	require_once PRESENTATION_DIR . 'cvs.php';
	$cvs = new CVS();

	echo '
	<div class="row grey-text text-darken-2">
		<div class="col s12">
		    <div class="card white">
		        <div class="card-content grey-text text-darken-2">
		        <div class="flow-text">
        			<h4>Setting up your LinkedIn account</h4>
        			<p>LinkedIn has produced a series of <a href="https://www.youtube.com/watch?v=YWp6AN00D_c" class="red-text text-lighten-2">YouTube videos</a> aimed at students and graduates, taking you through step by step how to set up your LinkedIn account and begin using it for your career.</p>
        			<br>
        				<div class="divider"></div>
        			<br>
        			<h4>Adding a headline to your profile</h4>
        			<p>Headlines act like a brief covering letter to help to sell your skills and passions. It\'s important that they:</p>
        			<ul>
        				<li>- summarise the type of role you\'re seeking</li>
        				<li>- include your area of study and career ambitions</li>
        				<li>- include keywords</li>
        			</ul>
        			<p>The following external websites provide further information about profile headlines:</p>
        			<ul>
        				<li>- <a target="_blank" href="http://www.recruitmentgrapevine.com/article/2014-12-18-linkedin-reveals-the-top-skills-recruiters-searched-for-in-2014?utm_source=eshot&utm_medium=email&utm_campaign=RG%20-%2018/12/2014" class="red-text text-lighten-2">top skills recruiters searched for in 2014</a> (Recruitment Grapevine)</li>
        				<li>- <a target="_blank" href="https://www.youtube.com/watch?v=_7UX1UEHeZk&list=PLUL_viKVCUyDNsOQExaFwXovXkx3izBUn&index=1" class="red-text text-lighten-2">University of Leeds Careers Service video: Completing your profile</a></li> 
        			</ul>
        			<br>
        				<div class="divider"></div>
        			<br>
        			<h4>Include recommendations and endorsements</h4>
        			<p>Ask for recommendations from academics, employers from work experience, part-time jobs etc. If you endorse someone else on LinkedIn, it’s likely that they will return the compliment.</p>
        			<br>
        				<div class="divider"></div>
        			<br>
        			<h4>Include a photo projecting the image you would like to present to employers</h4>
        			<p>You don’t have to have a professional photo taken but ideally you should look smart, friendly and approachable. LinkedIn profiles with photos <a href="http://www.careerealism.com/linkedin-photo-epic-fail" target="_blank" class="red-text text-lighten-2">receive 50-70% more enquiries than profiles without.</a></p>
        			<br>
        				<div class="divider"></div>
        			<br>
        			<h4>Claim your unique LinkedIn URL</h4>
        			<p>To increase the professional results that appear when people search for you online, set your LinkedIn profile to \'public\' and create a unique URL, eg www.linkedin.com/in/JohnSmith. LinkedIn provide <a target="_blank" href="http://help.linkedin.com/app/answers/detail/a_id/87" class="red-text text-lighten-2">instructions for customising public profile URLs</a>.</p>
        			<br>
        				<div class="divider"></div>
        			<br>
        			<h4>Building a great student profile</h4>
        			<p><a href="https://university.linkedin.com/" target="_blank" class="red-text text-lighten-2">University LinkedIn</a> provides a range of resources to help students and graduates.</p>
        
        			<p>Use LinkedIn\'s <a target="_blank" href="http://university.linkedin.com/content/dam/university/global/en_US/site/pdf/LinkedIn_Sample_Profile_onesheet-Amy.pdf#!" class="red-text text-lighten-2">profile checklist</a> (PDF: 1.91MB) and <a target="_blank" href="http://university.linkedin.com/content/dam/university/global/en_US/site/pdf/TipSheet_BuildingaGreatProfile.pdf" class="red-text text-lighten-2">building a great student profile</a> (PDF: 4.11MB) to create an effective LinkedIn profile</p>
		        </div>
		    </div>
		</div>
	</div>
	</div>

	<br>
		<div class="divider"></div>
	<br>
	<nav>
	    <div class="nav-wrapper">
	      <div class="col s12">
	      	<a href="#!" class=""> &nbsp;</a>
	        <a href="'.$cvs->mLinkToCVS.'" class="">CVs ></a> 
	        <a href="'.$cvs->mLinkToCoverLetters.'" class="">Cover Letters ></a>
	        <a href="'.$cvs->mLinkToApplications.'" class="">Applications ></a>
	        <a href="'.$cvs->mLinkToLinkedinProfile.'" class="">Linkedin Profile</a>
	      </div>
	    </div>
	</nav>
	<br><br>
	<p><small class="grey-text text-darken-2 right">Reference: Our friends at <a href="https://www.ncl.ac.uk/careers/applications/cv/" class="red-text text-lighten-2" target="_blank">Newcastle University</a>.</small></p>
	<br>
	<br>
		<div class="divider"></div>
	<br>
	';
?>