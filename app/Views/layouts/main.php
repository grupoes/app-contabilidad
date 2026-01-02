<!doctype html>
<html lang="en" data-bs-theme="blue-theme">


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/pages-starter-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 16:58:35 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GRUPO ES</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/grupoesicon.ico" type="image/x-icon">
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet">
    <script src="assets/js/pace.min.js"></script>

    <!--plugins-->
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/simplebar/css/simplebar.css">
    <!--bootstrap css-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="sass/main.css" rel="stylesheet">
    <link href="sass/dark-theme.css" rel="stylesheet">
    <link href="sass/blue-theme.css" rel="stylesheet">
    <link href="sass/semi-dark.css" rel="stylesheet">
    <link href="sass/bordered-theme.css" rel="stylesheet">
    <link href="sass/responsive.css" rel="stylesheet">

</head>

<body>

    <!--start header-->
    <header class="top-header">
        <?= $this->include('layouts/header') ?>
    </header>
    <!--end top header-->


    <!--start sidebar-->
    <aside class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="logo-icon">
                <img src="assets/images/logo_light.png" class="logo-img" alt="">
            </div>
            <div class="logo-name flex-grow-1">
                <h5 class="mb-0">Grupo Es</h5>
            </div>
            <div class="sidebar-close">
                <span class="material-icons-outlined">close</span>
            </div>
        </div>
        <div class="sidebar-nav">
            <!--navigation-->
            <?= $this->include('layouts/menu') ?>
            <!--end navigation-->
        </div>
    </aside>
    <!--end sidebar-->

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <?= $this->renderSection('content') ?>

        </div>
    </main>
    <!--end main wrapper-->


    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->


    <!--start footer-->
    <footer class="page-footer">
        <?= $this->include('layouts/footer') ?>
    </footer>
    <!--top footer-->

    <!--start cart-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
        <div class="offcanvas-header border-bottom h-70">
            <h5 class="mb-0" id="offcanvasRightLabel">8 New Orders</h5>
            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
                <i class="material-icons-outlined">close</i>
            </a>
        </div>
        <div class="offcanvas-body p-0">
            <div class="order-list">
                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/01.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">White Men Shoes</h5>
                        <p class="mb-0 order-price">$289</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/02.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Red Airpods</h5>
                        <p class="mb-0 order-price">$149</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/03.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Men Polo Tshirt</h5>
                        <p class="mb-0 order-price">$139</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/04.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Blue Jeans Casual</h5>
                        <p class="mb-0 order-price">$485</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/05.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Fancy Shirts</h5>
                        <p class="mb-0 order-price">$758</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/06.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Home Sofa Set </h5>
                        <p class="mb-0 order-price">$546</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/07.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Black iPhone</h5>
                        <p class="mb-0 order-price">$1049</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>

                <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="order-img">
                        <img src="assets/images/orders/08.png" class="img-fluid rounded-3" width="75" alt="">
                    </div>
                    <div class="order-info flex-grow-1">
                        <h5 class="mb-1 order-title">Goldan Watch</h5>
                        <p class="mb-0 order-price">$689</p>
                    </div>
                    <div class="d-flex">
                        <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                        <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer h-70 p-3 border-top">
            <div class="d-grid">
                <button type="button" class="btn btn-grd btn-grd-primary" data-bs-dismiss="offcanvas">View Products</button>
            </div>
        </div>
    </div>
    <!--end cart-->

    <!--bootstrap js-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <!--plugins-->
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/metismenu/metisMenu.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/pages-starter-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Jul 2024 16:58:35 GMT -->

</html>