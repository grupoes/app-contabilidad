<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Inicio</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
    <div class="col">
        <div class="card rounded-4 cursor-pointer">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-48 d-flex bg-success text-success bg-opacity-10 align-items-center justify-content-center rounded-circle">
                        <span class="material-icons-outlined">collections_bookmark</span>
                    </div>
                    <div class="">
                        <h4 class="mb-0">PDT RENTA</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card rounded-4 cursor-pointer">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-48 d-flex bg-orange-light text-orange bg-opacity-10 align-items-center justify-content-center rounded-circle">
                        <span class="material-icons-outlined">bookmarks</span>
                    </div>
                    <div class="">
                        <h4 class="mb-0">PDT ANUAL</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="js/home/contribuyente.js"></script>
<?= $this->endSection() ?>