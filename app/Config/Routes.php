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
        
        // Trip routes
        $routes->get('trip', 'TripController::index');
        $routes->get('trip/create', 'TripController::create');
        $routes->post('trip/store', 'TripController::store');
        $routes->get('trip/(:num)', 'TripController::show/$1');
        $routes->get('trip/edit/(:num)', 'TripController::edit/$1');
        $routes->post('trip/update/(:num)', 'TripController::update/$1');
        $routes->get('trip/delete/(:num)', 'TripController::delete/$1');
        
        // Analytics routes
        $routes->get('analytics', 'AnalyticsController::index');
        $routes->get('analytics/getAnalyticsData', 'AnalyticsController::getAnalyticsData');

        // Trip Calculator routes untuk user biasa
        $routes->get('trip_calculator', 'TripCalculatorController::index');
        $routes->post('trip_calculator/calculate', 'TripCalculatorController::calculate');
        $routes->post('trip_calculator/save', 'TripCalculatorController::saveCalculation');
        $routes->get('trip_calculator/getCars', 'TripCalculatorController::getCars');  
        $routes->get('api/cars/(:num)?', 'RentCarController::getCarData/$1');         
        
        // Admin routes
        $routes->group('admin', ['filter' => 'auth_kerlyn', 'admin'], function($routes) {
            // Admin Wisata routes
            $routes->get('wisata', 'WisataController::admin');
            $routes->get('wisata/create', 'WisataController::create');
            $routes->post('wisata/store', 'WisataController::store');
            $routes->get('wisata/edit/(:num)', 'WisataController::edit/$1');
            $routes->post('wisata/update/(:num)', 'WisataController::update/$1');
            $routes->get('wisata/delete/(:num)', 'WisataController::delete/$1');

            // Admin Trip routes (view only)
            $routes->get('trip', 'TripController::adminIndex'); // Menampilkan semua trip
            $routes->get('trip/(:num)', 'TripController::adminShow/$1'); // Detail trip

            // Admin Trip Calculator routes
            $routes->get('trip_statistics', 'TripCalculatorController::statistics');
        });
    });
});

// Ammar's Microservice Routes
$routes->group('ammar', function($routes) {
    // Auth routes (tidak perlu auth)
    $routes->get('/', 'LoginController::indexA');
    $routes->get('loginA', 'LoginController::indexA');
    $routes->post('login_actionA', 'LoginController::login_actionA');
    $routes->get('registerA', 'RegisterController::registerA');
    $routes->post('register_actionA', 'RegisterController::register_actionA');
    $routes->get('logout', 'LoginController::logout');

     // API Routes (tidak perlu auth)
     $routes->get('api/cars', 'RentCarController::getCarData');
     $routes->get('api/cars/(:num)', 'RentCarController::getCarData/$1');

    // Routes yang memerlukan autentikasi
    $routes->group('', ['filter' => 'auth_ammar'], function($routes) {
        $routes->get('/', 'Home::indexA');
        $routes->get('dashboardA', 'DashboardController::indexA');
        $routes->get('rent-cars', 'RentCarController::indexA');
        $routes->get('vendors', 'VendorController::indexA');
        $routes->get('recommendationsA', 'RecommendationController::indexA');
    });
});

