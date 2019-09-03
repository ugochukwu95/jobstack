<?php
	require_once PRESENTATION_DIR . 'user_terms.php';
	$user_terms = new UserTerms();

	echo '
	<div class="row">
		<div class="col s12 l12 grey-text text-darken-2 flow-text">
			<div class="card white">
    			<div class="card-content">
    			<h4>Important notice</h4>
    			<p class="">Please, read this carefully.</p>
    			<p class="">Our service is automated and unsupported. If you choose to use the service you agree to this End User Licence Agreement (EULA) and this <a href="'.$user_terms->mLinkToPrivacyPolicy.'" class="red-text text-lighten-2">privacy policy</a>.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>License</h4>
    			<p>This Software/Website is for personal use.</p>
    			<p>You are granted a non-exclusive, non-transferable license to use the website only in compliance with the end use license agreement.</p>
    			<p>This Software/Website may be used at no cost on unlimited number of computers</p>
    			<p>The vendor or developer reserves the right to discontinue and remove support at any point in time, at its sole discretion.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Copyright / Intellectual Property Rights (IPR)</h4>
    			<p>It\'s ours and always will be.</p>
    			<p>Title, copyright, intellectual property rights and distribution rights of this Software/Website remain exclusively with the vendor. Intellectual property rights include the name, look and feel of this Software/Website.</p>
    			<p>This agreement constitutes a license for use only and is not in any way a transfer of ownership rights of the software/system.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Warranty</h4>
    			<p>We do this out of the kindness of our hearts and for the fun of it.</p>
    			<p>As such the software/website and any related material are provided "as is" without warranty of any kind, either express or implied, including, without limitation, the implied warranties or merchantability, fitness for a particular purpose, or non infringement.</p>
    			<p>The entire risk arrising out of use of this software/website and its related materials remain with you.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Limitation of Liability</h4>
    			<p>We try to be helpful, but can\'t promise more.</p>
    			<p>You use this software/website entirely, without exception, at your own risk.</p>
    			<p>In no event will the vendor be liable for any special, incidental, indirect, or consiquential damages whatsoever (this includes without limitation, damages for loss of information, abuse, or any other pecuniary loss) arising out of the use or inability to use this software / website and its associated materials.</p>
    			<p>Under no circumstances shall the vendor be liable for any unauthorised use of the software.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Restrictions</h4>
    			<p>You may not remove any proprietary notices, labels or copyright signs.</p>
    			<p>You may not sell or pass on any costs in any shape or form, including but not limited to, support and/or distribution.</p>
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
    			<p>Please also see our <a href="'.$user_terms->mLinkToPrivacyPolicy.'" class="red-text text-lighten-2">privacy policy</a>.</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Fair use</h4>
    			<p>We monitor the use of our service to try to ensure fair and equitable use for everyone.</p>
    			<p>We reserve the right to block certain websites / users at our discretion and without reason</p>
    			<br>
    			<div class="divider"></div>
    			<br>
    			<h4>Donations</h4>
    			<p>We are greatful for any donations received as the help cover the cost of running the service.</p>
    			<p>All donations are optional and non-refundable.</p>
    			</div>
			</div>
		</div>
	</div>
	';
?>