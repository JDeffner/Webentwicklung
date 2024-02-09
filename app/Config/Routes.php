<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//login routes (unprotected)
$routes->get('/', function() {
    return redirect()->to('/anmelden');
});
$routes->get('anmelden', 'BenutzerController::index');
$routes->get('benutzer/erstellen', 'BenutzerController::getBenutzerErstellen');
$routes->post('benutzer/erstellen', 'BenutzerController::postBenutzerErstellen');
$routes->post('benutzer/anmelden', 'BenutzerController::postBenutzerAnmelden');
$routes->get('benutzer/gast', 'BenutzerController::getGastAnmelden');
$routes->get('login', 'Admin\AdminController::abweisung'); // used for expired project


//protected routes

//benutzer routes
$routes->get('profil', 'BenutzerController::getBenutzerProfil');
$routes->get('willkommen', 'BenutzerController::getBenutzerWillkommen');

//task routes
$routes->group('tasks', function($routes) {
    $routes->get('/', 'TasksController::index');
    $routes->get('raw', 'TasksController::getRawData');
    $routes->post('raw/(:num)', 'TasksController::getRawDataBoard/$1');
    $routes->post('erstellen', 'TasksController::postTaskErstellen');
    $routes->post('loeschen/(:num)', 'TasksController::postTaskLoeschen/$1');
    $routes->post('bearbeiten/(:num)', 'TasksController::postTaskBearbeiten/$1');
    $routes->post('bearbeiten/spalte/(:num)/(:num)', 'TasksController::postTaskSpalteBearbeiten/$1/$2');
    $routes->post('bearbeiten/sortids', 'TasksController::postTaskSortidsBearbeiten');
    $routes->post('task/(:num)', 'TasksController::postTaskInfo/$1');
});

//spalten routes
$routes->group('spalten', function($routes) {
    $routes->get('/', 'SpaltenController::index');
    $routes->get('raw', 'SpaltenController::getRawData');
    $routes->post('erstellen', 'SpaltenController::postSpalteErstellen');
    $routes->post('bearbeiten/(:num)', 'SpaltenController::postSpalteBearbeiten/$1');
    $routes->post('loeschen/(:num)', 'SpaltenController::postSpalteLoeschen/$1');
    $routes->post('spalte/(:num)', 'SpaltenController::postSpaltenInfo/$1');
});

//board routes
$routes->group('boards', function($routes) {
    $routes->get('/', 'BoardsController::index');
    $routes->get('raw', 'BoardsController::getRawData');
    $routes->post('erstellen', 'BoardsController::postBoardErstellen');
    $routes->post('bearbeiten/(:num)', 'BoardsController::postBoardBearbeiten/$1');
    $routes->post('loeschen/(:num)', 'BoardsController::postBoardLoeschen/$1');
    $routes->post('board/(:num)', 'BoardsController::postBoardInfo/$1');
});

// Error routes
$routes->get('denied', 'ErrorController::index');

// Show Gruppennummer
$routes->get('(:any)/gruppennummer', 'AdminController::viewGruppennummer');
$routes->get('gruppennummer', 'AdminController::viewGruppennummer');

// Protected Admin routes
$routes->group('/', ['filter' => 'adminAuthentification', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('admin/personen', 'PersonenController::getPersonen');
    $routes->get('admin/personen/raw', 'PersonenController::getPersonenRawData');
    // no "/admin" since the handleCRUD in main.js is standarzied to "/" for all routes
    $routes->post('personen/bearbeiten/(:num)', 'PersonenController::postPersonBearbeiten/$1');
    $routes->post('personen/loeschen/(:num)', 'PersonenController::postPersonLoeschen/$1');
    $routes->post('personen/person/(:num)', 'PersonenController::postPersonInfo/$1');


    $routes->get('admin/taskarten', 'TaskartenController::getTaskarten');
    $routes->get('admin/taskarten/raw', 'TaskartenController::getTaskartenRawData');
    // no "/admin" since the handleCRUD in main.js is standarzied to "/" for all routes
    $routes->post('taskarten/erstellen', 'TaskartenController::postTaskartErstellen');
    $routes->post('taskarten/bearbeiten/(:num)', 'TaskartenController::postTaskartBearbeiten/$1');
    $routes->post('taskarten/loeschen/(:num)', 'TaskartenController::postTaskartLoeschen/$1');
    $routes->post('taskarten/taskart/(:num)', 'TaskartenController::postTaskartenInfo/$1');

    $routes->get('admin/tasks', 'TasksController::getTasks');

    $routes->get('welcome', 'AdminController::index');
    $routes->get('test', 'AdminController::test');
});




