<?php
	require_once PRESENTATION_DIR . 'customer_details.php';
	$customer_details = new CustomerDetails();
	$customer_details->init();
	echo '
	<div class="row">
		<div class="row">
			<div class="col s12">
				<h4 class="bebasFont teal-text center">Edit Profile</h4>';
				if (!is_null($customer_details->mErrorMessage)) {
					echo '
					<div class="row">
						<div class="col s12 m12 l8 offset-l2">
							<div class="alertBox">
								<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
								'.$customer_details->mErrorMessage.'
							</div>
						</div>
					<div>';
				}
			echo '
			</div>
		</div>
		<form class="col s12" enctype="multipart/form-data" method="post" action="'.$customer_details->mLinkToEditProfile.'">
		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s6 m6 l6"><a href="#profile">Profile</a></li> 
					<li class="tab col s6 m6 l6"><a href="#account">Account</a></li>
				</ul>
			</div>
			<div id="profile" class="col s12">
				<br><br>
				<div class="row">
					<div class="col s12">';
						if (empty($customer_details->mAvatar)) {
							echo '
							<div class="center" style="text-align:center;">
								<div class="teal" style="display:inline-block;width:150px;line-height:100px;text-align:center;border-radius:8px;">
									<span class="white-text" style="font-size:100px;">'.substr($customer_details->mHandle, 0, 1).'</span>
								</div>
							</div>';
						}
						else {
							echo '
							<div class="center" style="text-align:center;">
								<div class="center" style="display:inline-block;width:150px;line-height:100px;text-align:center;">
									<img src="'.$customer_details->mSiteUrl.'images/profile_pictures/'.$customer_details->mAvatar.'" border="0" alt="profile picture" style="width:150px;line-height:100px;border-radius:8px;" />
								</div>
							</div>
							';
						}
					echo '
					</div>
				</div>
				<div class="row">
					<div class="file-field input-field col s12">
						<div class="btn">
							<span>Avatar Upload</span>
							<input type="file" name="avatarUpload" value="'.$customer_details->mAvatar.'">
							<span class="helper-text red-text text-darken-4">Must be less than 5MB.</span>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: Maitama, Abuja" id="Hometown" type="text" class="validate" name="hometown" value="'.$customer_details->mHometown.'">
						<label for="Hometown"><b>Hometown</b></label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: Engineer" id="occupation" type="text" class="validate" name="occupation" value="'.$customer_details->mOccupation.'">
						<label for="occupation"><b>Occupation</b></label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<p><b>Add Skills</b></p>
						<p class="skills_chips">';
						if (!empty($customer_details->mCustomerSkills)) {
							for ($i=0; $i<count($customer_details->mCustomerSkills); $i++) {
								echo '
								<div class="chip chip'.$i.'">
									'.$customer_details->mCustomerSkills[$i]['skill'].'&nbsp;&nbsp;
									<i class="fas fa-window-close close'.$i.'"></i>
								</div>
								<script>
									$(document).ready(function() {
										$(".chip'.$i.'").on("click", ".close'.$i.'", function(event){
											$.post("'.$customer_details->mSiteUrl.'edit-profile",
											{RemoveSkillId: '.$customer_details->mCustomerSkills[$i]['skills_id'].'},
											function(data) {
												$(".chip'.$i.'").remove();
											})
										});
									});
								</script>
								';
							}
						}
						echo '
						</p>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6 m6 l6">
						<input placeholder="ie: public speaking" id="skills" type="text" name="skills">
						<label for="skills">Skills</label>
					</div>
					<div class="input-field col s1 m1 l1" id="save_skill_functionality">
						<a href="#!" class="btn-floating red lighten-2 suffix" id="save_skill"><i class="fas fa-plus"></i></a>
					</div>
				</div>
			<script>
				$(document).ready(function() {
					$("#save_skill_functionality").on("click", "#save_skill", function(event){
						event.preventDefault();
						if ($("#skills").val() == "") {
							return;
						}
						var customer_skill = $("#skills").val();
						$.post("'.$customer_details->mSiteUrl.'edit-profile",
						{Skills: customer_skill},
						function(data) {
							$(".skills_chips").append("<span class=\"chip\">" + customer_skill + "</span>");
							$("#skills").val("");
						})
					});
				});
			</script>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: Federal University Of Technology Owerri" id="university" type="text" class="validate" name="university" value="'.$customer_details->mUniversity.'">
						<label for="university"><b>Highest Institution Attended</b></label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<textarea id="about_you" name="about_you" placeholder="Tell our community about yourself" class="materialize-textarea">'.$customer_details->mAboutYou.'</textarea>
						<label for="about_you"><b>About You</b></label>
					</div>
				</div>
			</div>
			<div id="account" class="col s12">
			<br><br>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: @King_Ugo" id="handle" type="text" class="validate" name="handle" value="'.$customer_details->mHandle.'">
						<label for="handle">Unique Handle</label>';
						if ($customer_details->mHandleAlreadyTaken == 1) {
							echo '<span class="helper-text red-text text-darken-4">A user with that unique handle already exists</span>';
						}
					echo '
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: John Doe" id="full_name" type="text" class="validate" name="full_name" value="'.$customer_details->mFullName.'">
						<label for="full_name">Real Name</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input placeholder="ie: johndoe@exaample.com" id="email" type="email" class="validate" name="email" value="'.$customer_details->mEmail.'">
						<label for="email">Email Address</label>';
						if ($customer_details->mEmailAlreadyTaken == 1) {
							echo '<span class="helper-text red-text text-darken-4">A user with that e-mail address already exists</span>';
						}
					echo '
					</div>
				</div>
			</div>
		</div>
			<p class="center">
				<button type="submit" name="sended" value="SAVE" class="red lighten-2 white-text btn-large waves-effect waves-light">SAVE</button>
			</p>
		</form>
	</div>
	';
?>