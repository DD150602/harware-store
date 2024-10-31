<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/login', 'Login::login');
$routes->get('/logout', 'Login::logout');

$routes->get('/Products', 'Products::index');
$routes->get('/Products/ProductDetails/(:num)', 'Products::product/$1');
$routes->post('/Products/update/', 'Products::update');
$routes->post('/Products/delete/(:num)', 'Products::delete/$1');

$routes->get('/Users', 'Users::index');
$routes->get('/Users/UserDetails/(:num)', 'Users::user/$1');
$routes->post('/Users/create/', 'Users::create');
$routes->post('/Users/update/(:num)', 'Users::update/$1');
$routes->post('/Users/delete/(:num)', 'Users::delete/$1');

$routes->get('/Sales', 'Sales::index');
$routes->get('/Sales/SalesDetails/(:num)', 'Sales::sales/$1');
$routes->get('/Sales/create', 'Sales::createView');
$routes->post('/Sales/create/newSale', 'Sales::create');
$routes->post('/Sales/clientInfo', 'Sales::clientInfo');

$routes->get('/Clients', 'Clients::index');
$routes->get('/Clients/ClientDetails/(:num)', 'Clients::client/$1');
$routes->post('/Clients/create', 'Clients::newClient');
$routes->post('/Clients/update', 'Clients::update');
$routes->post('/Clients/delete/(:num)', 'Clients::delete/$1');

$routes->get('/Purchases', 'Purchases::index');
$routes->get('/Purchases/PurchaseDetails/(:num)', 'Purchases::purchase/$1');
$routes->get('/Purchases/create', 'Purchases::createView');
$routes->post('/Purchases/create/newPurchase', 'Purchases::create');
$routes->post('/Purchases/purchaseInfo', 'Purchases::purchaseInfo');
