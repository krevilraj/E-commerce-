(function ($) {

    'use strict';

    /*
    Contact Form
    */
    $('#contactForm').validate({
        submitHandler: function (form) {

            var $form = $(form),
                $messageSuccess = $('#contactSuccess'),
                $messageError = $('#contactError'),
                $submitButton = $(this.submitButton),
                $errorMessage = $('#mailErrorMessage');

            $submitButton.button('loading');

            // Ajax Submit
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: {
                    name: $form.find('#name').val(),
                    email: $form.find('#email').val(),
                    subject: $form.find('#subject').val(),
                    message: $form.find('#message').val(),
                    phone: $form.find('#phone').val()

                },

            }).always(function (data, textStatus, jqXHR) {
if(textStatus=='success') {
    $errorMessage.empty().hide();


    $messageSuccess.removeClass('hidden');
    $messageError.addClass('showss');

    // Reset Form
    $form.find('.form-control')
        .val('')
        .blur()
        .parent()
        .removeClass('has-success')
        .removeClass('has-error')
        .find('label.error')
        .remove();

    if (($messageSuccess.offset().top - 80) < $(window).scrollTop()) {
        $('html, body').animate({
            scrollTop: $messageSuccess.offset().top - 80
        }, 300);
    }

    $submitButton.button('reset');

    return;
}
                 if (data.response === 'error' && typeof data.errorMessage !== 'undefined') {

                     $errorMessage.html(data.errorMessage).show();
                } else {
                    $errorMessage.html(data.responseText).show();
                }

                $messageError.removeClass('hidden');
                $messageSuccess.addClass('hidden');

                if (($messageError.offset().top - 80) < $(window).scrollTop()) {
                    $('html, body').animate({
                        scrollTop: $messageError.offset().top - 80
                    }, 300);
                }

                $form.find('.has-success')
                    .removeClass('has-success');

                $submitButton.button('reset');

            });
        }
    });

}).apply(this, [jQuery]);