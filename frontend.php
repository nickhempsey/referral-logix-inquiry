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
	$address = get_option('referrallogix_address');
	$dob = get_option('referrallogix_dob');
	$insurer = get_option('referrallogix_insurer');
	$payment = get_option('referrallogix_payment');
	$popup = get_option('referrallogix_popup');
	$popupText = get_option('referrallogix_popup_text');
	$popupImage = get_option('referrallogix_popup_image');
	$iconBg = get_option('referrallogix_icon_bg');
	$iconModel = get_option('referrallogix_icon_model');

	?>

	<?php
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
				'dob'=> $_REQUEST['dob'],
				'payment'=> $_REQUEST['payment'],
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
			// echo '<pre>start --------------></pre>';
			// echo var_dump($response);
			// echo '<pre>end --------------></pre>';
			// die;

			if(json_validate($response) != 'Invalid JSON.'){
				$apiResponseCode = json_decode($response)[0]->APISTATUS;
				$apiResponseMessage = 'Message submitted successfully.';
			} else {
				$apiResponseMessage = 'Unable to connect to server at this time.  Please try again later';
			}
			$apiResponse = '';
		}

		$inquiryStatus = $apiResponse == 'displayNone' ? 'closed' : 'open';

		?>
		<html>
			<head>
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
			</head>
			<body>
				<div class="rl-inquiry rl-inquiry-form <?= $apiResponse; ?>" data-status="<?= $inquiryStatus; ?>" style="background-color:<?= $bodyBg ?>!important">
					<div class="rl-inquiry-header" style="background-color: <?= $headerBg ?> !important; color:<?= $headerFont ?> !important">
						<img src="<?= $headerLogo; ?>" alt="Logo" class="orgLogo <?php echo ($headerTextPos != "left") ? 'displayNone':'';?>">
							<span class="headerText"><?= str_replace("\'","'",$headerText) ?></span>
						<img src="<?= $headerLogo; ?>" alt="Logo" class="orgLogo <?php echo ($headerTextPos != "right") ? 'displayNone':'';?>">
					</div>
					<div class="rl-inquiry-subHead" style="color: <?= $bodyFont ?>">Click Send after completing at least the first 3 fields below and one of our staff members will contact you shortly.</div>
					<div class="rl-inquiry-box">
						<form class="patientInquiryForm" action="" method="post">
							<div class="rl-inquiry-box-content">
								<input type="hidden" class="popup" value="<?= $popup; ?>" name="popup">
								<div class="formInputGroup">
									<input type="text" class="name" required="" name="first_name">
									<label class="formLabel">Name</label>
								</div>
								<div class="formInputGroup">
									<input type="text" class="phone phoneEmail" required="" name="phone">
									<label class="formLabel phoneEmailLabel">Mobile Phone (Faster Reponse)</label>
								</div>
								<div class="formInputGroup">
									<input type="text" class="email phoneEmail" required="" name="email">
									<label class="formLabel phoneEmailLabel">Email (Slower Response)</label>
								</div>
								<div class="formInputGroup">
									<textarea class="message" name="message"></textarea>
									<label class="formLabel">Message</label>
								</div>

								<?php if(($address == 2) || ($dob == 2) || ($insurer == 2) || ($payment == 2)) { ?>
									<div class="moreForm">
										<?php if($address == 2) { ?>
											<div class="formInputGroup">
												<textarea class="addressBox address" name="address" required=""></textarea>
												<label class="formLabel">Address</label>
											</div>
										<?php } ?>
										<?php if($dob == 2) { ?>
											<div class="formInputGroup">
												<input name="date" type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="dobBox dob">
												<label class="formLabel">Date Of Birth</label>
											</div>
										<?php } ?>

										<?php if($insurer == 2) { ?>
											<div class="formInputGroup">
												<input type="text" class="insurer insurerBox" name="insurer" required="">
												<label class="formLabel">Insurer</label>
											</div>
										<?php } ?>

										<?php if($payment == 2) { ?>
											<div class="formInputGroup">
												<label class="form-label">Please Select One:</label><br>
												<div class="form-check form-check-inline">
													<input class="form-check-input paymentBox" type="radio" name="payment" id="paymentPlan" value="self_pay" checked/>
													<label class="form-check-label" for="paymentPlan">
														Self Pay
													</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input paymentBox" type="radio" name="payment" id="paymentPlan1" value="health_plan"/>
													<label class="form-check-label" for="paymentPlan">
														Health Plan
													</label>
												</div>
											</div>
										<?php } ?>
									</div>
								<?php } ?>

								<div class="moreForm displayNone">
									<?php if($address == 1) { ?>
										<div class="formInputGroup">
											<textarea class="addressBox address optional" required="" name="address"></textarea>
											<label class="formLabel">Address</label>
										</div>
									<?php } ?>
									<?php if($dob == 1) { ?>
										<div class="formInputGroup">
											<input type="text" name="dob" class="dobBox dob optional" required="" onfocus="(this.type='date')" onfocusout="(this.type='text')">
											<label class="formLabel emailPhoneLabel">Date Of Birth</label>
										</div>
									<?php } ?>

									<?php if($insurer == 1) { ?>
										<div class="formInputGroup">
											<input type="text" class="insurer insurerBox optional" required="" name="insurer">
											<label class="formLabel">Insurer</label>
										</div>
									<?php } ?>

									<?php if($payment == 1) { ?>
										<div class="formInputGroup">
											<label class="form-label">Please Select One:</label><br>
											<div class="form-check form-check-inline">
												<input class="form-check-input paymentBox optional" type="radio" name="payment" id="paymentPlan" value="self_pay" checked>
												<label class="form-check-label" for="paymentPlan">
														Self Pay
													</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input paymentBox optional" type="radio" name="payment" id="paymentPlan" value="health_plan">
												<label class="form-check-label" for="paymentPlan">
														Health Plan
													</label>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>

							<?php if(($address == 1) || ($dob == 1) || ($insurer == 1) || ($payment == 1)) { ?>
								<div class="expandForm" style="color: <?= $bodyFont ?> !important;">
									Click <a href="" class="expandFormButton">here</a> to provide optional additional information that could help us help you quicker.
								</div>
							<?php } ?>

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
						<div class="footerTerms">Subject to <a href="https://www.referralogix.com/acceptable_use">Terms</a></div>
					</div>
				</div>
				<?= 
				var_dump($popupText);
				var_dump($popupImage);

				?>
				<div class="tooltip-head <?= (($popupText == "") && ($popupImage == "")) ? "displayNone" : "" ?>">
					<div class="tooltip-content clearfix bg-white rounded">
						<div class="tooltip-image <?= ($popupImage == "") ? "displayNone" : "" ?>">
							<img class="rounded-circle  " src="<?= $popupImage ?>" id="tooltip-image" alt="100x100">
						</div>
						<div class="tooltip-text <?= ($popupImage == "") ? "" : "tooltip-textPadding " ?><?= ($popupText == "") ? "displayNone" : "" ?>"><?= $popupText ?></div>
					</div>
					<div class="arrow-down"></div>
				</div>
				<div class="rl-inquiry-popup-opener" style="background-color: <?= $iconBg ?> !important;" data-status="<?= $inquiryStatus; ?>">
					<img src="<?= $root_path;?>/assets/images/<?= $iconModel?>" class="rl-inquiry-open logoImg" >

					<svg class="rl-inquiry-close" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="#ffffff" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path></svg>

				</div>
				<div class="loader displayNone"></div>
			</body>
		</html>
		<?php
	}
}