<?php
	echo '
	<div class="row">
		<div class="col s12 l10 offset-l1">
				<div class="row">
					<div class="col s12">
						<h5 class="grey-text text-darken-2"><span class="teal-text">About</span> '.$user_profile->mCustomer['handle'].'</h5>
						<div class="divider"></div>';
						if (empty($user_profile->mCustomer['about_you'])) {
							echo '
							<p class="grey-text text-darken-2">'.$user_profile->mCustomer['handle'].' has not added any additional information to their account.</p>
							';
						}
						else {
							echo '
							<p class="grey-text text-darken-2" style="white-space:pre-line;">'.$user_profile->mCustomer['about_you'].'</p>
							';
						}
					echo '
					</div>
				</div>
				<div class="divider"></div>
				<ul class="collection">
					<li class="collection-item avatar">
						<i class="fas fa-home circle teal tooltipped" data-position="right" data-tooltip="Hometown"></i>';
						if (empty($user_profile->mCustomer['hometown'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['hometown'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-envelope circle teal tooltipped" data-position="right" data-tooltip="Email"></i>';
						if (empty($user_profile->mCustomer['email'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['email'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-cogs circle teal tooltipped" data-position="right" data-tooltip="Occupation"></i>';
						if (empty($user_profile->mCustomer['occupation'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['occupation'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-university circle teal tooltipped" data-position="right" data-tooltip="Highest Institution Attended"></i>';
						if (empty($user_profile->mCustomer['university'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['university'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-paint-brush circle teal tooltipped" data-position="right" data-tooltip="Skills"></i>';
						if (!empty($user_profile->mCustomerSkills)) {
							for ($i=0; $i<count($user_profile->mCustomerSkills); $i++) {
								echo '
								<div class="chip" id="skillChip">
									<span>'.$user_profile->mCustomerSkills[$i]['skill'].'</span>
								</div>
							';
							}
							echo '
							<br>
							<a href="#!" class="red-text text-lighten-2 hide moreChips">more...</a>
							<script>
								var maxChips = 5;
								if (document.querySelectorAll("#skillChip").length > 5) {
									$(".moreChips").removeClass("hide").addClass("show");
									var hiddenChips = (document.querySelectorAll("#skillChip").length - 5);
									var i;
									for (i=0; i<hiddenChips; i++) {
										document.querySelectorAll("#skillChip")[i+5].classList.add("hide");
									}
								}
								$(".moreChips").click(function(event) {
									event.preventDefault();
									var hiddenChips = (document.querySelectorAll("#skillChip").length - 5);
									$(".chip").removeClass("hide").addClass("show");
									$(".moreChips").removeClass("show").addClass("hide");
								})
							</script>';
						}
						else { 
							echo 'Nothing to show ...';
						}
					echo '
					</li>
				</ul>
			</div>
		</div>';
?>