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

<input type="hidden" id="folderId" value="<?= isset($folderId) ? $folderId : '' ?>">

<div class="card">
    <div class="card-body">
        <div class="row g-3 row-cols-1 row-cols-lg-4" id="listMonths">

        </div><!--end row-->
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/filemanager/foldersFilesMonths.js"></script>
<?= $this->endSection() ?>