<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//login routes
$routes->get('/', 'BenutzerController::index');
$routes->get('/benutzer/erstellen', 'BenutzerController::getBenutzerErstellen');
$routes->post('/benutzer/erstellen', 'BenutzerController::postBenutzerErstellen');
$routes->post('/benutzer/anmelden', 'BenutzerController::postBenutzerAnmelden');
$routes->get('/gast', 'BenutzerController::getGastAnmelden');

//protected routes
$routes->group('', ['filter' => 'loginAuthentification'], function($routes) {
    //benutzer routes
    $routes->get('/benutzer/(:num)', 'BenutzerController::getBenutzer/$1');

    //task routes
    $routes->get('/tasks', 'TasksController::index');
    $routes->post('/tasks/raw/(:num)', 'TasksController::getRawData/$1');
    $routes->post('/tasks/task/(:num)', 'TasksController::postTaskInfo/$1');
    $routes->post('/tasks/erstellen', 'TasksController::postTaskErstellen');
    $routes->post('/tasks/loeschen/(:num)', 'TasksController::postTaskLoeschen/$1');
    $routes->post('/tasks/bearbeiten/(:num)', 'TasksController::postTaskBearbeiten/$1');
    $routes->post('/tasks/bearbeiten/spalte/(:num)/(:num)', 'TasksController::postTaskSpalteBearbeiten/$1/$2');

    //spalten routes
    $routes->get('/spalten', 'SpaltenController::index');
    $routes->get('/spalten/raw', 'SpaltenController::getRawData');
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
    $routes->get('/denied', 'ErrorController::index');

    // Show Gruppennummer
    $routes->get('(:any)/gruppennummer', 'DeveloperController::viewGruppennummer');
    $routes->get('/gruppennummer', 'DeveloperController::viewGruppennummer');

    // Protected Admin and Developer routes
    $routes->group('', ['filter' => 'adminAuthentification'], function($routes) {
        $routes->get('/admin/personen', 'AdminController::index');
        $routes->get('/admin/personen/raw', 'AdminController::getPersonenRawData');
        $routes->post('/personen/person/(:num)', 'AdminController::postPersonInfo/$1');
        $routes->post('/personen/bearbeiten/(:num)', 'AdminController::postPersonBearbeiten/$1');
        $routes->post('/personen/loeschen/(:num)', 'AdminController::postPersonLoeschen/$1');


        $routes->get('/admin/taskarten', 'AdminController::getTaskarten');

        $routes->get('/welcome', 'DeveloperController::index');
        $routes->get('/test', 'DeveloperController::test');
    });

});

// other routes
$routes->get('/login', 'DeveloperController::abweisung');


