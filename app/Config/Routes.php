<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

// Root route sebagai landing page
$routes->get('/', 'Home::landingPage');
$routes->get('login', 'Home::landingPage');
$routes->get('index.php/login', 'Home::landingPage');
$routes->addRedirect('index.php', '/');

// Kerlyn's Microservice Routes
$routes->group('kerlyn', function($routes) {
    // Auth routes (tidak perlu auth)
    $routes->get('/', 'AuthAPIController::login_view'); 
    $routes->get('login', 'AuthAPIController::login_view');
    $routes->post('login_action', 'AuthAPIController::login_action');
    $routes->get('register', 'AuthAPIController::register_view');
    $routes->post('register_action', 'AuthAPIController::register_action');
    $routes->get('logout', 'AuthAPIController::logout');

    // Routes yang memerlukan autentikasi
    $routes->group('', ['filter' => 'auth_kerlyn'], function($routes) {
        $routes->get('index', 'UserController::index');
        
        // Wisata routes untuk user biasa
        $routes->get('wisata', 'WisataController::index');
        $routes->get('wisata/rate/(:num)', 'WisataController::rate/$1');
        $routes->post('wisata/submit-rating', 'WisataController::submitRating');
        
        // Analytics routes
        $routes->get('analytics', 'AnalyticsController::index');
        $routes->get('analytics/getAnalyticsData', 'AnalyticsController::getAnalyticsData');

        // Admin routes
        $routes->group('admin', ['filter' => 'admin'], function($routes) {
            $routes->get('wisata', 'WisataController::admin');
            $routes->get('wisata/create', 'WisataController::create');
            $routes->post('wisata/store', 'WisataController::store');
            $routes->get('wisata/edit/(:num)', 'WisataController::edit/$1');
            $routes->post('wisata/update/(:num)', 'WisataController::update/$1');
            $routes->get('wisata/delete/(:num)', 'WisataController::delete/$1');
        });
    });
});

// Ammar's Microservice Routes
$routes->group('ammar', function($routes) {
    // Auth routes (tidak perlu auth)
    $routes->get('/', 'LoginController::indexA');
    $routes->get('login', 'LoginController::indexA');
    $routes->post('login_action', 'LoginController::login_actionA');
    $routes->get('logout', 'LoginController::logout');

    // Routes yang memerlukan autentikasi
    $routes->group('', ['filter' => 'auth_ammar'], function($routes) {
        $routes->get('/', 'Home::indexA');
        $routes->get('dashboard', 'DashboardController::indexA');
        $routes->get('rent-cars', 'RentCarController::indexA');
        $routes->get('vendors', 'VendorController::indexA');
        $routes->get('recommendations', 'RecommendationController::indexA');
    });
});

