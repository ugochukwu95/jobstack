<?php
	require_once PRESENTATION_DIR . 'privacy_policy.php';
	$privacy_policy = new PrivacyPolicy();
	echo '
	<div class="row">
		<div class="col s12 l12 grey-text text-darken-2 flow-text">
		    <div class="card white">
    		    <div class="card-content">
    			<p>When you use our service you are indicating your agreement to the privacy policy.</p>
    			<p>Our service is automated and unsupported. If you choose the service you agree to the <a href="'.$privacy_policy->mLinkToUserTerms.'" class="red-text text-lighten-2">End Use Licence Agreement (EULA)</a> and this privacy policy.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>How we use your data</h4>
    			<p>We use information about you in the folloeing ways:</p>
    			<ul>
    				<li>Help fulfill your request when using our online service.</li>
    				<li>Notify you as your request passes through our system.</li>
    				<li>Enable us to review and improve our website, application and services</li>
    				<li>Provide customer support where applicable</li>
    				<li>Carry out analysis or where we seek your thoughts and opinions on the services we provide.</li>
    				<li>Notify you about changes to our website, terms and conditions, services or prices.</li>
    			</ul>
    			<p>Where possible we will anonymise or pseudonymise your data so that it can no longer be associated with you (such as for statistical analysis), in which case we can use it without further notice to you.</p>
    			<p>At our discretion, we reserve the right to publish your post to out trending chatter page or featured page if it is of particular interest to us.</p>
    			<p>If you contact us we may also hold personal data about you although in general we do not provide support for direct contact other than through public social media channels.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Access to your personal data</h4>
    			<p>We do not sell or pass on your details to 3rd parties for marketing or sales purposes.</p>
    			<p>As the service develops we may transfer ownership of the service to trusted 3rd party. At this time it may be necessary to pass details to the 3rd party to enable them to carry on running the service.</p>
    			<p>We primarily use Qservers for hosting the service.</p>
    			<p>Web server locations can vary depending on where you are using the service from and your website location</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Cookies and your personal privacy</h4>
    			<p>Cookies are small files placed on your computer which enable websites to store bits of information.</p>
    			<p>We do not use cookies to store personal information.</p>
    			<p>In order to bring you this service we use cookies to:</p>
    			<ul>
    				<li>Maintain your user session and login.</li>
    				<li>Track basic usage statistics for our website, using third parties such as google.</li>
    				<li>Display adverts using third parties such as google</li>
    				<li>Interact with third party services such as facebook and YouTube.</li>
    			</ul>
    			<p>Our cookies are anonymous and do not include personal details.</p>
    			<p>Whilst every effort is made to ensure we only deal with reputable services from the likes of Google, Facebook, YouTube, PayPal, etc. we do not accept any liability for their actions.</p>
    			<p>By using this website you agree to accept these cookies. You may also block them through your web browser, however this may limit your ability to use our services.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>External website links</h4>
    			<p>Within our website we provide links to external website for further information. We do not endorse or control these websites they are simply supplied "as is" for further reading. We would recommend you review the terms of service and privacy statements of these websites.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Website security</h4>
    			<p>This a small community website with limited resources, however we have taken reasonable measures in this context to prevent unauthorised access to your data.</p>
    			<p>We use HTTPS / SSL to encrypt traffic between you and our website.</p>
    			<p>We use Qservers to provide reliable and secure hosting.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Your rights</h4>
    			<p>Under data protection law you have various rights.</p>
    			</div>
			</div>
		</div>
	</div>
	';
?>