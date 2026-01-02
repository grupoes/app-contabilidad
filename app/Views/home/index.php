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

<div class="row">
    <div class="col-12 col-lg-4 col-xxl-4 d-flex">
        <div class="card rounded-4 w-100 cursor-pointer">
            <div class="card-body">
                <div class="">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h5 class="mb-0">GRUPO ES CONSULTORES SOCIEDAD ANONIMA</h5>
                    </div>
                    <p class="mb-2">20601589651</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="mb-3">Jr Colon 566 - Tarapoto - San Martin - San Martin</p>
                        </div>
                        <img src="assets/images/apps/store.png" width="100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>