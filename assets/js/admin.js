jQuery(document).ready(function($) {
	$('#referrallogixInquiry').on('submit',function(){
		var apiKey = $('#api_key').val();
		var replacedAPIkey = apiKey.replaceAll('-', 'U');
		$('#api_key').val(replacedAPIkey);
		
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
	var color = $('#iconBg').val();
	$('.iconModelImg').css('background-color', color);

	$('#iconBg').on('change', function () {
		var color = $('#iconBg').val();
		$('.iconModelImg').css('background-color', color);

	});
});
