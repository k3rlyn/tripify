<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

// Root route dan auth routes dengan filter guest (hanya bisa diakses jika belum login)
$routes->group('', ['filter' => 'guest'], function($routes) {
    // Root route mengarah ke login
    $routes->get('/', 'AuthAPIController::login_view');
    
    // Auth routes
    $routes->get('login', 'AuthAPIController::login_view');
    $routes->post('login_action', 'AuthAPIController::login_action');
    $routes->get('register', 'AuthAPIController::register_view');
    $routes->post('register_action', 'AuthAPIController::register_action');
});

// Logout route (bisa diakses kapan saja)
$routes->get('logout', 'AuthAPIController::logout');

// Routes yang memerlukan autentikasi
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Route index untuk user biasa
    $routes->get('index', 'UserController::index');
    
    // Wisata routes untuk user biasa
    $routes->get('wisata', 'WisataController::index');
    $routes->get('wisata/rate/(:num)', 'WisataController::rate/$1');
    $routes->post('wisata/submit-rating', 'WisataController::submitRating');

    // Analytics route (tambahkan di sini)
    $routes->get('analytics', 'AnalyticsController::index');
    $routes->get('analytics/getAnalyticsData', 'AnalyticsController::getAnalyticsData'); // Route untuk API data
});

// Routes khusus admin (memerlukan auth dan admin filter)
$routes->group('admin', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('wisata', 'WisataController::admin');
    $routes->get('wisata/create', 'WisataController::create');
    $routes->post('wisata/store', 'WisataController::store');
    $routes->get('wisata/edit/(:num)', 'WisataController::edit/$1');
    $routes->post('wisata/update/(:num)', 'WisataController::update/$1');
    $routes->get('wisata/delete/(:num)', 'WisataController::delete/$1');
});

