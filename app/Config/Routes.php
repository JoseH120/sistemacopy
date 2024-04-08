<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
   //http://localhost/sistema/api/estudiantes
   $routes->get('estudiantes', 'Estudiantes::index');


   //http://localhost/sistema/api/tutores
   $routes->get('tutores', 'Tutores::index');

   //http://localhost/sistema/api/tutores/create
   $routes->post('tutores/create', 'Tutores::create');

   //http://localhost/sistema/api/tutores/edit
   $routes->get('tutores/edit/(:num)', 'Tutores::edit/$1');

   //http://localhost/sistema/api/tutores/update
   $routes->put('tutores/update/(:num)', 'Tutores::update/$1');

   //http://localhost/sistema/api/tutores/delete
   $routes->delete('tutores/delete/(:num)', 'Tutores::delete/$1');


   //URI PARA CONTROLADO DE CURSOS

   //http://localhost/sistema/api/cursos/index
   $routes->get('cursos', 'Cursos::index');

   //http://localhost/sistema/api/cursos/create
   $routes->post('cursos/create', 'Cursos::create');

   //http://localhost/sistema/api/cursos/edit/
   $routes->get('cursos/edit/(:num)', 'Cursos::edit/$1');

   //http://localhost/sistema/api/cursos/update/
   $routes->put('cursos/update/(:num)', 'Cursos::update/$1');

   //http://localhost/sistema/api/cursos/delete/
   $routes->delete('cursos/delete/(:num)', 'Cursos::delete/$1');
});
