<?php
	require_once PRESENTATION_DIR . 'cvs.php';
	$cvs = new CVS();
	echo '
	<div class="row">
	    <div class="col l12 m12 s12">
	      <ul class="tabs flow-text">
	        <li class="tab col l3"><a class="active" href="#test1">Writing</a></li>
	        <li class="tab col l3"><a href="#test2">Organizing</a></li>
	      </ul>
	    </div>
	</div>
	<div class="row grey-text text-darken-2" id="test1">
	    <div class="col s12">
    	    <div class="card white">
    		  <div class="card-content grey-text text-darken-2">
        	    <div >
        	    	<p class="flow-text">The objective of a CV is to inform the recruiter who you are, what you can do and what you have done - and consequently convince them to invite you for an interview. In most cases, your CV provides you with the only opportunity to make a crucial first impression. Read on for our tips on writing a good CV</p>
        	    	<br>
        				<div class="divider"></div>
        			<br>
        			<h4>5 Key Essentials</h4>
        			<p class="flow-text">There\'s no right or wrong way to write a CV, but always remember to tailor it to the role you\'re applying for. If you apply the principles below, you will be able to write a CV for any purpose.</p>
        
        			<p class="teal-text flow-text">1. Relevance</p>
        			<p class="flow-text">Find out what the role involves and show how your knowledge, experience and skills are relevant.</p>
        			<br>
        			<p class="teal-text flow-text">2. Order</p>
        			<p class="flow-text">Put your most relevant information first and give it the most space. Based on what you know about the job, decide what is most relevant, for example, your degree, work experience or voluntary work.</p>
        			<br>
        			<p class="teal-text flow-text">3. Format</p>
        			<p class="flow-text">Aim for a professional-looking CV. This means it should:</p>
        			<ul class="flow-text">
        				<li>- be consistent in layout</li>
        				<li>- have a good balance of text and space</li>
        				<li>- have careful use of italics, bold and underlining</li>
        				<li>- be printed on good quality paper (if posting)</li>
        			</ul>
        			<br>
        			<p class="teal-text flow-text">4. Attention to detail</p>
        			<p class="flow-text">Spelling and grammar must be correct. Check it over carefully. If you\'re unsure, get someone to help you.</p>
        			<br>
        			<p class="teal-text flow-text">5. Letter</p>
        			<p class="flow-text">Always include a covering letter, unless you are asked not to. It introduces you and lets you highlight the important parts of your CV and your reasons for applying.</p>
        			<br>
        			<div class="divider"></div>
        			<br>
        			<h4>How to evidence your skills and experience in your CV</h4>
        			<p class="flow-text">Use the job description and/or person specification to identify the skills and experience the recruiter is looking for. Make sure you provide evidence of these using specific examples. It\'s not enough just to say you have a particular skill, you need to back this up. You can include any achievements or impact your actions had, for example, if you were fundraising for a society, were you successful - how much money did you raise, etc?</p>
        
        			<p class="flow-text">Your examples could come from a range of contexts such as:</p>
        			<ul class="flow-text">
        			<li>- your studies</li>
        			<li>- work experience</li>
        			<li>- part-time jobs</li>
        			<li>- extra-curricular activities, including volunteering</li>
        			</ul>
        			<p class="flow-text">If you’re sending a CV speculatively (ie not in response to an advertised position), you may not have a job description to help you. Find out as much as possible about the field of work, the company and the type of role you are interested in. You’ll also need to know which skills are required</p>
        
        			<p class="flow-text">The following links provide further advice on the skills employers look for, and how to demonstrate them:</p>
        			<ul class="flow-text">
        				<li>- <a href="https://www.prospects.ac.uk/careers-advice/applying-for-jobs/what-skills-do-employers-want" class="red-text text-lighten-2" target="_blank">skills employers want</a> (Prospects)</li>
        				<li>- <a href="https://targetjobs.co.uk/careers-advice/skills-and-competencies" class="red-text text-lighten-2">skills and competencies for graduates</a> (TARGETjobs)</li>
        				<li>- <a href="http://www.prospects.ac.uk/options_with_your_subject.htm" target="_blank" class="red-text text-lighten-2">what I can do with my degree</a> (Prospects) – includes a list of skills you could gain from specific courses</li>
        				<li>- <a target="_blank" href="http://www.theiet.org/students/work-careers/work-experience/selling-your-skills.cfm" class="red-text text-lighten-2">selling your skills to potential employers</a> (Institution of Engineering and Technology - IET)</li>
        				<li>- <a target="_blank" href="https://www.prospects.ac.uk/careers-advice/applying-for-jobs/how-to-write-a-speculative-job-application" class="red-text text-lighten-2">writing a speculative job application</a> (Prospects)</li>
        			</ul>
        	    </div>
        	   </div>
        	</div>
        </div>
        </div>
        <div class="row grey-text text-darken-2"id="test2">
	        <div class="col s12">
            	<div class="card white">
        		  <div class="card-content grey-text text-darken-2">
            	    <div class="flow-text">
            	    	<p>There exist a multitude of different ways to structure your CV. In order to help you decide on the content and layout that will best work for you, we have summarised some typical CV formats.</p>
            	    	<br>
            	    	<div class="divider"></div>
            	    	<br>
            	    	<p>A CV is usually <strong>no more than two pages</strong>, though if you’re applying for academic positions, eg postdoctoral roles, your CV can be longer.</p>
            	    	<p>Different countries have different CV formats.</p>
            	    	<br>
            	    	<div class="divider"></div>
            	    	<br>
            	    	<h4>CV formats</h4>
            			<p class="teal-text">Chronological/traditional</p>
            			<p>This is the most common style of CV and is generally preferred by employers. This type of CV lists your education and experience in reverse chronological order, starting with the most recent and working backwards.</p>
            			<p>This format is particularly useful if your qualifications and/or experience are related to the role, but may not be so effective if your background is less relevant.</p>
            			<br>
            			<p class="teal-text">Skills-based</p>
            			<p>This format focuses on the skills required by the employer, more than on your education and work history. You need to have a very clear understanding of what the employer is looking for and be able to provide evidence through examples.</p>
            			<p>This is a useful style if, for example, you are changing career path and want to highlight transferable skills from non-relevant qualifications and experience.</p>
            			<br>
            			<p class="teal-text">Combination</p>
            			<p>It may be that a combination of chronological and skills-based styles is appropriate. You may have very relevant qualifications that favour a chronological format and varied work experience that benefits from a skills-based approach.</p>
            			<br>
            			<p class="teal-text">Academic</p>
            			<p>Use this style to apply for academic jobs such as a postdoctoral position or lectureship. It tends to be built around three areas:<p>
            			<ul>
            				<li>- your research</li>
            				<li>- teaching</li>
            				<li>- administrative experience</li>
            			</ul>
            			<p>It can also include conferences attended and publications. Length is less important and it may be longer than two pages. For advice and examples of CVs for postgraduate study and academia, see our advice on CVs for specific sectors.</p>
            			<br>
            			<div class="divider"></div>
            			<br>
            			<h4>Further information</h4>
            			<p>See <a href="https://www.ncl.ac.uk/careers/applications/cv/#d.en.340363" target="_blank" class="red-text text-lighten-2">examples of different CV formats</a>.</p>
            			<p>TARGETjobs has additional advice on whether a <a href="https://targetjobs.co.uk/careers-advice/applications-and-cvs/270189-chronological-or-skills-based-which-cv-is-best-for-you" class="red-text text-lighten-2" target="_blank">chronological or skills-based CV is right for you</a>.</p>
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