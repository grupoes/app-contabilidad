<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/home', 'Home::index');
$routes->get('/empresas', 'Home::empresas');
$routes->get('/empresa/boletas/(:any)', 'Home::listaBoletas/$1');
$routes->post('/home/listarBoletas', 'Home::listarBoletas');
$routes->get('/descargar-boleta/(:any)', 'Home::descargarBoleta/$1');

$routes->get('/sello-firma', 'Configuracion::selloFirma');
$routes->post('/configuracion/uploadSelloFirma', 'Configuracion::uploadSelloFirma');
$routes->get('/configuracion/getSelloFirma', 'Configuracion::getSelloFirma');
$routes->post('/configuracion/transparenciaImagen', 'Configuracion::transparenciaImagen');

$routes->get('/getAniosAll', 'Configuracion::getAniosAll');

$routes->get('/pdt-renta', 'Home::pdtRenta');
$routes->post('/consulta-pdt-renta', 'Home::consultaPdtRenta');

$routes->get('/pdt-plame', 'Home::pdtPlame');
$routes->post('/consulta-pdt-plame', 'Home::consultaPdtPlame');

$routes->get('/pdt-anual', 'Home::pdtAnual');
$routes->get('/verificar-pdt-anual', 'Home::verificarPdtAnual');
$routes->post('/query-pdt-anual', 'Home::consultaPdtAnual');

$routes->get('/perfil', 'Auth::perfil');
$routes->post('/change-password', 'Auth::changePassword');

$routes->get('/obtener-analisis-movimientos/(:num)', 'Home::obtenerAnalisisMovimientos/$1');

$routes->get('/administrador-archivos', 'FileManager::index');
$routes->get('/folders', 'FileManager::listMonthsFolders');
