<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/auth/forgot-password', 'Auth::forgotPassword');
$routes->get('/auth/reset-password', 'Auth::resetPassword');
$routes->get('/auth/verify-code', 'Auth::verifyCode');
$routes->post('/auth/verify-code', 'Auth::verifyCodePost');
$routes->get('/auth/set-new-password', 'Auth::setNewPassword');
$routes->post('/auth/update-password', 'Auth::updatePassword');
$routes->post('auth/reset-password-link', 'Auth::resetPasswordLink');
$routes->get('auth/verify-user/(:any)', 'Auth::verifyUser/$1');

$routes->get('/home', 'Home::index');
$routes->get('/empresas', 'Home::empresas');
$routes->get('/empresa/boletas/(:any)', 'Home::listaBoletas/$1');
$routes->post('/home/listarBoletas', 'Home::listarBoletas');
$routes->get('/descargar-boleta/(:any)', 'Home::descargarBoleta/$1');
$routes->get('/previsualizar-boleta/(:any)', 'Home::previsualizarBoleta/$1');

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
$routes->get('/verify-correo', 'Home::verifyCorreo');
$routes->post('/save-correo', 'Home::saveCorreo');

$routes->get('/perfil', 'Auth::perfil');
$routes->post('/change-password', 'Auth::changePassword');

$routes->get('/obtener-analisis-movimientos/(:num)', 'Home::obtenerAnalisisMovimientos/$1');

$routes->get('/descargar-excel/(:num)', 'Home::descargarExcel/$1');

$routes->get('/administrador-archivos', 'FileManager::index');
$routes->get('/folders-months', 'FileManager::listFoldersMonths');
$routes->get('/filemanager/verify-year', 'FileManager::verifyYear');
$routes->post('/foldersAll', 'FileManager::folders');
$routes->get('/foldersMonths/(:any)', 'FileManager::foldersMonths/$1');
$routes->get('/loadFolderMonths/(:any)', 'FileManager::loadFolderMonths/$1');
$routes->get('/folders', 'FileManager::listFoldersFiles');

$routes->post('/create-folder', 'FileManager::createFolder');
$routes->get('/foldersFiles/(:any)', 'FileManager::foldersFiles/$1');

$routes->post('/upload-files', 'FileManager::uploadFiles');

$routes->get('/personal', 'Personal::index');
$routes->get('/get-lista-personal', 'Personal::getListaPersonal');
$routes->get('/reset-personal/(:num)', 'Personal::resetPersonal/$1');
