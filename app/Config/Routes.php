<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Default route Setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//login routes
$routes->get('/', 'BenutzerController::index');
$routes->get('/benutzer/erstellen', 'BenutzerController::getBenutzerErstellen');
$routes->post('/benutzer/erstellen', 'BenutzerController::postBenutzerErstellen');
$routes->get('/benutzer/anmelden', 'BenutzerController::getBenutzerAnmelden');
$routes->get('/benutzer/(:num)', 'BenutzerController::getBenutzer/$1');

//task routes
$routes->get('/tasks', 'TasksController::index/1');
$routes->get('/tasks/(:num)', 'TasksController::index/$1');
$routes->get('/tasks/erstellen', 'TasksController::getTaskErstellen');
$routes->post('/tasks/erstellen', 'TasksController::postTaskErstellen');
$routes->post('/tasks/loeschen/(:num)', 'TasksController::postTaskLoeschen/$1');
$routes->get('/tasks/bearbeiten/(:num)', 'TasksController::getTaskBearbeiten/$1');
$routes->post('/tasks/bearbeiten/(:num)', 'TasksController::postTaskBearbeiten/$1');

//spalten routes
$routes->get('/spalten', 'SpaltenController::index');
$routes->get('/spalten/erstellen', 'SpaltenController::getSpalteErstellen');

//board routes
$routes->get('/boards', 'BoardsController::index');

// Admin routes
$routes->get('/dashboard', 'Admin::index');

// Developer routes
$routes->get('/welcome', 'Developer::index');
$routes->get('/test/(:any)', 'Developer::test/$1');
$routes->get('(:any)/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/testDatabase', 'Developer::testDatabase');
$routes->get('/login', 'Developer::abweisung');


