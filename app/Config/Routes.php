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
