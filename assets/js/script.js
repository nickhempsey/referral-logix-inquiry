jQuery(document).ready(function($) {
    var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    $(document).on('click','.expandFormButton',function () {
        $('.moreForm').removeClass('displayNone');
        $('.expandForm').addClass('displayNone');
        return false;
    });
    $(document).on('click','.rl-inquiry-form .closeAlert',function () {
        $('.alertMsg').addClass('displayNone');
    });
    $(document).on('click','.rl-inquiry-popup-opener',function () {
        var status = $(this).attr('data-status');
        if(status == 'closed'){
            $('.rl-inquiry-form').removeClass('displayNone').attr('data-status', 'open');
            $(this).attr('data-status', 'open');
        }
        else{
            $('.rl-inquiry-form').addClass('displayNone').attr('data-status', 'closed');
            $(this).attr('data-status', 'closed');
        }
    });
    
    
    $(document).on('click','.rl-inquiry-form .rl-inquiry-submit', function () {
        var formFlag = true;
        var name = $('.rl-inquiry-form .name').val();
        var phone = $('.rl-inquiry-form .phone').val();
        var message = $('.rl-inquiry-form .message').val();
        var email = $('.rl-inquiry-form .email').val();
        if(!name.trim().length) {
            $('.rl-inquiry-form .name').addClass('errorBorder');
            formFlag = false;
        }
        if (phone != undefined && !phone.trim().length) {
            if(!email.trim().length){
                $('.rl-inquiry-form .phone').addClass('errorBorder');
                formFlag = false;
            }
        } else if (phone != undefined && !phone.match(phoneRegex)) {
            $('.rl-inquiry-form .phone').addClass('errorBorder');
            formFlag = false;
        }
        if(!message.trim().length) {
            $('.rl-inquiry-form .message').addClass('errorBorder');
            formFlag = false;
        }
        if (email != undefined && email.trim().length && !email.match(emailRegex)){
            $('.rl-inquiry-form .email').addClass('errorBorder');
            formFlag = false;
        }
        if (formFlag){
            $('.rl-inquiry-form .patientInquiryForm').submit();
            return true;
        }
        return false;
    });

    $(document).on('change','.rl-inquiry-form form :input',function(){
        $(this).css('border','1px solid black');
        if($(this).hasClass('phoneEmail')){
            if($(this).val().match(phoneRegex)) {
                $('.rl-inquiry-form .phoneEmailLabel').text('Mobile Phone');
                $('.rl-inquiry-form .emailPhoneLabel').text('Email');
                $('.rl-inquiry-form .phoneEmail').addClass('phone').removeClass('email');
                $('.rl-inquiry-form .emailPhone').addClass('email').removeClass('phone');
            } else if($(this).val().match(emailRegex)){
                $('.rl-inquiry-form .phoneEmailLabel').text('Email');
                $('.rl-inquiry-form .emailPhoneLabel').text('Mobile Phone');
                $('.rl-inquiry-form .phoneEmail').addClass('email').removeClass('phone');
                $('.rl-inquiry-form .emailPhone').addClass('phone').removeClass('email');
            } else {
                $('.rl-inquiry-form .phoneEmailLabel').text('Mobile Phone or Email for slower response');
                $('.rl-inquiry-form .emailPhoneLabel').text('Email');
                $('.rl-inquiry-form .email').removeClass('email');
                $('.rl-inquiry-form .phone').removeClass('phone');
            }
        }
    });
    $(document).on('focus','.rl-inquiry-form .message,.rl-inquiry-form .addressBox',function(){
        $(this).next().addClass('txtaraLbl');
    });
    $(document).on('blur','.rl-inquiry-form .message, .rl-inquiry-form .addressBox',function(){
        if(!$(this).val().trim().length)
            $(this).next().removeClass('txtaraLbl');
    });
});
