<?php
use CodeIgniter\Router\RouteCollection;
/**
* @var RouteCollection $routes
*/
$routes->SetAutoRoute(false);
$routes->get('/', 'Home::index');
$routes->get('/sickcares', 'Recettes::index');
$routes->post('/sickcares', 'Recettes::index');
$routes->get('/sickcares/create', 'Recettes::create');
$routes->post('/sickcares/create', 'Recettes::create');
$routes->get('/create', 'Recettes::create');
$routes->post('/create', 'Recettes::create');
$routes->get('/sickcares/delete/(:num)', 'Recettes::delete/$1');
$routes->post('/sickcares/delete/(:num)', 'Recettes::delete/$1');
$routes->get('/WebServiceControlleur/getRecette', 'WebServiceControlleur::getRecette'); // Recette route
$routes->get('/WebServiceControlleur/getComposer', 'WebServiceControlleur::getComposer'); // Recette route
$routes->get('/WebServiceControlleur/getAliments', 'WebServiceControlleur::getAliments'); // Recette route

$routes->get('/', 'ConnexionController::index');
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/traiteInscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/traiteConnexion', 'ConnexionController::traiteConnexion');
$routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
$routes->get('admin-dashboard', 'AdminController::dashboard');


$routes->get('/deconnexion', 'DeconnexionController::index', ['filter' => 'authGuard']);

$routes->get('/utilisateurs', 'Users::index', ['filter' => 'authGuard']);
$routes->get('/', 'Users::Users', ['filter' => 'authGuard']); 
$routes->get('/Users', 'Users::index', ['filter' => 'authGuard']);
$routes->get('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'authGuard']);
$routes->post('/utilisateurs/delete/(:num)', 'Users::delete/$1', ['filter' => 'authGuard']);

$routes->get('/maladies', 'Maladies::index', ['filter' => 'authGuard']);
$routes->get('/', 'Maladies::Maladies', ['filter' => 'authGuard']); 
$routes->get('/Maladies', 'Maladies::index', ['filter' => 'authGuard']);
$routes->get('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'authGuard']);
$routes->post('/maladies/delete/(:num)', 'Maladies::delete/$1', ['filter' => 'authGuard']);
