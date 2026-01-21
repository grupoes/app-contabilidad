<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pdt Renta</div>
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

<div class="row">
    <div class="card">
        <div class="card-body">
            <form id="formConsulta">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="anio" class="form-label">Año</label>
                        <select id="anio" name="anio" class="form-select" required>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tipoPdt" class="form-label">Tipo Pdt</label>
                        <select id="tipoPdt" name="tipoPdt" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success mt-4">Consultar</button>
                        <a href="<?= base_url('home') ?>" class="btn btn-danger mt-4">Regresar</a>
                    </div>
                </div>
            </form>

            <div class="row" id="tableConsulta">

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/home/pdtanual.js"></script>
<?= $this->endSection() ?>