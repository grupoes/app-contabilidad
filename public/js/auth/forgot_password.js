$(document).ready(function () {
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
        }
    });
});

const formForgotPassword = document.getElementById('formForgotPassword');

formForgotPassword.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch('auth/reset-password-link', {
        method: 'POST',
        body: new FormData(formForgotPassword)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                formForgotPassword.reset();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
