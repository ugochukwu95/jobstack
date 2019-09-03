<?php
	require_once PRESENTATION_DIR . 'contact_developer.php';
	$contact_developer = new ContactDeveloper();
	$contact_developer->init();
	echo '
		<div class="row row_first" style="display:none">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					
					First Name field cannot be empty.
				</div>
			</div>
		</div>
	';
	echo '
		<div class="row row_last" style="display:none">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					
					Last Name field cannot be empty.
				</div>
			</div>
		</div>
	';
	echo '
		<div class="row  row_email" style="display:none">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					
					Email field cannot be empty.
				</div>
			</div>
		</div>
	';
	echo '
		<div class="row  row_message" style="display:none">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					
					Message field cannot be empty.
				</div>
			</div>
		</div>
	';

	echo '
	<br>
	<div class="row">
    	<div class="col s12">
    	    <div class="card white">
    	        <div class="card-content">
                	<div class="row">
                		<form class="col s12 l10 offset-l1">
                			<div class="row">
                				<div class="input-field col s6">
                					<input id="first_name" name="FirstName" type="text">
                					<label for="first_name">First Name</label>
                					<span class="helper-text">important</span>
                				</div>
                				<div class="input-field col s6">
                					<input id="last_name" name="LastName" type="text">
                					<label for="last_name">Last Name</label>
                					<span class="helper-text">important</span>
                				</div>
                			</div>
                			<div class="row">
                				<div class="input-field col s6">
                					<input id="email" name="Email" type="email" class="validate">
                					<label for="email">Email</label>
                					<span class="helper-text">important</span>
                				</div>
                				<div class="input-field col s6">
                					<input id="phone_number" name="PhoneNumber" type="text">
                					<label for="phone_number">Phone Number</label>
                				</div>
                			</div>
                			<div class="row">
                				<div class="input-field col s12">
                					<textarea id="message" class="materialize-textarea"></textarea>
                					<label for="message">Message</label>
                					<span class="helper-text">important</span>
                				</div>
                			</div>
                			<input type="text" id="contact_website" name="website">
                			<a class="btn red lighten-2 white-text submit_contact_button" href="#!">Submit</a>
                		</form>
                	</div>
            	</div>
    	    </div>
    	</div>
	</div>
	<br>
	<div class="divider"></div>
	<br>
	<div class="row">
	    <div class="col s12 l10 offset-l1">
        	<p>Oguejiofor Ugochukwu (Ugo)<br> 
        	Nigeria<br><br>
        	+234 (0) 8108119679</p>
        </div>
    </div>

	<script>
		$(document).ready(function() {
			$("form").on("click", ".submit_contact_button", function(event) {
				event.preventDefault();
				if ($("#first_name").val() == "") {
					$(".row_first").show();
					return;
				}
				if ($("#last_name").val() == "") {
					$(".row_last").show();
					return;
				}
				if ($("#email").val() == "") {
					$(".row_email").show();
					return;
				}
				if ($("#message").val() == "") {
					$(".row_message").show();
					return;
				}
				if ($("#contact_website").val() != "") {
					return;
				}

				var contact_first_name = $("#first_name").val().replace(/<[^>]*>?/gm);
				var contact_last_name = $("#last_name").val().replace(/<[^>]*>?/gm);
				var contact_message = $("#message").val().replace(/<[^>]*>?/gm);
				var contact_email = $("#email").val().replace(/<[^>]*>?/gm);
				var contact_phone_number = $("#phone_number").val().replace(/<[^>]*>?/gm);

				$.post(
					"'.$contact_developer->mLinkToContactDeveloper.'",
					{SubmitContact: "", FirstName: contact_first_name, LastName: contact_last_name, Message: contact_message, Email: contact_email, 
						PhoneNumber: contact_phone_number},
					function(data) {
						$(".row_first").hide();
						$(".row_message").hide();
						$(".row_email").hide();
						$(".row_last").hide();
						$("form").closest("form").find("input, textarea").val("");
						M.toast({html: "Sent successfully"});
					}
				);

			});
		});
	</script>
	';
?>