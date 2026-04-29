<!doctype html>
<html lang="es" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar Código | Seguridad de Cuenta</title>
    <!--favicon-->
    <link rel="icon" href="<?= base_url() ?>assets/images/grupoesicon.ico" type="image/x-icon">
    <!-- loader-->
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <!--plugins-->
    <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/metismenu/mm-vertical.css">
    <!--bootstrap css-->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/main.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/dark-theme.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/blue-theme.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/responsive.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="<?= base_url() ?>assets/plugins/Boxicons/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* ── Badge de acción ── */
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(99, 179, 237, 0.15), rgba(99, 179, 237, 0.06));
            border: 1px solid rgba(99, 179, 237, 0.3);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #3b82f6;
            letter-spacing: 0.3px;
            margin-bottom: 20px;
        }

        .security-badge i {
            font-size: 15px;
        }

        /* ── Banner info ── */
        .info-banner {
            background: linear-gradient(135deg, #f0f7ff, #e8f3ff);
            border: 1px solid #b8d4ff;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-banner i {
            font-size: 20px;
            color: #2563eb;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .info-banner p {
            font-size: 13.5px;
            color: #1e3a5f;
            line-height: 1.55;
            margin: 0;
        }

        /* ── Inputs OTP ── */
        .otp-wrapper {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 8px;
        }

        .otp-input {
            width: 52px;
            height: 58px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: inherit;
            transition: border-color .2s, box-shadow .2s, transform .15s;
            outline: none;
            caret-color: transparent;
        }

        .otp-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
            transform: translateY(-2px);
        }

        .otp-input.filled {
            border-color: #22c55e;
            background: rgba(34, 197, 94, 0.06);
        }

        .otp-input.error-shake {
            border-color: #ef4444 !important;
            animation: shake .35s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }

        /* ── Temporizador ── */
        .timer-text {
            font-size: 13px;
            text-align: center;
            margin-top: 6px;
        }

        .timer-count {
            font-weight: 700;
            color: #3b82f6;
        }

        #btnReenviar {
            background: none;
            border: none;
            padding: 0;
            font-size: 13px;
            font-weight: 600;
            color: #3b82f6;
            cursor: pointer;
            text-decoration: underline;
        }

        #btnReenviar:disabled {
            color: #64748b;
            text-decoration: none;
            cursor: not-allowed;
        }

        /* ── Botón principal ── */
        .btn-verify {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: 0;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: opacity .2s, transform .15s;
        }

        .btn-verify:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        #alertMsg {
            display: none;
        }
    </style>
</head>

<body>

    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">

                <!-- Panel izquierdo decorativo -->
                <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">
                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                        <div class="card-body">
                            <img src="<?= base_url() ?>assets/images/auth/reset-password1.png"
                                class="img-fluid auth-img-cover-login" width="550" alt="Verificación de código">
                        </div>
                    </div>
                </div>

                <!-- Panel derecho: formulario -->
                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-sm-5">

                            <img src="<?= base_url() ?>assets/images/auth/auth_logo_light.png"
                                class="mb-4" width="145" alt="Logo">

                            <!-- Badge -->
                            <div class="security-badge">
                                <i class='bx bx-envelope-open'></i>
                                Verificación de correo
                            </div>

                            <h4 class="fw-bold mb-1">Ingresa el código</h4>
                            <p class="text-white mb-0" style="font-size:14px;">
                                Hemos enviado un código de 6 dígitos a tu correo electrónico.
                            </p>

                            <!-- Banner informativo -->
                            <div class="info-banner mt-4">
                                <i class='bx bx-info-circle'></i>
                                <p>Revisa tu bandeja de entrada (y también el <strong>spam</strong>). El código expirará en <strong>10 minutos</strong>.</p>
                            </div>

                            <!-- Alerta de respuesta -->
                            <div id="alertMsg" class="alert border-0 alert-dismissible fade show mb-3" role="alert">
                                <span id="alertText"></span>
                            </div>

                            <!-- Formulario OTP -->
                            <form id="formVerifyCode" novalidate>
                                <input type="hidden" id="emailSent" value="<?= esc(session()->get('reset_email') ?? '') ?>">

                                <label class="form-label fw-semibold text-white d-block text-center mb-3" style="font-size:13px;">
                                    Código de verificación <span class="text-danger">*</span>
                                </label>

                                <!-- Inputs individuales -->
                                <div class="otp-wrapper">
                                    <input class="otp-input" id="otp1" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                    <input class="otp-input" id="otp2" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                    <input class="otp-input" id="otp3" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                    <input class="otp-input" id="otp4" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                    <input class="otp-input" id="otp5" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                    <input class="otp-input" id="otp6" type="text" inputmode="numeric" maxlength="1" autocomplete="off">
                                </div>

                                <!-- Temporizador y reenvío -->
                                <div class="timer-text text-white-50 mt-2 mb-4">
                                    ¿No recibiste el código?
                                    <button type="button" id="btnReenviar" disabled>Reenviar</button>
                                    <span id="timerWrapper"> en <span id="timerCount" class="timer-count">2:00</span></span>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-verify text-white py-2" id="btnVerificar">
                                        <i class='bx bx-check-shield me-1'></i> Verificar código
                                    </button>
                                    <a href="<?= base_url('auth/reset-password') ?>" class="btn btn-link text-white-50" style="font-size:13px;">
                                        <i class='bx bx-arrow-back me-1'></i> Volver e ingresar otro correo
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div><!--end row-->
        </div>
    </div>

    <!--plugins-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        /* ===== OTP inputs ===== */
        const otpInputs = Array.from(document.querySelectorAll('.otp-input'));

        otpInputs.forEach((input, idx) => {

            // Foco: seleccionar el contenido para reemplazarlo fácilmente
            input.addEventListener('focus', function() {
                this.select();
            });

            // Input: filtrar y avanzar (sin bloquear keydown)
            input.addEventListener('input', function() {
                // Eliminar todo lo que no sea dígito y quedarse solo con el último
                const digits = this.value.replace(/\D/g, '');
                this.value = digits.slice(-1);

                this.classList.toggle('filled', this.value !== '');

                // Avanzar al siguiente campo si hay un dígito
                if (this.value !== '' && idx < otpInputs.length - 1) {
                    otpInputs[idx + 1].focus();
                }
            });

            // Backspace: borrar y retroceder
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace') {
                    if (this.value === '' && idx > 0) {
                        otpInputs[idx - 1].value = '';
                        otpInputs[idx - 1].classList.remove('filled');
                        otpInputs[idx - 1].focus();
                    } else {
                        this.value = '';
                        this.classList.remove('filled');
                    }
                }
                // Navegación con flechas
                if (e.key === 'ArrowLeft' && idx > 0) otpInputs[idx - 1].focus();
                if (e.key === 'ArrowRight' && idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
            });

            // Pegar código completo (desde cualquier caja)
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text');
                const digits = text.replace(/\D/g, '').slice(0, 6);
                digits.split('').forEach((digit, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = digit;
                        otpInputs[i].classList.add('filled');
                    }
                });
                // Mover foco al último rellenado o al siguiente vacío
                const nextEmpty = otpInputs.find(el => el.value === '');
                (nextEmpty || otpInputs[otpInputs.length - 1]).focus();
            });
        });

        /* ===== Temporizador ===== */
        const TIMER_SECONDS = 120; // 2 minutos
        let remaining = TIMER_SECONDS;
        let timerInterval;

        const timerCount   = document.getElementById('timerCount');
        const timerWrapper = document.getElementById('timerWrapper');
        const btnReenviar  = document.getElementById('btnReenviar');

        function formatTime(s) {
            const m = Math.floor(s / 60);
            const sec = s % 60;
            return `${m}:${sec.toString().padStart(2, '0')}`;
        }

        function startTimer() {
            remaining = TIMER_SECONDS;
            timerCount.textContent = formatTime(remaining);
            timerWrapper.style.display = 'inline';
            btnReenviar.disabled = true;

            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                remaining--;
                timerCount.textContent = formatTime(remaining);
                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    timerWrapper.style.display = 'none';
                    btnReenviar.disabled = false;
                }
            }, 1000);
        }

        startTimer();

        /* ===== Reenviar código ===== */
        btnReenviar.addEventListener('click', function() {
            this.disabled = true;

            fetch('/auth/reset-password-link', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ email: document.getElementById('emailSent')?.value || '' }),
                })
                .then(r => r.json())
                .then(() => startTimer())
                .catch(() => startTimer());
        });

        /* ===== Envío del formulario ===== */
        const form       = document.getElementById('formVerifyCode');
        const alertMsg   = document.getElementById('alertMsg');
        const alertText  = document.getElementById('alertText');
        const btnVerificar = document.getElementById('btnVerificar');

        function showAlert(type, msg) {
            alertMsg.className = `alert border-0 fade show mb-3 alert-${type} bg-${type} text-white`;
            alertMsg.style.display = 'block';
            alertText.textContent = msg;
        }

        function shakeInputs() {
            otpInputs.forEach(i => {
                i.classList.add('error-shake');
                setTimeout(() => i.classList.remove('error-shake'), 400);
            });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const code = otpInputs.map(i => i.value).join('');

            if (code.length < 6) {
                shakeInputs();
                showAlert('danger', 'Por favor completa los 6 dígitos del código.');
                return;
            }

            btnVerificar.disabled = true;
            btnVerificar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verificando...';

            const formData = new FormData();
            formData.append('code', code);

            fetch('/auth/verify-code', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        showAlert('success', data.message || 'Código verificado correctamente.');
                        setTimeout(() => {
                            window.location.href = data.redirect || '/';
                        }, 1200);
                    } else {
                        shakeInputs();
                        showAlert('danger', data.message || 'Código incorrecto. Intenta de nuevo.');
                        otpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
                        otpInputs[0].focus();
                        btnVerificar.disabled = false;
                        btnVerificar.innerHTML = '<i class="bx bx-check-shield me-1"></i> Verificar código';
                    }
                })
                .catch(() => {
                    showAlert('danger', 'Error de conexión. Intenta de nuevo.');
                    btnVerificar.disabled = false;
                    btnVerificar.innerHTML = '<i class="bx bx-check-shield me-1"></i> Verificar código';
                });
        });
    </script>

</body>

</html>
