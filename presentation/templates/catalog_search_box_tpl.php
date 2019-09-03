<?php
	require_once PRESENTATION_DIR . 'catalog_search_box.php';
	$catalog_search_box = new CatalogSearchBox();

	echo '
	<div class="section">
		<div class="row">
			<div class="col s12 l6 offset-l3">
				<div class="card grey-text text-darken-2 white">
					<div class="card-content">
						<span class="card-title center teal-text text-darken-2">Start your job search here</span>
						<div class="row">
							<form class="col s12" method="post" action="'.$catalog_search_box->mLinkToSearch.'">
								<div class="row">
									<div class="input-field col s12">
									    <!-- <i class="material-icons prefix">search</i>-->
										<input placeholder="ie: Accountant or Accountant in Lagos" type="text" name="search_string" id="search_string" value="'.$catalog_search_box->mSearchString.'" class="position_autocomplete">
										<label for="search_string">Search</label>
									</div>
								</div>
								<p>
									<label>
									<input type="checkbox" name="all_words" ';
									if ($catalog_search_box->mAllWords == 'on') {
										echo 'checked="checked"';
									}
									echo ' style="border:1px solid grey;">
									<span class="grey-text text-darken-2">all words search (more accurate)</span>
									</label>
								</p><br>
								<p>
								    <label>
							        <input name="company_search" type="checkbox" ';
							        if ($catalog_search_box->mCompanySearch == 'on') {
							            echo 'checked="checked"';
							        }
							        echo ' style="border:1px solid grey;">
                                    <span class="grey-text text-darken-2"><i class="far fa-building"></i> search companies</span>
								    </label>
								</p><br>
								<p><button type="submit" class="red lighten-2 waves-effect waves-light btn white-text" name="submit" value="Search">Search</button></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
        var positions = JSON.parse(JSON.stringify('.$catalog_search_box->mPositions.')), position_data = {}, x;
		for (x in positions) {
			if (positions.hasOwnProperty(x)) {
				position_data[positions[x]] = null;
			}
		}
		$("input.position_autocomplete").autocomplete({
			data: position_data
		});
	</script>
	';
?>