<?php
	require_once PRESENTATION_DIR . 'admin_jobs.php';
	$admin_jobs = new AdminJobs();
	$admin_jobs->init();

	if (!is_null($admin_jobs->mErrorMessage)) {
		echo '
		<div class="center red"> 
			<h4 class="white-text center">'.
				$admin_jobs->mErrorMessage
			.'</h4>
		</div>
		';
	}

	if ($admin_jobs->mSearchDescription != '') {
		echo '
		<h1 class="center">:-(</h1>
		<p class="center">'.$admin_jobs->mSearchDescription.'</p>';
	}
	elseif ($admin_jobs->mJobsCount == 0) {
		echo '<p class="center">There are no job postings in the database</p>';
	}
	else {
		echo '
		<div class="row">
			<div class="col s12 l8 offset-l2">
				<h5 class="teal-text text-darken-2 bebasFont center">Jobs Admin</h5>
			</div>
		</div>
		<div class="row">	
			<div class="col s12 l8 offset-l2">
			<form class="col s12" method="POST" action="'.$admin_jobs->mLinkToJobsAdmin.'">
				<table class="responsive-table grey-text text-darken-2">
					<thead>
						<tr>
							<th>Position</th>
							<th>Company</th>
							<th>Posted</th>
							<th>Expiry</th>
							<th>Location</th>
							<th></th>
						</tr>
					</thead>
					<tbody>';

					for ($i=0; $i<count($admin_jobs->mJobs); $i++) {
						echo'
							<tr>
								<td>'.$admin_jobs->mJobs[$i]['position_name'].'</td>
								<td>'.$admin_jobs->mJobs[$i]['company_name'].'</td>
								<td>'.$admin_jobs->mJobs[$i]['date_posted'].'</td>
								<td>'.$admin_jobs->mJobs[$i]['date_of_expiration'].'</td>
								<td>'.$admin_jobs->mJobs[$i]['location_name'].'</td>
								<td>
									<span><button type="submit" name="submit_edit_jobs_'.$admin_jobs->mJobs[$i]['job_id'].'" class="btn waves-effect waves-light teal white-text"><i class="far fa-edit"></i> Edit</button></span> &nbsp;<span><a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="#modal'.$i.'"><i class="fas fa-trash"></i> Delete</a></span>
									<div id="modal'.$i.'" class="modal">
										<div class="modal-content">
											<h4 class="center">DELETE!</h4>
											<p class="center">Are you sure you want to delete job: #'.$admin_jobs->mJobs[$i]['job_id'].'?</p>
										</div>
										<div class="modal-footer">
											<input type="submit" name="submit_delete_jobs_'.$admin_jobs->mJobs[$i]['job_id'].'" class="center modal-close btn-flat waves-effect waves-light red" value="Delete">
										</div>
									</div>
								</td>
							</tr>
						';
					}

					echo '
					</tbody>
				</table>
			</form>
			</div>
		</div>
				';
		if (count($admin_jobs->mJobsListPages) > 1) {
			echo '
			<div class="row">
				<div class="col s12 m12 l6 offset-l3">
				<p class="center">Page '.$admin_jobs->mPagination.' of '.$admin_jobs->mrTotalPages.'</p>
				<ul class="pagination center">';
					if (isset($admin_jobs->mLinkToPreviousPage)) {
						echo '<li class="waves-effect"><a href="'.$admin_jobs->mLinkToPreviousPage.'"><i class="fas fa-chevron-left"></i></a></li>';
					}
					else {
						echo '<li class="disabled"><a href="#!"><i class="fas fa-chevron-left"></i></a></li>';
					}
					if (isset($admin_jobs->mLinkToNextPage)) {
						echo '<li class="waves-effect"><a href="'.$admin_jobs->mLinkToNextPage.'"><i class="fas fa-chevron-right"></i></a></li>';
					}
					else {
						echo '<li class="disabled"><a href="#!"><i class="fas fa-chevron-right"></i></a></li>';
					}
			echo '</ul></div></div>';
		}

		echo '
		<div class="section">
			<div class="row">
			<h5 class="center teal-text bebasFont text-darken-2">Add new job</h5>
			<form class="col s12" autocomplete="off" method="POST" action="'.$admin_jobs->mLinkToJobsAdmin.'">
			<div class="container">
				<div class="row">
					<div class="input-field col s12 l8 offset-l2">
						<textarea id="textarea1" class="materialize-textarea" name="job_description" class="validate">'.$admin_jobs->mJobDescription.'</textarea>
						<label for="textarea1">Job Description</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6 l6">
						<input type="text" class="datepicker" id="datePosted" name="date_posted" class="validate" value="'.$admin_jobs->mDatePosted.'">
						<label for="datePosted">Date Posted</label>
					</div>
					<div class="input-field col s6 l6">
						<input type="text" class="datepicker" id="dateExpired" name="date_of_expiration" class="validate" value="'.$admin_jobs->mDateOfExpiry.'">
						<label for="dateExpired">Expiry Date</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s8 l8">
						<input type="url" id="jobLink" name="job_link" class="validate" value="'.$admin_jobs->mJobLink.'">
						<label for="jobLink">Job Link</label>
					</div>
					<div class="input-field col s4 l4">
						<input type="number" name="display" id="displayId" class="validate" value="1">
						<label for="displayId">Display ID</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input type="text" name="company_name" id="companyId" class="company_autocomplete" value="'.$admin_jobs->mCompanyName.'">
						<label for="companyId">Company</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input type="text" name="location_name" id="locationId" class="location_autocomplete" value="'.$admin_jobs->mLocationName.'">
						<label for="locationId">Location</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input type="text" name="position_name" id="positionId" class="position_autocomplete" value="'.$admin_jobs->mPositionName.'">
						<label for="positionId">Position</label>
					</div>
				</div>
				<div class="row">
					<p class="center">
						<button type="submit" name="submit_add_jobs_0" class="btn waves-effect waves-light white-text red lighten-2 center"><i class="fas fa-plus-square"></i> Add</button>
					</p>
				</div>
			</div>
			</form>
			</div>
		</div>
		<script>
		$(document).ready(function() {
			var admin_positions = JSON.parse(JSON.stringify('.$admin_jobs->mPositions.')), position_data = {}, x;
			for (x in admin_positions) {
				if (admin_positions.hasOwnProperty(x)) {
					position_data[admin_positions[x]] = null;
				}
			}
			$("input.position_autocomplete").autocomplete({
				data: position_data
			});

			var admin_locations = JSON.parse(JSON.stringify('.$admin_jobs->mLocations.')), location_data = {}, x;
			for (x in admin_locations) {
				if (admin_locations.hasOwnProperty(x)) {
					location_data[admin_locations[x]] = null;
				}
			}
			$("input.location_autocomplete").autocomplete({
				data: location_data
			});

			var admin_companies = JSON.parse(JSON.stringify('.$admin_jobs->mCompanies.')), company_data = {}, c;
			for (c in admin_companies) {
				if (admin_companies.hasOwnProperty(c)) {
					company_data[admin_companies[c]] = null;
				}
			}
			$("input.company_autocomplete").autocomplete({
				data: company_data
			});
		})
		</script>
	';
	}
?>