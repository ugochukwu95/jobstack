<?php
  require_once PRESENTATION_DIR . 'admin_company.php';
  $admin_companies = new AdminCompanies();
  $admin_companies->init();
  echo '
  <div class="row">
  	<div class="col s12">
  		<h5 class="center bebasFont teal-text">Company Admin</h5>
  	</div>
  </div>
  ';
    if (!is_null($admin_companies->mErrorMessage)) {
		echo '
		<div class="center"> 
			<h4 class="red-text">'.
				$admin_companies->mErrorMessage
			.'</h4>
		</div>
		';
	}
	if ($admin_companies->mSearchDescription != '') {
		echo '
		<h1 class="center">:-(</h1>
		<p class="center">'.$admin_companies->mSearchDescription.'</p>';
	}
	elseif ($admin_companies->mCompaniesCount == 0) {
		echo '<p class="center">There are no companies in the database</p>';
	}
	else {
		echo '
			<div class="row">
				<div class="col s12 l8 offset-l2">
				<form class="center" method="POST" action="'.$admin_companies->mLinkToCompaniesAdmin.'">
					<table class="grey-text text-darken-2">
						<thead>
							<tr>
								<th>Company Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>';

						for ($i=0; $i<count($admin_companies->mCompanies); $i++) {
							echo'
								<tr>
									<td>'.$admin_companies->mCompanies[$i]['name'].'</td>
									<td>
										<button type="submit" name="submit_edit_comp_'.$admin_companies->mCompanies[$i]['company_id'].'" class="btn waves-effect waves-light teal white-text"><i class="far fa-edit"></i> Edit</button>
								
										<a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="#modal'.$i.'"><i class="fas fa-trash"></i> Delete</a>
										<div id="modal'.$i.'" class="modal">
											<div class="modal-content">
												<h4 class="center">DELETE!</h4>
												<p class="center">Are you sure you want to delete company: #'.$admin_companies->mCompanies[$i]['company_id'].'?</p>
											</div>
											<div class="modal-footer">
												<input type="submit" name="submit_delete_comp_'.$admin_companies->mCompanies[$i]['company_id'].'" class="center modal-close btn-flat waves-effect waves-light red" value="Delete">
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
			if (count($admin_companies->mCompaniesListPages) > 1) {
				echo '
				<div class="row">
					<div class="col s12 m12 l6 offset-l3">
					<p class="center">Page '.$admin_companies->mPagination.' of '.$admin_companies->mrTotalPages.'</p>
					<ul class="pagination center">';
						if (isset($admin_companies->mLinkToPreviousPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_companies->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
						}
						if (isset($admin_companies->mLinkToNextPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_companies->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-right"></i></a></li>';
						}
				echo '</ul>
					</div>
				</div>';
			}
		echo '
		<div class="section">
			<h5 class="center bebasFont teal-text text-darken-2">Add new Company</h5>
			<form class="col s12" method="post" action="'.$admin_companies->mLinkToCompaniesAdmin.'">
				<div class="container">
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<input type="text" name="name" id="companyName" class="validate" value="'.$admin_companies->mCompanyName.'">
							<label for="companyName">Company Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<input type="url" name="link" id="companyLink" class="validate" value="'.$admin_companies->mCompanyLink.'">
							<label for="companyLink">Link</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<input type="text" name="image" id="companyImage" class="validate" value="'.$admin_companies->mCompanyImage.'">
							<label for="companyImage">Company Image</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 l8 offset-l2">
							<textarea id="textarea1" class="materialize-textarea" name="description" class="validate">'.$admin_companies->mCompanyDescription.'</textarea>
							<label for="textarea1">Company Description</label>
						</div>
					</div>
					<div class="row">
						<p class="center"><button type="submit" name="submit_add_comp_0" class="btn waves-effect waves-light red lighten-2 center"><i class="fas fa-plus-square"></i> Add</button></p>
					</div>
				</div>
			</form>
		</div>
	';
}	
?>