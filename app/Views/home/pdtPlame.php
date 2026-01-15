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
                            <option selected="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mes" class="form-label">Mes</label>
                        <select id="mes" name="mes" class="form-select" required>
                            <option selected="">Seleccione...</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
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
<script src="<?= base_url() ?>js/home/pdtplame.js"></script>
<?= $this->endSection() ?>