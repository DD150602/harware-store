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

$routes->get('/Sales', 'Sales::index');
$routes->get('/Sales/SalesDetails/(:num)', 'Sales::sales/$1');
$routes->post('/Sales/create/', 'Sales::create');