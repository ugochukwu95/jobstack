<?php
    require_once PRESENTATION_DIR . 'post_job.php';
    $post_job = new PostJob();
    $post_job->init();
    
    if (!is_null($post_job->mErrorMessage)) {
		echo '
		<br>
		<div class="row">
		    <div class="col s12">
        		<div style="padding:20px;margin-bottom:15px;border-radius:4px;" class="alert white-text red lighten-3">
        			<p class="errorText center">'.$post_job->mErrorMessage.'</p>
        		</div>
        	</div>
        </div>';
	}
	
	if (!is_null($post_job->mSuccessMessage)) {
		echo '
		<br>
		<div class="row">
		    <div class="col s12">
        		<div style="padding:20px;margin-bottom:15px;border-radius:4px;" class="alert white-text teal">
        			<p class="errorText center">'.$post_job->mSuccessMessage.'</p>
        		</div>
        	</div>
        </div>';
	}
    echo '
    <script src="https://www.google.com/recaptcha/api.js?render=6LfSQqsUAAAAAAW5zFnZetn1eGuqtCI24yfuWsXr"></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute("6LfSQqsUAAAAAAW5zFnZetn1eGuqtCI24yfuWsXr", {action: "contact"}).then(function(token) {
				var recaptchaResponse = document.getElementById("recaptchaResponse");
				recaptchaResponse.value = token;
			});
		});
	</script>
    <br>
    <div class="row">
        <div class="col s12">
            <div class="card white">
                <div class="card-content grey-text text-lighten-2">
                    <div class="row">
                        <form class="col s12" method="post" action="'.$post_job->mLinkToUserPostJob.'">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="company_name" name="company_name" value="'.$post_job->mCompanyName.'">
                                    <label for="company_name">Company Name</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="company_website" name="company_website" value="'.$post_job->mCompanyWebsite.'">
                                    <label for="company_website">Company Website</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="cac" name="cac" value="'.$post_job->mCAC.'">
                                    <label for="cac">CAC Registration Number</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="email" id="email" name="email" value="'.$post_job->mEmail.'" class="validate">
                                    <label for="email">Email</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="phone_number" name="phone_number" value="'.$post_job->mPhoneNumber.'">
                                    <label for="phone_number">Phone Number</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="position_name" name="position_name" value="'.$post_job->mPositionName.'">
                                    <label for="position_name">Job Title</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="job_category" name="job_category" value="'.$post_job->mJobCategory.'">
                                    <label for="job_category">Job Category</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="job_location" name="job_location" value="'.$post_job->mJobLocation.'">
                                    <label for="job_location">Job Location</label>
                                    <span class="helper-text">Important! State in Nigeria</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" id="app_deadline" name="app_deadline" value="'.$post_job->mAppDeadline.'">
                                    <label for="app_deadline">Date of Job Expiration</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="textarea1" class="materialize-textarea" name="job_description">'.$post_job->mJobDescription.'</textarea>
                                    <label for="textarea1">Job Description</label>
                                    <span class="helper-text">Important!</span>
                                </div>
                            </div>
                            <p><button type="submit" name="PostJob" class="btn red lighten-2 white-text waves-effect waves-light">Post Job</button>
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
?>