<!doctype html>
<html lang="en" data-bs-theme="blue-theme">


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/auth-cover-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 16:58:34 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maxton | Bootstrap 5 Admin Dashboard Template</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/main.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/dark-theme.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/blue-theme.css" rel="stylesheet">
    <link href="<?= base_url() ?>sass/responsive.css" rel="stylesheet">

</head>

<body>


    <!--authentication-->

    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">

                <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                        <div class="card-body">
                            <img src="<?= base_url() ?>assets/images/auth/reset-password1.png" class="img-fluid auth-img-cover-login" width="550" alt="">
                        </div>
                    </div>

                </div>

                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-sm-5">
                            <img src="<?= base_url() ?>assets/images/auth/auth_logo_light.png" class="mb-4" width="145" alt="">
                            <h4 class="fw-bold">¿Has olvidado tu contraseña?</h4>
                            <p class="mb-0">Ingrese su correo electrónico registrado para restablecer la contraseña <b><?= $masked_email ?? '' ?></b></p>

                            <div class="form-body mt-4">
                                <form class="row g-4" id="formForgotPassword">
                                    <div class="col-12">
                                        <label class="form-label">Correo electrónico</label>
                                        <input type="text" class="form-control" placeholder="example@user.com" name="email" id="email">
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-grd-info">Enviar</button>
                                            <a href="<?= base_url() ?>" class="btn btn-light">Volver al inicio de sesión</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>
    </div>

    <!--authentication-->




    <!--plugins-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>js/auth/forgot_password.js"></script>

</body>


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/auth-cover-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 16:58:34 GMT -->

</html>