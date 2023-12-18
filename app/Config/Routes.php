<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Auth Routes
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/login', 'AuthController::processLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/auth/register', 'AuthController::processRegister');
$routes->get('/auth/logout', 'AuthController::processLogout');

// Pesanan Routes
$routes->get('/pesanan', 'PesananController::index', ['filter' => 'auth']);
$routes->post('/pesanan/create', 'PesananController::create', ['filter' => 'auth']);

// Review Routes
$routes->post('/reviews/create', 'ReviewController::create', ['filter' => 'auth']);
$routes->post('/reviews/update', 'ReviewController::update', ['filter' => 'auth']);
$routes->get('/reviews/(:num)', 'ReviewController::getReviewByPesananId/$1');

// API Routes
$routes->get('/api/user-insights', 'UserInsightsAPI::index');

// Frontend Routes
$routes->get('/furniture/(:num)', 'FurnitureController::detail/$1');
$routes->get('/furniture/search', 'FurnitureController::search', ['filter' => 'auth']);
$routes->get('/', 'FurnitureController::index', ['filter' => 'auth']);
