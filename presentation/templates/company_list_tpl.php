<?php
	require_once PRESENTATION_DIR . 'company_list.php';
	$company_list = new CompanyList();
	$company_list->init();
	
	if ($company_list->mSearchDescription != '') {
		echo '
		<div class="row">
			<div class="col s12">
				<h1 class="center">:-(</h1>
				<p class="center grey-text text-darken-2">'.$company_list->mSearchDescription.'</p>
				<p class="grey-text text-darken-2 center">Oops! Change the wording of your search query or try browsing our <a href="'.$company_list->mLinkToCompanies.'" class="red-text">Company Catalog.</a></p>
			</div>
		</div>
		';
	}

	if ($company_list->mCompanies) {
		if ($company_list->mrTotalPages > 1) {
			echo '
			<div class="row">
				<div class="col s12">
					<p class="center">viewing <span class="teal-text"><b>'.$company_list->mPage.'</b></span> of '.$company_list->mrTotalPages.' pages.</p>
				</div>
			</div>
			';
		}
		$companies_list_count = count($company_list->mCompanies);
		echo '<div class="flex-container">';
		for ($i=0; $i<count($company_list->mCompanies); $i++) {
			echo '
			<div class="flex-item">
				<div class="card hoverable">
					<div class="card-image waves-effect waves-block waves-light center" style="text-align:center;">
						<br><br><br>
						<div class="container activator">
						    <div class="row activator">
						        <div class="col s6 offset-s3 activator">
						            <img class="activator center" src="'.$company_list->mCompanies[$i]['image'].'" style="width:50%;margin-left:auto;margin-right:auto;margin-top:30px;display:block">
						        </div>
						    </div>
						</div>
					</div>
					<div class="card-content" style="margin-top:20px;">
					 	<span class="card-title activator grey-text text-darken-4"><b class="activator">'.$company_list->mCompanies[$i]['name'].'</b></span>
						
					</div>
					<div class="card-reveal">
						<span class="card-title grey-text text-darken-4">'.$company_list->mCompanies[$i]['name'].'</span>
						<p>'.$company_list->mCompanies[$i]['company_description'].'</p>
						<p><a href="'.$company_list->mCompanies[$i]['link_to_company'].'" class="red lighten-2 white-text btn-flat">MORE</a></p>
						
					</div>
					<div class="card-action">
						<p><a href="'.$company_list->mCompanies[$i]['link_to_company'].'" class="red lighten-2 white-text btn-flat">MORE</a></p>
					</div>
				</div>
			</div>
			';
		}
		echo '</div>';
		if (count($company_list->mCompanyListPages) > 1) {
			echo '
			<div class="row">
				<div class="col s12">
					<ul class="pagination black-text center">';
						for ($m = 0; $m < count($company_list->mCompanyListPages); $m++) {
							if ($company_list->mPage == ($m+1)) {
								echo '<li class="waves-effect active red lighten-2"><a href="'.$company_list->mCompanyListPages[$m].'"><small>'.($m+1).'</small></a></li>';
							}
							else {
								echo '<li class="waves-effect"><a href="'.$company_list->mCompanyListPages[$m].'"><small>'.($m+1).'</small></a></li>';
							}
						}
						echo '
					</ul>
				</div>
			</div>';
		}
	}
?>