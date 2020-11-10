jQuery(document).ready(function($) {
	$('#referrallogixInquiry').on('submit',function(){
		if(!$('#site_qsi').val().trim().length){
			$('#site_qsi').addClass('rl-errorBorder');
			return false;
		} else {
			$('#site_qsi').removeClass('rl-errorBorder');
		}
		if(!$('#api_key').val().trim().length){
			$('#api_key').addClass('rl-errorBorder');
			return false;
		}else{
			$('#api_key').removeClass('rl-errorBorder');
		}
		if(!$('#headerText').val().trim().length){
			$('#headerText').addClass('rl-errorBorder');
			return false;
		}else{
			$('#api_key').removeClass('rl-errorBorder');
		}
	});
});
