<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Configuración</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Administrador de Archivos</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 row-cols-1 row-cols-lg-4">
            <div class="col folder-year cursor-pointer" data-id="2026">
                <div class=" d-flex align-items-start gap-3 border p-3 rounded file-item">
                    <div class="detail-icon fs-3 text-warning">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <div class="detail-info">
                        <p class="fw-bold mb-1">Carpeta</p>
                        <p class="fw-bold mb-0">2026</p>
                    </div>
                </div>
            </div>

        </div><!--end row-->
    </div>
</div>

</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/filemanager/anios.js"></script>
<?= $this->endSection() ?>