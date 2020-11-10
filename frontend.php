<?php
	
add_action('wp_footer', 'referrallogix_frontend_inquiry_form');
function referrallogix_frontend_inquiry_form() {
	$headerBg = get_option('referrallogix_header_bg');
	$headerFont = get_option('referrallogix_header_font');
	$bodyBg = get_option('referrallogix_body_bg');
	$bodyFont = get_option('referrallogix_body_font');
	$buttonBg = get_option('referrallogix_button_bg');
	$buttonFont = get_option('referrallogix_button_font');
	$apiKey = get_option('referrallogix_api_key');
	$qsiKey = get_option('referrallogix_qsi_key');
	$headerText = get_option('referrallogix_header_text');
	$headerTextPos = get_option('referrallogix_header_text_pos');
	$headerLogo = get_option('referrallogix_header_logo');
	if(!is_bool($apiKey)) {
		$post = [
			'QSI' => $qsiKey,
		];

		$root_path = plugin_dir_url( __FILE__ );
		$apiResponse = 'displayNone';    
		$apiResponseMessage = '';
		$apiResponseFlag = false;
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$post = [
				'QSI' => $qsiKey,
				'name' => $_REQUEST['first_name'],
				'phone'=> $_REQUEST['phone'],
				'message'=> $_REQUEST['message'],
				'insurer'=> $_REQUEST['insurer'],
				'email'=> $_REQUEST['email'],
				'address1'=> $_REQUEST['address'],
			];
	
			$ch = curl_init('https://app.referralogix.net/api/events/index.cfm?endpoint=/newInquiry/0&');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"X-TICKET: $apiKey",
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			$response = curl_exec($ch);
			curl_close($ch);
	
			$apiResponseFlag = true;
			
			// Testing response
			//echo '<pre>'.print_r($response, true).'</pre>';
	
			if(json_validate($response) != 'Invalid JSON.'){
				$apiResponseMessage = json_decode($response)[0]->MESSAGE;
			} else {
				$apiResponseMessage = 'Unable to connect to server at this time.  Please try again later';
			}
			$apiResponse = '';
		}
		
		
		$inquiryStatus = $apiResponse == 'displayNone' ? 'closed' : 'open';
	
		?>
		<div class="rl-inquiry rl-inquiry-form <?= $apiResponse; ?>" data-status="<?= $inquiryStatus; ?>" style="background-color:<?= $bodyBg ?>!important">
			<div class="rl-inquiry-header" style="background-color: <?= $headerBg ?> !important; color:<?= $headerFont ?> !important">
				<img src="<?= $headerLogo; ?>" alt="Logo" class="orgLogo <?php echo ($headerTextPos != "left") ? 'displayNone':'';?>">
					<span><?= str_replace("\'","'",$headerText) ?></span>
				<img src="<?= $headerLogo; ?>" alt="Logo" class="orgLogo <?php echo ($headerTextPos != "right") ? 'displayNone':'';?>">
			</div>
			<div class="rl-inquiry-subHead" style="color: <?= $bodyFont ?>">Click Send after completing at least the first 3 fields below and one of our staff members will contact you shortly.</div>
			<div class="rl-inquiry-box">
				<form class="patientInquiryForm" action="" method="post">
					<div class="formInputGroup">
						<input type="text" class="name" required="" name="first_name">
						<label class="formLabel">Name</label>
					</div>
					<div class="formInputGroup">
						<input type="text" class="phoneEmail" required="" name="phone_mail">
						<label class="formLabel phoneEmailLabel">Mobile Phone or Email (slower response)</label>
					</div>
					<div class="formInputGroup">
						<textarea class="message" name="message"></textarea>
						<label class="formLabel">Message</label>
					</div>
					<div class="moreForm displayNone">
						<div class="formInputGroup">
							<textarea class="addressBox" required="" name="address"></textarea>
							<label class="formLabel">Address</label>
						</div>
						<div class="formInputGroup">
							<input type="text" class="emailPhone" required="" name="email">
							<label class="formLabel emailPhoneLabel">Email</label>
						</div>
						<div class="formInputGroup">
							<input type="text" class="insurer" required="" name="insurer">
							<label class="formLabel">Insurer</label>
						</div>
					</div>
					<div class="expandForm" style="color: <?= $bodyFont ?> !important;">
						Click <a href="" class="expandFormButton">here</a> to provide optional additional information that could help us help you quicker.
					</div>
					<button type="button" class="rl-inquiry-submit" style="background-color: <?= $buttonBg ?> !important;color: <?= $buttonFont ?> !important">SEND</button>
				</form>
			</div>
			<div class="alertMsg <?= $apiResponse;?>">
				<div class="alertText"><?= $apiResponseMessage;?></div>
				<button type="button" class="rl-inquiry-closeAlert">OK</button>
			</div>
			<div class="rl-inquiry-subFooter" style="color: <?= $bodyFont ?>">
				By clicking the SEND button, you agree to receive text messages at the mobile phone number provided for the purpose of this dialog. Depending upon your mobile service, messages/data rates may apply
			</div>
			<div class="rl-inquiry-footer">
				<img src="<?= $root_path;?>/assets/images/rlogix.png" class="footerImage">
				<div class="footerText">v2.0 (c) 2020</div>
			</div>
		</div>
		<div class="rl-inquiry-popup-opener" data-status="<?= $inquiryStatus; ?>">

			<svg class="rl-inquiry-open" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="#ffffff" d="M192 416c0 17.7-14.3 32-32 32s-32-14.3-32-32 14.3-32 32-32 32 14.3 32 32zM320 48v416c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h224c26.5 0 48 21.5 48 48zm-32 0c0-8.8-7.2-16-16-16H48c-8.8 0-16 7.2-16 16v416c0 8.8 7.2 16 16 16h224c8.8 0 16-7.2 16-16V48z"></path></svg>

			<svg class="rl-inquiry-close" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="#ffffff" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path></svg>

		</div>
	
		<?php
	}
}