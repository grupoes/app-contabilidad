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

$routes->get('/sello-firma', 'Configuracion::selloFirma');
$routes->post('/configuracion/uploadSelloFirma', 'Configuracion::uploadSelloFirma');
