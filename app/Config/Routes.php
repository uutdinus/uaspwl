<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'DashboardController::index');

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/produk', 'ProdukController::index');
    $routes->post('/produk/store', 'ProdukController::store');
    $routes->post('/produk/update', 'ProdukController::update');
    $routes->get('/logout', 'LoginController::logout');
    $routes->post('produk/update', 'ProdukController::update');
    $routes->get('produk/delete/(:num)', 'ProdukController::delete/$1');
    $routes->get('/produk/cetakpdf', 'ProdukController::cetakPDF');
    $routes->get('/checkout', 'CheckoutController::index');
    $routes->get('/checkout/getCities/(:num)', 'CheckoutController::getCities/$1');
    $routes->post('/checkout/getCost', 'CheckoutController::getCost');
    $routes->post('/checkout/getCostOptions', 'CheckoutController::getCostOptions');
    $routes->post('/order/create', 'OrderController::create');
    $routes->get('/order/success', 'OrderController::success');
    $routes->post('transaksi/update_status', 'TransaksiController::update_status');
    $routes->get('transaksi/print_pdf', 'TransaksiController::print_pdf');


});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'CartController::index');
    $routes->post('add', 'CartController::cart_add');
    $routes->post('edit', 'CartController::cart_edit');
    $routes->get('delete/(:any)', 'CartController::cart_delete/$1');
    $routes->get('clear', 'CartController::cart_clear');
});


$routes->get('/transaksi', 'TransaksiController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/create', 'RegisterController::create');