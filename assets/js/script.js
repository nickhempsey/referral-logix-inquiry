jQuery(document).ready(function($) {
    history.pushState({}, "", ""); //to avoid form submission on page reload.
    var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var	emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;    	
    
    $(document).on('click','.expandFormButton',function () {
        $('.moreForm').removeClass('displayNone');
        $('.expandForm').addClass('displayNone');
        return false;
    });
    $(document).on('click','.rl-inquiry-form .rl-inquiry-closeAlert',function () {
        $('.alertMsg').addClass('displayNone');
        $('.rl-inquiry-form').fadeOut().attr('data-status', 'closed');
        $('.rl-inquiry-popup-opener').attr('data-status', 'closed').removeClass('rl-inquiry-shadow');
    });
    $(document).on('click','.rl-inquiry-popup-opener',function () {
        var status = $(this).attr('data-status');
        console.log('status',status);
        if(status == 'closed'){
            $('.rl-inquiry-form').removeClass('displayNone').attr('data-status', 'open').addClass('rl-inquiry-shadow').css('display','block');
            $(this).attr('data-status', 'open').addClass('rl-inquiry-shadow');
        }
        else{
            $('.rl-inquiry-form').addClass('displayNone').attr('data-status', 'closed').removeClass('rl-inquiry-shadow');
            $(this).attr('data-status', 'closed').removeClass('rl-inquiry-shadow');
        }
    });
    
    $(document).on('click','.rl-inquiry-form .rl-inquiry-submit', function () {
        var formFlag = true;
        var name = $('.rl-inquiry-form .name').val();
        var phone = $('.rl-inquiry-form .phone').val();
        var message = $('.rl-inquiry-form .message').val();
        var email = $('.rl-inquiry-form .email').val();
        $(this).prop('disabled', true);
        if(!name.trim().length) {
            $('.rl-inquiry-form .name').addClass('errorBorder');
            formFlag = false;
        }
        if(phone == undefined && email == undefined){
            $('.rl-inquiry-form .phoneEmail').addClass('errorBorder');
            formFlag = false;
        }
        if (phone != undefined && phone.trim().length && !phone.match(phoneRegex)) {
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
            $(this).prop('disabled', true);
            return true;
        }
        $(this).prop('disabled', true);
        return false;
    });

    $(document).on('change','.rl-inquiry-form form :input',function(){
        // $(this).css('border','1px solid black');
        $(this).removeClass('errorBorder');
        if($(this).hasClass('phoneEmail')){
            if($(this).val().match(phoneRegex)) {
                $('.rl-inquiry-form .phoneEmailLabel').text('Mobile Phone');
                $('.rl-inquiry-form .emailPhoneLabel').text('Email');
                $('.rl-inquiry-form .phoneEmail').attr('name', 'phone').addClass('phone').removeClass('email');
                $('.rl-inquiry-form .emailPhone').attr('name', 'email').addClass('email').removeClass('phone');
            } else if($(this).val().match(emailRegex)){
                $('.rl-inquiry-form .phoneEmailLabel').text('Email');
                $('.rl-inquiry-form .emailPhoneLabel').text('Mobile Phone');
                $('.rl-inquiry-form .phoneEmail').attr('name', 'email').addClass('email').removeClass('phone');
                $('.rl-inquiry-form .emailPhone').attr('name', 'phone').addClass('phone').removeClass('email');
            } else {
                $(this).addClass('errorBorder');
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
