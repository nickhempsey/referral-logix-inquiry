<?php

add_action( 'admin_menu', 'referrallogix_inquiry_add_settings_page' );
function referrallogix_inquiry_add_settings_page() {
	add_options_page( 'inquiry', 'Referralogix Inquiry', 'manage_options', "referrallogix-inquiry", 'referrallogix_inquiry_plugin_settings_page' );
}

function referrallogix_inquiry_plugin_settings_page() {
   $default_qsi = $default_api = "";
   $default_method = "EDIT";
   $requestMethod = 0;
   $apiKey = get_option('referrallogix_api_key');
   $qsiKey = get_option('referrallogix_qsi_key');
   $headerBg = get_option('referrallogix_header_bg');
   $headerFont = get_option('referrallogix_header_font');
   $bodyBg = get_option('referrallogix_body_bg');
   $bodyFont = get_option('referrallogix_body_font');
   $buttonBg = get_option('referrallogix_button_bg');
   $buttonFont = get_option('referrallogix_button_font');
   $headerText = get_option('referrallogix_header_text');
   $headerTextPos = get_option('referrallogix_header_text_pos');
   $headerLogo = get_option('referrallogix_header_logo');
   $address = get_option('referrallogix_address');
   $insurer = get_option('referrallogix_insurer');
   $dob = get_option('referrallogix_dob');
   $payment = get_option('referrallogix_payment');
   $popup = get_option('referrallogix_popup');
   $popupText = get_option('referrallogix_popup_text');
   $popupImage = get_option('referrallogix_popup_image');
   $root_path = plugin_dir_url( __FILE__ );
   
   if(is_bool($headerBg)){
	   add_option('referrallogix_header_bg','#6b95de');
	   $headerBg = '#6b95de';
	}
	if(is_bool($headerFont)){
		add_option('referrallogix_header_font','#000000');
		$headerFont = '#000000';
	}
	if(is_bool($bodyBg)){
		add_option('referrallogix_body_bg','#e7eefa');
		$bodyBg = '#e7eefa';
	}
	if(is_bool($bodyFont)){
		add_option('referrallogix_body_font','#000000');
		$bodyFont = '#000000';
	}
	if(is_bool($buttonBg)){
		add_option('referrallogix_button_bg','#337ab7');
		$buttonBg = '#337ab7';
	}
	if(is_bool($buttonFont)){
		add_option('referrallogix_button_font','#ffffff');
		$buttonFont = '#ffffff';
	}
	if(is_bool($headerText)){
	   add_option('referrallogix_header_text',"Lets start a text conversation");
	   $headerText = "Lets start a text conversation";
	}
	if(is_bool($headerTextPos)){
	   add_option('referrallogix_header_text_pos',"none");
	   $headerTextPos = "none";
	}

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST['update']) && trim($_POST['update']) != 1) {
			$requestMethod = 1;
			$default_method = "UPDATE";
		}
		if(!empty($_POST['site_qsi']) && !empty($_POST['api_key'])) {
			if(isset($_POST['insert'])) {
				add_option('referrallogix_qsi_key',trim($_POST['site_qsi']));
				add_option('referrallogix_api_key',trim($_POST['api_key']));
				add_option('referrallogix_address',trim($_POST['Address']));
				add_option('referrallogix_insurer',trim($_POST['Insurer']));
				add_option('referrallogix_dob',trim($_POST['dob']));
				add_option('referrallogix_payment',trim($_POST['payment']));
				add_option('referrallogix_popup',trim($_POST['popup_fade']));
				add_option('referrallogix_popup_text',trim($_POST['popup_text']));
				add_option('referrallogix_popup_image',trim($_POST['popup_image']));
				
			} else {
				update_option('referrallogix_qsi_key',trim($_POST['site_qsi']));
				update_option('referrallogix_api_key',trim($_POST['api_key']));
				update_option('referrallogix_header_bg',trim($_POST['headerBg']));
				update_option('referrallogix_header_font',trim($_POST['headerFont']));
				update_option('referrallogix_body_bg',trim($_POST['bodyBg']));
				update_option('referrallogix_body_font',trim($_POST['bodyFont']));
				update_option('referrallogix_button_bg',trim($_POST['buttonBg']));
				update_option('referrallogix_button_font',trim($_POST['buttonText']));
				update_option('referrallogix_header_text',trim($_POST['headerText']));
				update_option('referrallogix_header_text_pos',trim($_POST['logoPos']));
				update_option('referrallogix_header_logo',trim($_POST['logoUrl']));
				update_option('referrallogix_address',trim($_POST['Address']));
				update_option('referrallogix_insurer',trim($_POST['Insurer']));
				update_option('referrallogix_dob',trim($_POST['dob']));
				update_option('referrallogix_payment',trim($_POST['payment']));
				update_option('referrallogix_popup',trim($_POST['popup_fade']));
				update_option('referrallogix_popup_text',trim($_POST['popup_text']));
				update_option('referrallogix_popup_image',trim($_POST['popup_image']));
			}
			$apiKey = get_option('referrallogix_api_key');
			$qsiKey = get_option('referrallogix_qsi_key');
			$headerBg = get_option('referrallogix_header_bg');
			$headerFont = get_option('referrallogix_header_font');
			$bodyBg = get_option('referrallogix_body_bg');
			$bodyFont = get_option('referrallogix_body_font');
			$buttonBg = get_option('referrallogix_button_bg');
			$buttonFont = get_option('referrallogix_button_font');
			$headerText = get_option('referrallogix_header_text');
			$headerTextPos = get_option('referrallogix_header_text_pos');
			$headerLogo = get_option('referrallogix_header_logo');
			$address = get_option('referrallogix_address');
			$insurer = get_option('referrallogix_insurer');
			$dob = get_option('referrallogix_dob');
			$payment = get_option('referrallogix_payment');
			$popup = get_option('referrallogix_popup');
			$popupText = get_option('referrallogix_popup_text');
			$popupImage = get_option('referrallogix_popup_image');
		}
	}
?>

	<form class="form-table" action="" method="post" id="referrallogixInquiry">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<td colspan="2">
						<h3 class="sendgrid-settings-top-header">Referralogix Inquiry Settings</h3>
					</td>
				</tr>
				<tr valign="top" class="qsi-key">
					<td scope="row">Site QSI</td>
					<td>
						<input type="text" class="regular-text" id="site_qsi" placeholder="Enter your QSI" name="site_qsi" value="<?= $qsiKey; ?>" maxlength="4">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">API Key</td>
					<td>
						<input type="password" class="regular-text" id="api_key" placeholder="Enter your api key" name="api_key" value="<?= $apiKey; ?>" maxlength="36">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Popup Text</td>
					<td>
						<input type="Text" class="regular-text" id="popup_text" placeholder="Enter the text for popup" name="popup_text" value="<?= $popupText; ?>" maxlength="200">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Popup Image</td>
					<td>
						<input type="Text" class="regular-text popup_image" id="popup_img" placeholder="To include an image in the popup, enter image URL" name="popup_image" value="<?= $popupImage; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Popup Fades After</td>
					<td>
						<input type="number" class="regular-text" id="popup_fade" name="popup_fade" value="<?= ($popup == "") ? 0 : $popup ?>"; style="width:80px;text-align:right">&nbsp;Seconds (0 = Does not fade)
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Include Logo in Header</td>
					<td>
						<input type="radio" id="noLogo" name="logoPos" value="none" <?php echo ($headerTextPos=="none") ? 'checked="checked"':'';?>>
						<label for="male">None</label><br>
						<input type="radio" id="leftLogo" name="logoPos" value="left" <?php echo ($headerTextPos=="left") ? 'checked="checked"':'';?>>
						<label for="male">Left-Side</label><br>
						<input type="radio" id="rightLogo" name="logoPos" value="right" <?php echo ($headerTextPos=="right") ? 'checked="checked"':'';?>>
						<label for="male">Right-Side</label><br>
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Logo URL</td>
					<td>
						<input type="text" class="regular-text" id="headerLogo" placeholder="Enter an URL for logo" name="logoUrl" value="<?= $headerLogo; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Header Text</td>
					<td>
						<input type="text" class="regular-text" id="headerText" placeholder="Enter a header text for the plugin" name="headerText" value="<?= str_replace("\'","'",$headerText); ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Header Background Color</td>
					<td>
						<input type="color" id="headerBg" name="headerBg" value="<?= $headerBg; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Header Text Color</td>
					<td>
						<input type="color" id="headerFont" name="headerFont" value="<?= $headerFont; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Body Background Color</td>
					<td>
						<input type="color" id="bodyBg" name="bodyBg" value="<?= $bodyBg; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Body Text Color</td>
					<td>
						<input type="color" id="bodyFont" name="bodyFont" value="<?= $bodyFont; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Button Color</td>
					<td>
						<input type="color" id="buttonBg" name="buttonBg" value="<?= $buttonBg; ?>">
					</td>
				</tr>

				<tr valign="top" class="api-key">
					<td scope="row">Button Text Color</td>
					<td>
						<input type="color" id="buttonText" name="buttonText" value="<?= $buttonFont; ?>">
					</td>
				</tr>
				<tr valign="top" class="api-key">
					<td scope="row"><h3><b>Additional Fields</b></h3></td>
				</tr>
				<tr valign="top" class="api-key">
					<td scope="row">Address</td>
					<td>
						<input type="radio" id="noLogo" name="Address" value="0"<?php echo ($address=="0") ?'checked="checked"':'';?> >
						<label for="male">Not Used</label><br>
						<input type="radio" id="leftLogo" name="Address" value="1" <?php echo ($address=="1") ?'checked="checked"':'';?>>
						<label for="male">Optional</label><br>
						<input type="radio" id="rightLogo" name="Address" value="2" <?php echo ($address=="2") ?'checked="checked"':'';?>>
						<label for="male">Required</label><br>
					</td>
				</tr>
				<tr valign="top" class="api-key">
					<td scope="row">Insurer</td>
					<td>
						<input type="radio" id="noLogo" name="Insurer" value="0" <?php echo ($insurer=="0") ?'checked="checked"':'';?>>
						<label for="male">Not Used</label><br>
						<input type="radio" id="leftLogo" name="Insurer" value="1" <?php echo ($insurer=="1") ?'checked="checked"':'';?>>
						<label for="male">Optional</label><br>
						<input type="radio" id="rightLogo" name="Insurer" value="2" <?php echo ($insurer=="2") ?'checked="checked"':'';?>>
						<label for="male">Required</label><br>
					</td>
				</tr>
				<tr valign="top" class="api-key">
					<td scope="row">Date of Birth</td>
					<td>
						<input type="radio" id="noLogo" name="dob" value="0" <?php echo ($dob=="0") ? 'checked="checked"':'';?>>
						<label for="male">Not Used</label><br>
						<input type="radio" id="leftLogo" name="dob" value="1" <?php echo ($dob=="1") ? 'checked="checked"':'';?>>
						<label for="male">Optional</label><br>
						<input type="radio" id="rightLogo" name="dob" value="2" <?php echo ($dob=="2") ? 'checked="checked"':'';?>>
						<label for="male">Required</label><br>
					</td>
				</tr>
				<tr valign="top" class="api-key">
					<td scope="row">Payment / Plan</td>
					<td>
						<input type="radio" id="noLogo" name="payment" value="0" <?php echo ($payment=="0") ? 'checked="checked"':'';?>>
						<label for="male">Not Used</label><br>
						<input type="radio" id="leftLogo" name="payment" value="1" <?php echo ($payment=="1") ? 'checked="checked"':'';?>>
						<label for="male">Optional</label><br>
						<input type="radio" id="rightLogo" name="payment" value="2" <?php echo ($payment=="2") ? 'checked="checked"':'';?>>
						<label for="male">Required</label><br>
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button button-primary" type="submit" name="Submit" value="Update Settings">
		</p>
	</form>
	<?php
}
