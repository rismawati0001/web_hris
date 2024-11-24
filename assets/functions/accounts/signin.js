$('#reload_captcha').click(function (event) {
    event.preventDefault();
    $.ajax({
        url: baseURL + 'authentication/signin/reload_captcha',
        dataType: "text",
        cache: false,
        success: function (data) {
            $('#captcha_login').replaceWith(data);
        }
    });
});

$(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

const password = document.querySelector('#v_pass');
const message = document.querySelector('.message');

password.addEventListener('keyup', function (e) {
    if (e.getModifierState('CapsLock')) {
        message.textContent = 'Caps lock is on';
    } else {
        message.textContent = '';
    }
});