<!doctype html>
<html lang="es" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva Contraseña | Seguridad de Cuenta</title>
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
        .requirement-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .requirement-item:last-child {
            margin-bottom: 0;
        }

        .requirement-item i {
            font-size: 16px;
        }

        .requirement-item.valid {
            color: #22c55e;
        }

        .requirement-item.valid i {
            color: #22c55e;
        }

        /* ── Inputs ── */
        .form-control-password {
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: white !important;
            padding: 12px 16px;
            border-radius: 10px;
        }

        .form-control-password:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .input-group-text-password {
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-left: 0 !important;
            color: rgba(255, 255, 255, 0.6) !important;
            cursor: pointer;
            border-radius: 0 10px 10px 0 !important;
        }

        /* ── Botón principal ── */
        .btn-update {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: 0;
            border-radius: 10px;
            font-weight: 600;
            padding: 12px;
            letter-spacing: 0.3px;
            transition: all .2s;
        }

        .btn-update:hover:not(:disabled) {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-update:disabled {
            background: #475569;
            opacity: 0.6;
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
                                class="img-fluid auth-img-cover-login" width="550" alt="Nueva contraseña">
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
                                <i class='bx bx-lock-open-alt'></i>
                                Seguridad de Cuenta
                            </div>

                            <h4 class="fw-bold mb-1 text-white">Establecer nueva contraseña</h4>
                            <p class="text-white-50 mb-4" style="font-size:14px;">
                                Por favor, crea una contraseña segura para proteger tu cuenta.
                            </p>

                            <!-- Requisitos -->
                            <div class="requirement-card">
                                <div class="requirement-item" id="reqLength">
                                    <i class='bx bx-circle'></i>
                                    Mínimo 8 caracteres
                                </div>
                                <div class="requirement-item" id="reqAlpha">
                                    <i class='bx bx-circle'></i>
                                    Debe contener letras y números
                                </div>
                            </div>

                            <!-- Alerta de respuesta -->
                            <div id="alertMsg" class="alert border-0 alert-dismissible fade show mb-3" role="alert">
                                <span id="alertText"></span>
                            </div>

                            <!-- Formulario -->
                            <form id="formNewPassword" novalidate>
                                <div class="mb-3">
                                    <label class="form-label text-white-50">Nueva contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-password" id="new_password" name="new_password" placeholder="Tu nueva contraseña" required>
                                        <span class="input-group-text input-group-text-password toggle-password" data-target="new_password">
                                            <i class='bx bx-hide'></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-white-50">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-password" id="confirm_password" name="confirm_password" placeholder="Repite la contraseña" required>
                                        <span class="input-group-text input-group-text-password toggle-password" data-target="confirm_password">
                                            <i class='bx bx-hide'></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-update text-white" id="btnSubmit">
                                        Actualizar Contraseña
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
        $(document).ready(function() {
            const $newPass = $('#new_password');
            const $confirmPass = $('#confirm_password');
            const $reqLength = $('#reqLength');
            const $reqAlpha = $('#reqAlpha');
            const $btnSubmit = $('#btnSubmit');
            const $form = $('#formNewPassword');
            const $alertMsg = $('#alertMsg');
            const $alertText = $('#alertText');

            // Toggle Password Visibility
            $('.toggle-password').on('click', function() {
                const targetId = $(this).data('target');
                const $input = $('#' + targetId);
                const $icon = $(this).find('i');
                
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('bx-hide').addClass('bx-show');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('bx-show').addClass('bx-hide');
                }
            });

            // Real-time validation
            function validatePassword() {
                const val = $newPass.val();
                
                // Length check
                const isLongEnough = val.length >= 8;
                updateRequirement($reqLength, isLongEnough);

                // Alphanumeric check (must have at least one letter and one number)
                const isAlphanumeric = /^(?=.*[a-zA-Z])(?=.*[0-9])/.test(val);
                updateRequirement($reqAlpha, isAlphanumeric);

                return isLongEnough && isAlphanumeric;
            }

            function updateRequirement($el, isValid) {
                if (isValid) {
                    $el.addClass('valid');
                    $el.find('i').removeClass('bx-circle').addClass('bx-check-circle');
                } else {
                    $el.removeClass('valid');
                    $el.find('i').removeClass('bx-check-circle').addClass('bx-circle');
                }
            }

            $newPass.on('input', validatePassword);

            // Form Submission
            $form.on('submit', function(e) {
                e.preventDefault();

                const pass = $newPass.val();
                const confirm = $confirmPass.val();

                if (!validatePassword()) {
                    showAlert('danger', 'La contraseña no cumple con los requisitos mínimos.');
                    return;
                }

                if (pass !== confirm) {
                    showAlert('danger', 'Las contraseñas no coinciden.');
                    return;
                }

                $btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Actualizando...');

                $.ajax({
                    url: '/auth/update-password',
                    method: 'POST',
                    data: {
                        new_password: pass,
                        confirm_password: confirm
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            showAlert('success', data.message);
                            setTimeout(() => {
                                window.location.href = data.redirect || '/home';
                            }, 1500);
                        } else {
                            showAlert('danger', data.message);
                            $btnSubmit.prop('disabled', false).text('Actualizar Contraseña');
                        }
                    },
                    error: function() {
                        showAlert('danger', 'Error de conexión. Intenta de nuevo.');
                        $btnSubmit.prop('disabled', false).text('Actualizar Contraseña');
                    }
                });
            });

            function showAlert(type, msg) {
                $alertMsg.removeClass('alert-danger alert-success bg-danger bg-success')
                         .addClass('alert-' + type + ' bg-' + type + ' text-white')
                         .fadeIn();
                $alertText.text(msg);
            }
        });
    </script>

</body>

</html>
