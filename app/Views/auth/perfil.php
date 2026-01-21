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
                <form class="row g-4" id="formPassword">
                    <div class="col-12">
                        <label class="form-label" for="currentPassword">Contraseña Actual</label>
                        <input type="text" class="form-control" id="currentPassword" placeholder="Escribe su contraseña actual" name="currentPassword">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="NewPassword">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="Escribe la nueva contraseña">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="ConfirmPassword">Confirmar Contraseña</label>
                        <input type="password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirma la contraseña">
                    </div>

                    <div class="col-12" id="message_error">

                    </div>

                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-grd-info">Cambiar la Contraseña</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--end row-->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="js/auth/perfil.js"></script>
<?= $this->endSection() ?>