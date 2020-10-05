jQuery(document).ready(function($) {
    $('#referrallogixInquiry').on('submit',function(){
        if($('#site_qsi').length && $('#api_key').length) {
            if($('#site_qsi').val().trim() != '' && $('#api_key').val().trim() != '') {
                $('#site_qsi,#api_key').removeClass('errorBorder');
                return true;
            }else{
                if($('#site_qsi').val().trim() == '') {
                    $('#site_qsi').addClass('errorBorder')
                }
                if($('#api_key').val().trim() == ''){
                    $('#api_key').addClass('errorBorder')
                }
                return false;
            }
        }
    });
});
