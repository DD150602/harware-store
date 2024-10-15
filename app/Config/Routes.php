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
