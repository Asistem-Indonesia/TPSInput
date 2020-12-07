<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/auth', 'Auth::index', ['filter' => 'auth']);
$routes->post('/login', 'Auth::login', ['filter' => 'auth']);
$routes->get('/logout', 'Auth::logout');

// Route for admin
$routes->get('/admin', 'Admin::index', ['filter' => 'access']);

// Route for menu users
$routes->get('/users', 'Users::index', ['filter' => 'access']);
$routes->get('/users/index', 'Kelurahan::index', ['filter' => 'access']);
$routes->post('/users/create', 'Users::create', ['filter' => 'access']);
$routes->get('/users/(:any)/edit', 'Users::edit/$1', ['filter' => 'access']);
$routes->post('/users/update', 'Users::update', ['filter' => 'access']);
$routes->post('/users/delete', 'Users::delete', ['filter' => 'access']);
$routes->post('/users/changePassword', 'Users::changepassword', ['filter' => 'access']);

// Route for menu kecamatan
$routes->get('/kecamatan', 'Kecamatan::index', ['filter' => 'access']);
$routes->get('/kecamatan/index', 'Kelurahan::index', ['filter' => 'access']);
$routes->post('/kecamatan/create', 'Kecamatan::create', ['filter' => 'access']);
$routes->get('/kecamatan/(:any)/edit', 'Kecamatan::edit/$1', ['filter' => 'access']);
$routes->post('/kecamatan/update', 'Kecamatan::update', ['filter' => 'access']);
$routes->post('/kecamatan/delete', 'Kecamatan::delete', ['filter' => 'access']);


// Route for menu Kelurahan
$routes->get('/kelurahan', 'Kelurahan::index', ['filter' => 'access']);
$routes->get('/kelurahan/index', 'Kelurahan::index', ['filter' => 'access']);
$routes->post('/kelurahan/create', 'Kelurahan::create', ['filter' => 'access']);
$routes->get('/kelurahan/(:any)/edit', 'Kelurahan::edit/$1', ['filter' => 'access']);
$routes->post('/kelurahan/update', 'Kelurahan::update', ['filter' => 'access']);
$routes->post('/kelurahan/delete', 'Kelurahan::delete', ['filter' => 'access']);

//Route for TPS 
$routes->get('/tps', 'Tps::index', ['filter' => 'access']);
$routes->get('/tps/index', 'Tps::index');
$routes->get('/tps/create', 'Tps::create');
$routes->post('/tps/create', 'Tps::create');
$routes->get('/tps/(:any)/edit', 'Tps::edit/$1');
$routes->post('/tps/update', 'Tps::update');
$routes->post('/tps/delete', 'Tps::delete');


//Route for Paslon
$routes->get('/paslon', 'Paslon::index', ['filter' => 'access']);
$routes->post('/paslon', 'Paslon::create', ['filter' => 'access']);

//Route 
$routes->get('/inputdata/(:num)', 'InputData::index/$1', ['filter' => 'accessInputData']);
$routes->post('/inputdata/update', 'InputData::update');


$routes->get('/', 'Auth::index', ['filter' => 'auth']);

//REST API
$routes->get('/api/paslon', 'APIPaslon::index');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
