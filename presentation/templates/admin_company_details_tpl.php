<?php
	require_once PRESENTATION_DIR . 'admin_company_details.php';
	$admin_company_details = new AdminCompanyDetails();
	$admin_company_details->init();
		
	if (!is_null($admin_company_details->mErrorMessage)) {
		echo '
		<div class="row">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$admin_company_details->mErrorMessage.'
				</div>
			</div>
		<div>
		';
	}
	elseif (!is_null($admin_company_details->mSuccessMessage)) {
		echo '
			<div class="row">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox green black-text lighten-2">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$admin_company_details->mSuccessMessage.'
				</div>
			</div>
		<div>';
	}

	echo '
	<div class="container">
		<h5 class="center bebasFont teal-text text-darken-2">Editing CompanyID #'.$admin_company_details->mCompany['company_id'].' details </h5>
		<p class="center">
			<small>
			<a href="'.$admin_company_details->mLinkToCompaniesAdmin.'" class="waves-effect waves-light btn white-text red lighten-2"><i class="fas fa-arrow-left"></i> Back to companies page</a>
			</small>
		</p>
	</div>';
		
	echo '
		<div class="row">
			<form class="col s12" method="post" action="'.$admin_company_details->mLinkToCompanyDetailsAdmin.'">
				<div class="container">
					<div class="row">
						<div class="input-field col s12">
							<input type="text" id="companyName" name="company_name" class="validate" value="'.$admin_company_details->mCompany['name'].'">
							<label for="companyName">Company Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="url" id="companyLink" name="company_link" class="validate" value="'.$admin_company_details->mCompany['link'].'">
							<label for="companyLink">Company Link</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="text" id="companyImage" name="company_image" class="validate" value="'.$admin_company_details->mCompany['image'].'">
							<label for="companyImage">Company Image</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<textarea id="textarea1" class="materialize-textarea" name="company_description" class="validate" value="">'.$admin_company_details->mCompany['company_description'].'</textarea>
							<label for="textarea1">Company Description</label>
						</div>
					</div>
					<div class="row">
						<p class="center"><button type="submit" name="UpdateCompanyInfo" class="btn waves-effect waves-light red lighten-2 white-text center">Update</button></p>
					</div>
				</div>
			</form>
		</div>
	';
?>