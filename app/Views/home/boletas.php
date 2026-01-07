<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Inicio</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Boletas de Pago</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="card rounded-4 w-100">
        <div class="card-body">
            <input type="hidden" id="rucEmpresa" value="<?= $ruc ?>">
            <h4><?= $empresa ?></h4>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="selectAnio" class="form-label">Año</label>
                    <select class="form-select" id="selectAnio">
                        <option value="0">Todos</option>
                        <?php foreach ($anios as $anio): ?>
                            <option value="<?= $anio['id_anio'] ?>"><?= $anio['anio_descripcion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="selectMes" class="form-label">Mes</label>
                    <select class="form-select" id="selectMes">
                        <option value="0">Todos</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>

            <div class="row" id="lista">


            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/home/boletas.js"></script>
<?= $this->endSection() ?>