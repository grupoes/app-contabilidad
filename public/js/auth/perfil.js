$(document).ready(function() {
    const formPassword = document.getElementById("formPassword");
    const message_error = document.getElementById("message_error");
    const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
    const btnChangePassword = document.getElementById('btnChangePassword');
    const btnVerifyOtp = document.getElementById('btnVerifyOtp');
    const otp_message_error = document.getElementById("otp_message_error");

    // Toggle Password Visibility
    $('.toggle-password').on('click', function() {
        const $input = $(this).siblings('input');
        const $icon = $(this).find('i');
        
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('bx-hide').addClass('bx-show');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('bx-show').addClass('bx-hide');
        }
    });

    // OTP Input Navigation
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    // Step 1: Send OTP and open modal
    formPassword.addEventListener("submit", (e) => {
        e.preventDefault();
        message_error.innerHTML = "";

        const newPass = document.getElementById('NewPassword').value;
        const confirmPass = document.getElementById('ConfirmPassword').value;

        if (newPass.length < 8) {
            showAlert(message_error, "La nueva contraseña debe tener al menos 8 caracteres.", "danger");
            return;
        }

        if (newPass !== confirmPass) {
            showAlert(message_error, "Las contraseñas no coinciden.", "danger");
            return;
        }

        btnChangePassword.disabled = true;
        btnChangePassword.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando código...';

        // Solicitar código de verificación
        fetch(`${base_url}auth/reset-password-link`, {
            method: "POST"
        })
        .then(res => res.json())
        .then(data => {
            btnChangePassword.disabled = false;
            btnChangePassword.innerHTML = 'Verificar y Cambiar Contraseña';

            if (data.status === "success") {
                if (data.masked_email) {
                    document.getElementById('otpTextDescription').innerHTML = `Se envió el código al siguiente correo <b>${data.masked_email}</b>. Ingresa los 6 dígitos para continuar.`;
                }
                otpModal.show();
            } else {
                showAlert(message_error, data.message || "Error al enviar el código.", "danger");
            }
        })
        .catch(err => {
            btnChangePassword.disabled = false;
            btnChangePassword.innerHTML = 'Verificar y Cambiar Contraseña';
            showAlert(message_error, "Error de conexión.", "danger");
        });
    });

    // Step 2: Verify OTP and finalize change
    btnVerifyOtp.addEventListener('click', () => {
        const code = Array.from(otpInputs).map(input => input.value).join('');
        
        if (code.length < 6) {
            showAlert(otp_message_error, "Ingresa los 6 dígitos.", "danger");
            return;
        }

        btnVerifyOtp.disabled = true;
        btnVerifyOtp.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verificando...';

        const formDataVerify = new FormData();
        formDataVerify.append('code', code);

        // Verificar código
        fetch(`${base_url}auth/verify-code`, {
            method: "POST",
            body: formDataVerify
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                // Código correcto, proceder al cambio de contraseña final
                finalizePasswordChange();
            } else {
                btnVerifyOtp.disabled = false;
                btnVerifyOtp.innerHTML = 'Confirmar Código';
                showAlert(otp_message_error, data.message || "Código incorrecto.", "danger");
            }
        })
        .catch(err => {
            btnVerifyOtp.disabled = false;
            btnVerifyOtp.innerHTML = 'Confirmar Código';
            showAlert(otp_message_error, "Error de conexión.", "danger");
        });
    });

    function finalizePasswordChange() {
        const formData = new FormData(formPassword);

        fetch(`${base_url}change-password`, {
            method: "POST",
            body: formData,
        })
        .then((res) => res.json())
        .then((data) => {
            btnVerifyOtp.disabled = false;
            btnVerifyOtp.innerHTML = 'Confirmar Código';
            otpModal.hide();

            if (data.status == "error") {
                showAlert(message_error, data.message, "danger");
            } else {
                formPassword.reset();
                showAlert(message_error, data.message, "success");
                // Opcional: limpiar inputs OTP
                otpInputs.forEach(input => input.value = '');
            }
        })
        .catch(err => {
            otpModal.hide();
            showAlert(message_error, "Error al actualizar la contraseña.", "danger");
        });
    }

    function showAlert(container, msg, type) {
        container.innerHTML = `
            <div class="alert alert-${type} border-0 bg-${type} alert-dismissible fade show">
                <div class="text-white">${msg}</div>
            </div>
        `;
    }
});
