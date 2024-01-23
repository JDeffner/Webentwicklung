<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Default route Setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('BenutzerController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//login routes
$routes->get('/', 'BenutzerController::index');
$routes->get('/benutzer/erstellen', 'BenutzerController::getBenutzerErstellen');
$routes->post('/benutzer/erstellen', 'BenutzerController::postBenutzerErstellen');
$routes->post('/benutzer/anmelden', 'BenutzerController::postBenutzerAnmelden');
$routes->get('/gast', 'BenutzerController::getGastAnmelden');

//protected routes
$routes->group('', ['filter' => 'userAuth'], function($routes) {
    //benutzer routes
    $routes->get('/benutzer/(:num)', 'BenutzerController::getBenutzer/$1');

    //task routes
    $routes->get('/tasks', 'TasksController::index/1');
    $routes->get('/tasks/(:num)', 'TasksController::index/$1');
    $routes->post('/tasks/erstellen', 'TasksController::postTaskErstellen');
    $routes->post('/tasks/loeschen/(:num)/(:num)', 'TasksController::postTaskLoeschen/$1/$2');
    $routes->post('/tasks/bearbeiten/(:num)', 'TasksController::postTaskBearbeiten/$1');

    //spalten routes
    $routes->get('/spalten', 'SpaltenController::index');
    $routes->post('/spalten/erstellen', 'SpaltenController::postSpalteErstellen');
    $routes->post('/spalten/bearbeiten/(:num)', 'SpaltenController::postSpalteBearbeiten/$1');
    $routes->post('/spalten/loeschen/(:num)', 'SpaltenController::postSpalteLoeschen/$1');

    //board routes
    $routes->get('/boards', 'BoardsController::index');
    $routes->get('/boards/raw', 'BoardsController::getRawData');
    $routes->post('/boards/erstellen', 'BoardsController::postBoardErstellen');
    $routes->post('/boards/bearbeiten/(:num)', 'BoardsController::postBoardBearbeiten/$1');
    $routes->post('/boards/loeschen/(:num)', 'BoardsController::postBoardLoeschen/$1');

    // Error routes
    $routes->get('/denied', 'Error::index');

    $routes->group('', ['filter' => 'adminAuth'], function($routes) {
        // Admin routes
        $routes->get('/dashboard', 'Admin::index');

        // Developer routes
        $routes->get('/welcome', 'Developer::index');
        $routes->get('/test/(:any)', 'Developer::test/$1');
        $routes->get('(:any)/viewGruppennummer', 'Developer::viewGruppennummer');
        $routes->get('/viewGruppennummer', 'Developer::viewGruppennummer');
        $routes->get('/testDatabase', 'Developer::testDatabase');
        $routes->get('/login', 'Developer::abweisung');
    });
    
});


