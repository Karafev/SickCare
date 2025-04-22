<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);
$routes->post('/userctl/login', 'UserCtl::login');
$routes->post('/userctl/register', 'UserCtl::register');
$routes->get('/userctl/details', 'UserCtl::details');

$routes->post('/api/login', 'UserCtl::login');


$routes->post('/api/register', 'UserCtl::register');
$routes->get('/api/register', 'UserCtl::register');

$routes->post('/api/details', 'UserCtl::details');
$routes->get('/api/details', 'UserCtl::details');


$routes->get('/', 'Home::index');
$routes->get('/sickcares', 'Recettes::index');
$routes->post('/sickcares', 'Recettes::index');
$routes->get('/sickcares/create', 'Recettes::create');
$routes->post('/sickcares/create', 'Recettes::create');
$routes->get('/create', 'Recettes::create');
$routes->post('/create', 'Recettes::create');
$routes->get('/sickcares/delete/(:num)', 'Recettes::delete/$1');
$routes->post('/sickcares/delete/(:num)', 'Recettes::delete/$1');


$routes->get('/', 'ConnexionController::index');
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/traiteInscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/traiteConnexion', 'ConnexionController::traiteConnexion');
$routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
$routes->get('/deconnexion', 'DeconnexionController::index', ['filter' => 'authGuard']);
$routes->get('/utilisateurs', 'Users::index', ['filter' => 'authGuard']);
$routes->get('/Users', 'Users::index', ['filter' => 'authGuard']);
$routes->get('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'authGuard']);
$routes->post('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'authGuard']);
$routes->get('/maladies', 'Maladies::index', ['filter' => 'authGuard']);
$routes->get('/Maladies', 'Maladies::index', ['filter' => 'authGuard']);
$routes->get('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'authGuard']);
$routes->post('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'authGuard']);
$routes->get('sickcares/search', 'Recettes::search');
$routes->post('sickcares/search', 'Recettes::search');
$routes->get('maladies/edit/(:num)', 'Maladies::edit/$1');
$routes->post('maladies/update/(:num)', 'Maladies::update/$1');
$routes->get('/dashboard', 'Dashboard::index');


$routes->post('recettes/toggle-filter', 'Recettes::toggleFilter');

$routes->get('profile', 'ProfileController::index');
$routes->get('profile/edit', 'ProfileController::edit');
$routes->post('profile/update', 'ProfileController::update');

