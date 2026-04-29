<!doctype html>
<html lang="es" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar Contraseña | Seguridad de Cuenta</title>
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
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.12), rgba(255, 107, 53, 0.06));
            border: 1px solid rgba(255, 107, 53, 0.25);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #e05a1e;
            letter-spacing: 0.3px;
            margin-bottom: 20px;
        }

        .security-badge i {
            font-size: 15px;
        }

        .info-banner {
            background: linear-gradient(135deg, #fff8f0, #fff3e8);
            border: 1px solid #ffd4b8;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-banner i {
            font-size: 20px;
            color: #e67e22;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .info-banner p {
            font-size: 13.5px;
            color: #7d4e1c;
            line-height: 1.55;
            margin: 0;
        }

        .form-control-custom {
            border-color: #e2e8f0;
            font-size: 14px;
            border-left: 0;
        }

        .form-control-custom:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
        }

        .input-group-text-custom {
            background: #f8fafc;
            border-color: #e2e8f0;
            border-right: 0;
        }

        .btn-save {
            background: linear-gradient(135deg, #0f3460, #1a6eb5);
            border: 0;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: opacity .2s, transform .15s;
        }

        .btn-save:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn-save:active {
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
                                class="img-fluid auth-img-cover-login" width="550" alt="Seguridad de cuenta">
                        </div>
                    </div>
                </div>

                <!-- Panel derecho: formulario -->
                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-sm-5">

                            <img src="<?= base_url() ?>assets/images/auth/auth_logo_light.png"
                                class="mb-4" width="145" alt="Logo">

                            <!-- Badge de alerta -->
                            <div class="security-badge">
                                <i class='bx bx-shield-quarter'></i>
                                Acción de seguridad requerida
                            </div>

                            <h4 class="fw-bold mb-1">Cambia tu contraseña</h4>
                            <p class="text-white mb-0" style="font-size:14px;">
                                Detectamos que estás usando una contraseña por defecto. Por tu seguridad, actualízala ahora.
                            </p>

                            <!-- Banner informativo -->
                            <div class="info-banner mt-4">
                                <i class='bx bx-info-circle'></i>
                                <p>Ingresa tu <strong>correo electrónico</strong> y te enviaremos un enlace para establecer una contraseña segura y personalizada. Recuerda revisar también tu carpeta de <strong>spam</strong> o correo no deseado.</p>
                            </div>

                            <!-- Alerta de respuesta -->
                            <div id="alertMsg" class="alert border-0 alert-dismissible fade show mb-3" role="alert">
                                <span id="alertText"></span>
                            </div>

                            <!-- Formulario -->
                            <form id="formResetPassword" novalidate>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-white" style="font-size:13px;">
                                        Correo electrónico <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="email"
                                            id="reset_email"
                                            name="email"
                                            class="form-control"
                                            placeholder="tucorreo@ejemplo.com"
                                            required>
                                    </div>
                                    <div id="emailError" class="text-danger mt-1" style="font-size:12px;display:none;">
                                        Ingresa un correo electrónico válido.
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-save text-white py-2" id="btnEnviar">
                                        <i class='bx bx-send me-1'></i> Enviar enlace de cambio
                                    </button>
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
        const form = document.getElementById('formResetPassword');
        const emailInput = document.getElementById('reset_email');
        const emailError = document.getElementById('emailError');
        const alertMsg = document.getElementById('alertMsg');
        const alertText = document.getElementById('alertText');
        const btnEnviar = document.getElementById('btnEnviar');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = emailInput.value.trim();

            // Validar email
            if (!emailRegex.test(email)) {
                emailError.style.display = 'block';
                emailInput.style.borderColor = '#e74c3c';
                return;
            }
            emailError.style.display = 'none';
            emailInput.style.borderColor = '#e2e8f0';

            // Estado cargando
            btnEnviar.disabled = true;
            btnEnviar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            const formData = new FormData();
            formData.append('email', email);

            fetch('/auth/reset-password-link', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    alertMsg.style.display = 'block';
                    if (data.status === 'success') {
                        alertMsg.classList.remove('alert-danger', 'bg-danger');
                        alertMsg.classList.add('alert-success', 'bg-success', 'text-white');
                        alertText.textContent = data.message || 'Código enviado. Redirigiendo...';
                        setTimeout(() => {
                            window.location.href = data.redirect || '<?= base_url('auth/verify-code') ?>';
                        }, 1200);
                        return;
                    }
                    alertMsg.classList.remove('alert-success', 'bg-success', 'text-white');
                    alertMsg.classList.add('alert-danger', 'bg-danger', 'text-white');
                    alertText.textContent = data.message || 'Ocurrió un error. Intenta de nuevo.';
                    btnEnviar.disabled = false;
                    btnEnviar.innerHTML = '<i class="bx bx-send me-1"></i> Enviar enlace de cambio';
                })
                .catch(() => {
                    alertMsg.style.display = 'block';
                    alertMsg.classList.add('alert-danger', 'bg-danger', 'text-white');
                    alertText.textContent = 'Error de conexión. Intenta de nuevo.';
                    btnEnviar.disabled = false;
                    btnEnviar.innerHTML = '<i class="bx bx-send me-1"></i> Enviar enlace de cambio';
                });
        });
    </script>

</body>

</html>