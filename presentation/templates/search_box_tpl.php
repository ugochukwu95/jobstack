<?php
	require_once PRESENTATION_DIR . 'search_box.php';
	$search_box = new SearchBox();

	echo '
	<div class="container section">
		<div class="row">
			<div class="col s12 l6 offset-l3">
				<div class="card white black-text">
					<div class="card-content">
						<div class="row">
							<form class="col s12" method="post" action="'.$search_box->mLinkToSearch.'">
								<div class="row">
									<div class="input=field col s12">
										<input type="text" name="search_string" id="search_string" value="'.$search_box->mSearchString.'">
										<label for="search_string">Search</label>
									</div>
								</div>
								<p>
									<label>
									<input type="checkbox" name="all_words" ';
									if ($search_box->mAllWords == 'on') {
										echo 'checked="checked"';
									}
									echo '
									>
									<span>Search for all words</span>
									</label>
								</p><br>
								<p>
									<label>
										<input type="checkbox" name="company_search" ';
										if ($search_box->mCompanySearch == 'on') {
											echo 'checked="checked"';
										}
										echo '>
										<span> Search Company Database only</span>
									</label>
								</p><br>
								<p>
									<label>
										<input type="checkbox" name="user_search" ';
										if ($search_box->mUserSearch == 'on') {
											echo 'checked="checked"';
										}
										echo '>
										<span> Search Customer Database only</span>
									</label>
								</p><br>
								<p><input type="submit" class="waves-effect waves-light btn" name="submit" value="Search" /></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	'; 
?>