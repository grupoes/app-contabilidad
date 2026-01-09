<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Configuración</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sello y Firma</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 mx-auto mt-3">
        <h6 class="mb-0 text-uppercase">Subir imágen del sello y firma (.png)</h6>
        <hr>
        <div class="card">
            <div class="card-body">
                <form id="formSelloFirma" enctype="multipart/form-data">
                    <!-- Input File -->
                    <div class="mb-3">
                        <input id="fancy-file-upload" type="file" name="imagen" class="form-control" accept=".png, image/png">
                    </div>

                    <!-- Preview -->
                    <div id="previewContainer" class="mb-3 d-none text-center">
                        <img id="previewImage" class="img-fluid rounded-3 border" style="max-height: 300px;">
                    </div>

                    <!-- Botones -->
                    <div class="d-flex gap-2">
                        <button type="submit" id="btnGuardar" class="btn btn-primary" disabled>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/configuracion/selloFirma.js"></script>
<?= $this->endSection() ?>