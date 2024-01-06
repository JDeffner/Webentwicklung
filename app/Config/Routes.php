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
$routes->get('/spalten', 'Spalten::index');
$routes->get('/spalten/erstellen', 'Spalten::getSpalteErstellen');
$routes->get('/boards', 'Boards::index');
$routes->get('/welcome', 'Welcome::index');
$routes->get('(:any)/viewGruppennummer', 'Welcome::viewGruppennummer');
$routes->get('/testDatabase', 'Welcome::testDatabase');

$routes->get('/newUser', 'Home::NewUser');
$routes->post('/newUser', 'Home::NewUser');