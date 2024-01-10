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
$routes->get('/tasks', 'TaskController::index');
$routes->get('/tasks/erstellen', 'TaskController::getTaskErstellen');
$routes->post('/tasks/erstellen', 'TaskController::postTaskErstellen');

$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/erstellen', 'Spalten::getSpalteErstellen');

$routes->get('/boards', 'Boards::index');

$routes->get('/newUser', 'Home::newUser');
$routes->post('/newUser', 'Home::newUser');

// Debug and admin routes
$routes->get('/dashboard', 'Admin::index');
$routes->get('/welcome', 'Welcome::index');
$routes->get('(:any)/viewGruppennummer', 'Welcome::viewGruppennummer');
$routes->get('/viewGruppennummer', 'Welcome::viewGruppennummer');
$routes->get('/testDatabase', 'Welcome::testDatabase');


