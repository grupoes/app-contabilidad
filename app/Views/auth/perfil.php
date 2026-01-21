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

<div class="card rounded-4">
    <div class="card-body p-4">
        <div class="position-relative mb-5">
            <img src="assets/images/gallery/profile-cover.html" class="img-fluid rounded-4 shadow" alt="">
            <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                <img src="assets/images/avatars/01.png" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
            </div>
        </div>
        <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
            <div class="">
                <h3>Jhon Deo</h3>
                <p class="mb-0">Engineer at BB Agency Industry<br>
                    New York, United States</p>
            </div>
        </div>
        <div class="kewords d-flex align-items-center gap-3 mt-4 overflow-x-auto">
            <button type="button" class="btn btn-sm btn-light rounded-5 px-4">UX Research</button>
            <button type="button" class="btn btn-sm btn-light rounded-5 px-4">CX Strategy</button>
            <button type="button" class="btn btn-sm btn-light rounded-5 px-4">Management</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="js/home/contribuyente.js"></script>
<?= $this->endSection() ?>