<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<link href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<style>
    #tablePersonal td, #tablePersonal th {
        white-space: normal !important;
        word-wrap: break-word;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Personal</div>
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
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3 gap-3">
            <h5 class="mb-0">Listado de Personal</h5>
            <div class="ms-auto position-relative">
                <input type="text" id="searchPersonal" class="form-control ps-5" placeholder="Buscar personal...">
                <span class="material-icons-outlined position-absolute start-0 top-50 translate-middle-y ms-3">search</span>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tablePersonal" class="table align-middle mb-0 table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Número Documento</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>
<script src="<?= base_url() ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url() ?>js/personal/index.js"></script>
<?= $this->endSection() ?>