<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Inicio</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Perfil</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">

                <div class="profile-info d-flex align-items-center justify-content-between">
                    <div class="">
                        <h3><?= session()->get('nombre') ?></h3>
                        <h6 class="mb-0"><?= session()->get('user')['username'] ?></h6>
                    </div>
                </div>

                <div class="d-flex pt-5 align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Cambiar contraseña</h5>
                    </div>
                </div>
                <form class="row g-3" id="formPassword">
                    <div class="col-12">
                        <label class="form-label" for="currentPassword">Contraseña Actual</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" placeholder="Escribe tu contraseña actual" name="currentPassword">
                            <span class="input-group-text toggle-password" style="cursor: pointer;"><i class='bx bx-hide'></i></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="NewPassword">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="Escribe la nueva contraseña">
                            <span class="input-group-text toggle-password" style="cursor: pointer;"><i class='bx bx-hide'></i></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="ConfirmPassword">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirma la contraseña">
                            <span class="input-group-text toggle-password" style="cursor: pointer;"><i class='bx bx-hide'></i></span>
                        </div>
                    </div>

                    <div class="col-12" id="message_error"></div>

                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-grd-info" id="btnChangePassword">Verificar y Cambiar Contraseña</button>
                        </div>
                    </div>
                </form>

                <!-- Modal para Código de Verificación -->
                <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-top border-4 border-primary">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Verificación de Seguridad</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-4">
                                <div class="mb-3">
                                    <i class='bx bx-shield-quarter text-primary' style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="mb-2">Ingresa el código enviado a tu correo</h6>
                                <p class="text-muted small mb-4">Por seguridad, hemos enviado un código de 6 dígitos a tu correo electrónico registrado.</p>
                                
                                <div class="otp-wrapper d-flex justify-content-center gap-2 mb-4">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                    <input type="text" class="form-control otp-input text-center fw-bold fs-4" maxlength="1" style="width: 45px; height: 50px;">
                                </div>

                                <div id="otp_message_error"></div>
                            </div>
                            <div class="modal-footer border-0 pb-4">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary px-4" id="btnVerifyOtp">Confirmar Código</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="js/auth/perfil.js"></script>
<?= $this->endSection() ?>