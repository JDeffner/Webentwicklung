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
$routes->get('/', 'Benutzer::index');
$routes->get('/benutzer/erstellen', 'Benutzer::getBenutzerErstellen');
$routes->post('/benutzer/erstellen', 'Benutzer::postBenutzerErstellen');
$routes->get('/benutzer/anmelden', 'Benutzer::getBenutzerAnmelden');
$routes->get('/benutzer/(:num)', 'Benutzer::getBenutzer/$1');

//task routes
$routes->get('/tasks', 'TaskBoard::index/1');
$routes->get('/tasks/(:num)', 'TaskBoard::index/$1');
$routes->get('/tasks/erstellen', 'TaskBoard::getTaskErstellen');
$routes->post('/tasks/erstellen', 'TaskBoard::postTaskErstellen');
$routes->post('/tasks/loeschen/(:num)', 'TaskBoard::postTaskLoeschen/$1');
$routes->get('/tasks/bearbeiten/(:num)', 'TaskBoard::getTaskBearbeiten/$1');
$routes->post('/tasks/bearbeiten/(:num)', 'TaskBoard::postTaskBearbeiten/$1');

//spalten routes
$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/erstellen', 'Spalten::getSpalteErstellen');

//board routes
$routes->get('/boards', 'Boards::index');

// Admin routes
$routes->get('/dashboard', 'Admin::index');

// Developer routes
$routes->get('/welcome', 'Developer::index');
$routes->get('/test/(:any)', 'Developer::test/$1');
$routes->get('(:any)/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/viewGruppennummer', 'Developer::viewGruppennummer');
$routes->get('/testDatabase', 'Developer::testDatabase');
$routes->get('/login', 'Developer::abweisung');


