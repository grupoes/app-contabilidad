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
        <div class="card rounded-4 cursor-pointer" onclick="pdtRenta()">
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
        <div class="card rounded-4 cursor-pointer" onclick="pdtPlame()">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-48 d-flex bg-primary text-primary bg-opacity-10 align-items-center justify-content-center rounded-circle">
                        <span class="material-icons-outlined">library_books</span>
                    </div>
                    <div class="">
                        <h4 class="mb-0">PDT PLAME</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col" id="pdtanual" hidden>
        <div class="card rounded-4 cursor-pointer" onclick="pdtAnual()">
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

<div class="col-lg-12 col-xxl-8 d-flex align-items-stretch">
    <div class="card w-100 rounded-4">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="">
                    <h5 class="mb-0">Análisis de Movimientos</h5>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success" onclick="descargarExcel()">Excel</button>
                    <select class="form-select w-auto" id="year">
                    </select>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table align-middle" id="tableAnalisisMovimientos">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Ventas Gravadas</th>
                            <th>Ventas No Gravadas</th>
                            <th>Total Ventas</th>
                            <th>Compras Gravadas</th>
                            <th>Compras No Gravadas</th>
                            <th>Total Compras</th>
                        </tr>
                    </thead>
                    <tbody id="tableMovimientos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Correo Electrónico -->
<div class="modal fade" id="modalCorreo" tabindex="-1" aria-labelledby="modalCorreoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCorreoLabel">Agrega el correo electrónico para después recuperar su contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCorreo">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="<?= session()->get('id_usuario') ?>">
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="emailInput" name="emailInput" placeholder="correo@ejemplo.com" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnGuardarCorreo">Guardar Correo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>assets/plugins/notifications/js/lobibox.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/notifications/js/notifications.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>js/home/contribuyente.js"></script>
<?= $this->endSection() ?>