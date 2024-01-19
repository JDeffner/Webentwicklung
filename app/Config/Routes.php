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

//Route Definitions
$routes->get('/', 'Home::index');
$routes->get('/tasks', 'TaskController::index/1');
$routes->get('/tasks/(:num)', 'TaskController::index/$1');
$routes->get('/tasks/erstellen', 'TaskController::getTaskErstellen');
$routes->post('/tasks/erstellen', 'TaskController::postTaskErstellen');
$routes->post('/tasks/loeschen/(:num)', 'TaskController::postTaskLoeschen/$1');
$routes->get('/tasks/bearbeiten/(:num)', 'TaskController::getTaskBearbeiten/$1');
$routes->post('/tasks/bearbeiten/(:num)', 'TaskController::postTaskBearbeiten/$1');

$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/erstellen', 'Spalten::getSpalteErstellen');

$routes->get('/boards', 'Boards::index');

$routes->get('/newUser', 'Home::newUser');
$routes->post('/newUser', 'Home::newUser');

// Admin routes
$routes->get('/dashboard', 'Admin::index');

// Developer routes
$routes->get('/welcome', 'Developer::index');
$routes->get('/test/(:any)', 'Developer::test/$1');
$routes->get('(:any)/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/testDatabase', 'Developer::testDatabase');
$routes->get('/login', 'Developer::abweisung');


