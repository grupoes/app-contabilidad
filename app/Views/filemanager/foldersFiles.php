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
    <div class="ms-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">Nuevo</button>
            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" style=""> <a class="dropdown-item" href="javascript:;" id="folderNew">Carpeta Nueva</a>
                <a class="dropdown-item" href="javascript:;" id="uploadFile">Subir Archivo</a>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="folderId" value="<?= isset($folderId) ? $folderId : '' ?>">

<div class="card">
    <div class="card-body">
        <div class="row g-3 row-cols-1 row-cols-lg-4" id="listFoldersFiles">

        </div><!--end row-->
    </div>
</div>

<div class="modal fade" id="modalFolder">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 py-2">
                <h5 class="modal-title">Carpeta Nueva</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <form id="formNewFolder">
                <div class="modal-body">
                    <input type="hidden" name="parentFolderId" id="parentFolderId" value="<?= isset($folderId) ? $folderId : '' ?>">
                    <input type="text" id="folderName" name="folderName" class="form-control" placeholder="Nombre de la carpeta">
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUploadFile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 py-2">
                <h5 class="modal-title">Subir Archivo</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <input type="hidden" name="folderParentId" id="folderParentId" value="<?= isset($folderId) ? $folderId : '' ?>">
                <input type="file" id="fileFolder" name="fileFolder" class="form-control">
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info">Subir</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>js/filemanager/foldersFiles.js"></script>
<?= $this->endSection() ?>