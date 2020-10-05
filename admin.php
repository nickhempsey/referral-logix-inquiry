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
   $root_path = plugin_dir_url( __FILE__ );

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['update']) && trim($_POST['update']) != 1) {
            $requestMethod = 1;
            $default_method = "UPDATE";
        }
        if(!empty($_POST['site_qsi']) && !empty($_POST['api_key'])) {
            if(isset($_POST['insert'])) {
                add_option('referrallogix_qsi_key',trim($_POST['site_qsi']));
                add_option('referrallogix_api_key',trim($_POST['api_key']));
            } else {
                update_option('referrallogix_qsi_key',trim($_POST['site_qsi']));
                update_option('referrallogix_api_key',trim($_POST['api_key']));
            }
            $apiKey = get_option('referrallogix_api_key');
            $qsiKey = get_option('referrallogix_qsi_key');

        }
    }
?>
    <form class="form-table" action="" method="post" id="#referrallogixInquiry">
	    <table class="form-table">
		    <tbody>
			    <tr valign="top">
					<td colspan="2">
						<h3 class="sendgrid-settings-top-header">ReferralLogix Inquiry Settings</h3>
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

		    </tbody>
	    </table>
	    
	    <p class="submit">
			<input class="button button-primary" type="submit" name="Submit" value="Update Settings">
		</p>
	</form>
    <?php
}
