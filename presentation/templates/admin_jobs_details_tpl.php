<?php
	require_once PRESENTATION_DIR . 'admin_jobs_details.php';
	$admin_jobs_details = new AdminJobDetails();
	$admin_jobs_details->init();

	echo '
		<div class="container">
			<h5 class="center bebasFont teal-text text-darken-2">Editing JobID #'.$admin_jobs_details->mJob['job_id'].' details </h5>
			<p class="center"><a href="'.$admin_jobs_details->mLinkToJobsAdmin.'" class="waves-effect waves-light btn white-text red lighten-2"><i class="fas fa-arrow-left"></i> Back to Jobs Page</a></p>
		</div>';
	if (!is_null($admin_jobs_details->mErrorMessage)) {
		echo '<p class="red-text">'.$admin_jobs_details->mErrorMessage.'</p>';
	}
	echo '
		<div class="row">
			<form class="col s12" method="post" action="'.$admin_jobs_details->mLinkToJobDetailsAdmin.'">
				<div class="container">
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<textarea id="textarea1" class="materialize-textarea" name="job_description" class="validate" value="">'.$admin_jobs_details->mJob['job_description'].'</textarea>
							<label for="textarea1">Job Description</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6 l6">
							<input type="text" id="datePosted" name="date_posted" class="validate" value="'.$admin_jobs_details->mJob['date_posted'].'">
							<label for="datePosted">Date Posted</label>
						</div>
						<div class="input-field col s6 l6">
							<input type="text" id="dateExpired" name="date_of_expiration" class="validate" value="'.$admin_jobs_details->mJob['date_of_expiration'].'">
							<label for="dateExpired">Expiry Date</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s8 l8">
							<input type="url" id="jobLink" name="job_link" class="validate" value="'.$admin_jobs_details->mJob['job_link'].'">
							<label for="jobLink">Job Link</label>
						</div>
						<div class="input-field col s8 l8">
							<input type="number" id="display" name="display" class="validate" value="'.$admin_jobs_details->mJob['display'].'">
							<label for="display">Display</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s3">
							<input type="number" name="company_id" id="companyId" class="validate" value="'.$admin_jobs_details->mJob['company_id'].'">
							<label for="companyId">Company ID</label>
						</div>
						<div class="input-field col s3">
							<input type="number" name="position_id" id="positionId" class="validate" value="'.$admin_jobs_details->mJob['position_id'].'">
							<label for="positionId">Position ID</label>
						</div>
						<div class="input-field col s3">
							<input type="number" name="job_location_id" id="locationId" class="validate" value="'.$admin_jobs_details->mJob['job_location_id'].'">
							<label for="locationId">Location ID</label>
						</div>
					</div>
					<div class="row">
						<p class="center white-text"><button type="submit" name="UpdateJobInfo" class="btn waves-effect waves-light red lighten-2 white-text center">Update</button></p>
					</div>
				</div>
			</form>
		</div>
	';
?>