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
    
    const btn = formForgotPassword.querySelector('button[type="submit"]');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

    fetch('/auth/reset-password-link', {
        method: 'POST',
        body: new FormData(formForgotPassword)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Redirigir a la vista de verificación de código
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Ocurrió un error al procesar la solicitud.');
                btn.disabled = false;
                btn.innerText = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión. Intente de nuevo.');
            btn.disabled = false;
            btn.innerText = originalText;
        });
});
