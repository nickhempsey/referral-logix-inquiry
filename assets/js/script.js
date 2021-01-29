jQuery(document).ready(function($) {
    history.pushState({}, "", ""); //to avoid form submission on page reload.
    var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var	emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var popup = $('.rl-inquiry-form .popup').val();

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
        if(status == 'closed'){
            $('.rl-inquiry-form').removeClass('displayNone').attr('data-status', 'open').addClass('rl-inquiry-shadow').css('display','block');
            $('.tooltip-head').addClass('displayNone');
            $(this).attr('data-status', 'open').addClass('rl-inquiry-shadow');
        }
        else{
            $('.rl-inquiry-form').addClass('displayNone').attr('data-status', 'closed').removeClass('rl-inquiry-shadow');
            $(this).attr('data-status', 'closed').removeClass('rl-inquiry-shadow');
        }
    });

    $(document).on('change','.rl-inquiry-form .name, .rl-inquiry-form .phone, .rl-inquiry-form .message, .rl-inquiry-form .email,.rl-inquiry-form .address, .rl-inquiry-form .insurerBox, .rl-inquiry-form .dob, .rl-inquiry-form .paymentBox', function(){
        if($(this).hasClass('phone') && $(this).val().trim().match(phoneRegex) != null){
            if(($('.rl-inquiry-form .email').val().trim().length && $('.rl-inquiry-form .email').val().trim().match(emailRegex) != null) || (!$('.rl-inquiry-form .email').val().trim().length))
                $('.rl-inquiry-form .phone, .rl-inquiry-form .email').removeClass('rl-errorBorder');
            else
                $('.rl-inquiry-form .phone').removeClass('rl-errorBorder');
        } else if($(this).hasClass('email') && $(this).val().trim().match(emailRegex) != null){
            // $('.rl-inquiry-form .email, .rl-inquiry-form .phone').removeClass('rl-errorBorder');
            if(($('.rl-inquiry-form .phone').val().trim().length && $('.rl-inquiry-form .phone').val().trim().match(phoneRegex) != null) || (!$('.rl-inquiry-form .phone').val().trim().length))
                $('.rl-inquiry-form .email, .rl-inquiry-form .phone').removeClass('rl-errorBorder');
            else
                $('.rl-inquiry-form .email').removeClass('rl-errorBorder');
        }else if((!$(this).hasClass('phone') && !$(this).hasClass('email')) && $(this).val().trim().length){
            $(this).removeClass('rl-errorBorder');
        }
    });
    
    $(document).on('click','.rl-inquiry-form .rl-inquiry-submit', function () {
        var formFlag = true;
        var name = $('.rl-inquiry-form .name').val();
        var phone = $('.rl-inquiry-form .phone').val();
        var message = $('.rl-inquiry-form .message').val();
        var email = $('.rl-inquiry-form .email').val();
        var address = $('.rl-inquiry-form .address').val();
        var dob = $('.rl-inquiry-form .dob').val();
        var insurer = $('.rl-inquiry-form .insurerBox').val();
        var payment = $('.rl-inquiry-form .paymentBox:checked').val();
        $(this).prop('disabled', true);
        if(!name.trim().length) {
            console.log('name',name);
            $('.rl-inquiry-form .name').addClass('rl-errorBorder');
            formFlag = false;
        }
        if( !phone.trim().length && !email.trim().length ){
            $('.rl-inquiry-form .phone, .rl-inquiry-form .email').addClass('rl-errorBorder');
        }
        if (phone.trim().length && phone.match(phoneRegex) == null) {
            $('.rl-inquiry-form .phone').addClass('rl-errorBorder');
            formFlag = false;
        }
        if (email.trim().length && email.match(emailRegex) == null){
            $('.rl-inquiry-form .email').addClass('rl-errorBorder');
            formFlag = false;
        }
        if(!message.trim().length) {
            console.log('message',message);
            $('.rl-inquiry-form .message').addClass('rl-errorBorder');
            formFlag = false;
        }
        if (address != undefined && !address.trim().length && !$('.rl-inquiry-form .address').hasClass('optional')) {
            $('.rl-inquiry-form .address').addClass('rl-errorBorder');
            formFlag = false;
        }
        if (insurer != undefined && !insurer.trim().length && !$('.rl-inquiry-form .insurerBox').hasClass('optional')) {
            $('.rl-inquiry-form .insurerBox').addClass('rl-errorBorder');
            formFlag = false;
        }
        if (dob != undefined && !dob.trim().length && !$('.rl-inquiry-form .dob').hasClass('optional')) {
            $('.rl-inquiry-form .dob').addClass('rl-errorBorder');
            formFlag = false;
        }
        if (payment != undefined && !payment.trim().length && !$('.rl-inquiry-form .paymentBox').hasClass('optional')) {
            $('.rl-inquiry-form .paymentBox').addClass('rl-errorBorder');
            formFlag = false;
        }

        if (formFlag){
            $('.loader').removeClass('displayNone');
            $('.rl-inquiry-form .patientInquiryForm').submit();
            $(this).prop('disabled', true);
            return false;
        }
        $(this).prop('disabled', false);
        return false;
    });

    $(document).on('focus','.rl-inquiry-form .message,.rl-inquiry-form .addressBox',function(){
        $(this).next().addClass('txtaraLbl');
    });
    $(document).on('blur','.rl-inquiry-form .message, .rl-inquiry-form .addressBox',function(){
        if(!$(this).val().trim().length)
            $(this).next().removeClass('txtaraLbl');
    });

    if(popup != 0){
        setTimeout(function () {
            $('.tooltip-head').fadeOut('fast');
        }, (popup*1000));
    } 

    var popupText = $('.tooltip-head .tooltip-text').text();
    var popupImage = $('#tooltip-image').attr('src');
    $('.rl-inquiry-popup-opener .tooltip-content').removeClass('displayNone');
    $('.rl-inquiry-popup-opener .tooltip-content').removeClass('tooltip-content_img');
    $('.rl-inquiry-popup-opener #tooltip-image').removeClass('displayNone');

    if(popupText == "") {
        $('.rl-inquiry-popup-opener .tooltip-content').addClass('tooltip-content_img');
    }
    if(popupImage == undefined || popupImage == "") {
        $('.rl-inquiry-popup-opener .tooltip-text').css('text-align', 'center');
        $('.rl-inquiry-popup-opener #tooltip-image').addClass('displayNone');
    }
    if(popupText == "" && popupImage == "") {
        $('.rl-inquiry-popup-opener .tooltip-head').addClass('displayNone');
    }
});
