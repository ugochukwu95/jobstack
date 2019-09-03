<?php
	require_once PRESENTATION_DIR . 'cvs.php';
	$cvs = new CVS();

	echo '
	<div class="row">
	    <div class="col l12 m12 s12">
	      <ul class="tabs">
	        <li class="tab col l3"><a class="active" href="#test1">What to include</a></li>
	        <li class="tab col l3"><a href="#test2">Speculative Letters</a></li>
	      </ul>
	    </div>
	</div>
	<div class="row grey-text text-darken-2" id="test1">
	    <div class="col s12">
	        <div class="card white">
    		  <div class="card-content grey-text text-darken-2">
    		    <div class="flow-text">
    		    	<p>Your CV should always be accompanied by a covering letter, unless the employer tells you otherwise. It is a key part of your application. Your letter should demonstrate your suitability for the vacancy and highlight the most important parts of your CV.</p>
    		    	<br>
    				<div class="divider"></div>
    				<br>
    		    	<h4>Format</h4>
    				<p>Ideally your letter should only be one side of A4. It should be typed unless a handwritten letter is specifically requested and you should use the same font style and size used in your CV.</p>
    				<br>
    				<div class="divider"></div>
    				<br>
    				<h4>Beginning and ending</h4>
    				<p>Make sure that you write to the correct person – it\'s important to get their name and job title right. If a name is not given, try to find out who you should address your letter to by contacting the company or checking the website.</p>
    
    				<p>When addressing your letter, use title and last name only. If you can\'t find out the name of the person, use \'Dear Sir/Madam\'.</p>
    
    				<p>Finish your letter in a polite and friendly way, saying when you would be available for interview. End on a positive note, eg \'I would welcome the opportunity to discuss at interview what I could bring to this role.\'</p>
    
    				<p>To end your letter, write \'Yours sincerely\' if you know the name of the person you\'re writing to, or \'Yours faithfully\' if you don\'t know the name, followed by your signature.</p>
    
    				<p>Sign a posted letter by hand. If you\'re sending it electronically, try scanning your signature.</p>
    				<br>
    				<div class="divider"></div>
    				<br>
    				<h4>Introduction</h4>
    				<p>Briefly explain what you are doing now and why you are writing.</p>
    
    				<p>If the job or placement was advertised, include where and when you saw the advert. If you are applying speculatively (ie not in response to an advertised position), be as specific as you can about what you are looking for.</p>
    
    				<p>A strong, confident and positive opening statement makes a good first impression, eg \'I believe I have the relevant skills, knowledge and experience to make a real difference in this role and in your organisation.\'</p>
    				<br>
    				<div class="divider"></div>
    				<br>
    				<h4>Summarise what you have to offer</h4>
    				<p>Summarise the key selling points from your CV which demonstrate that you have what they are looking for. This should be a concise summary with specific examples, rather than talking about generic skills and qualities in isolation. For example, \'I am a reliable and trustworthy person with good communication skills\' doesn\'t demonstrate to the employer how you developed your skills.</p>
    
    				<p>Convey your enthusiasm for the job and what you can do for the company, rather than talking about yourself in a general way.</p>
    
    				<p>Give reasons why the organisation should consider you. What have you got to offer them? Talk about any relevant experience, knowledge and skills and how you could make a contribution.</p>
    
    				<p>Try not to repeat phrases from your CV. Make sure that your CV clearly provides evidence for statements that you make in the letter.</p>
    				<br>
    				<div class="divider"></div>
    				<br>
    				<h4>Target the employer</h4>
    				<p>Each letter should be tailored to the particular organisation and role. Recruiters will not be impressed with a generic covering letter.</p>
    
    				<p>Explain why you want to work for this organisation, eg their ethos, product, location, or contact you have had with people who work there.</p>
    
    				<p>You should also show that you have researched the organisation and know what they do, but don\'t just repeat what is on their website.</p>
    				<br>
    				<div class="divider"></div>
    				<br>
    				<h4>Other relevant information</h4>
    				<p>It may be relevant to include other information in your covering letter, eg sharing information about a disability or explaining the circumstances of disappointing academic grades.</p>
    		    </div>
    		   </div>
    		  </div>
    		 </div>
    		</div>
    <div class="row grey-text text-darken-2" id="test2">
	    <div class="col s12">
	        <div class="card white">
    		  <div class="card-content grey-text text-darken-2">
    		    <div class="flow-text">
    		    	<p>A speculative letter will contain the same information as one for an advertised post, with some additions. Read on to find out what you should include.</p>
    		    	<br>
    				<div class="divider"></div>
    				<br>
    				
    				<h4>Contact name</h4>
    				<p>Try to identify a contact name to address your letter to. Contact the company to ask who is responsible for recruitment, or for a key contact in the department or section you wish to work in.</p>
    
    				<br>
    				<div class="divider"></div>
    				<br>
    
    				<h4>Information to include</h4>
    				<p>You should be as specific as you can about the type of work you’re looking for. Consider giving the employer a range of options, so if no vacancies are available you can possibly get involved another way.</p>
    
    				<p>You could ask about:</p>
    				<ul>
    					<li>- permanent vacancies</li>
    					<li>- temporary or part-time work</li>
    					<li>- work experience/shadowing</li>
    					<li>- arranging a brief meeting or the opportunity to talk to a recent graduate.</li>
    				<p>As you’re not applying for a specific advertised post, you may not have a job description to help you. Find out as much as possible about the field of work, the company and the type of role you are interested in. You’ll also need to know which skills are required.</p>
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