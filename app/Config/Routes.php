<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

//Api pour l'appli Android
$routes->post('/api/login', 'UserCtl::login');
$routes->post('/api/register', 'UserCtl::register');
$routes->get('/api/register', 'UserCtl::register');
$routes->post('/api/details', 'UserCtl::details');
$routes->get('/api/details', 'UserCtl::details');

//Routes pour le home
$routes->get('/', 'Recettes::index');
$routes->get('/sickcares', 'Recettes::index');
$routes->post('/sickcares', 'Recettes::index');
//Routes pour la créetion de recette
$routes->get('/sickcares/create', 'Recettes::create');
$routes->post('/sickcares/create', 'Recettes::create');
$routes->get('/create', 'Recettes::create');
$routes->post('/create', 'Recettes::create');
//Routes pour supprimez des recettes
$routes->get('/sickcares/delete/(:num)', 'Recettes::delete/$1');
$routes->post('/sickcares/delete/(:num)', 'Recettes::delete/$1');
//Routes pour l'inscription et la connexion des utilisateurs
$routes->get('/', 'ConnexionController::index');
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/traiteInscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/traiteConnexion', 'ConnexionController::traiteConnexion');

//Routes de deconnexion
$routes->get('/deconnexion', 'DeconnexionController::index', ['filter' => 'authGuard']);
//Routes de recehrche des recettes
$routes->get('sickcares/search', 'Recettes::search');
$routes->post('sickcares/search', 'Recettes::search');
//Filtres des utilisateurs 
$routes->post('recettes/toggle-filter', 'Recettes::toggleFilter');
//Routes pour que l'utilisateurs puisse visionner son profile et modif son profile
$routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
$routes->get('profile/edit', 'ProfileController::edit');
$routes->post('profile/update', 'ProfileController::update');
//Routes pour que l'admin puisse gérez les maladies et les aliment associé aux maladies
$routes->get('/maladies', 'Maladies::index', ['filter' => 'adminGuard']);
$routes->get('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'adminGuard']);
$routes->post('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'adminGuard']);
$routes->get('maladies/edit/(:num)', 'Maladies::edit/$1', ['filter' => 'adminGuard']);
$routes->post('maladies/update/(:num)', 'Maladies::update/$1',['filter' => 'adminGuard']);
//L'amdin peut gérez les utilisateurs
$routes->get('/utilisateurs', 'Users::index', ['filter' => 'adminGuard']);
$routes->get('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'adminGuard']);
$routes->post('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'adminGuard']);