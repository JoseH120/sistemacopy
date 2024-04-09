<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
   //URI PARA CONTROLADO DE ESTUDIANTES
   //http://localhost/sistema/api/estudiantes
   $routes->get('estudiantes', 'Estudiantes::index');

   //http://localhost/sistema/api/estudiantes/create
   $routes->post('estudiantes/create', 'Estudiantes::create');

   //http://localhost/sistema/api/estudiantes/edit
   $routes->get('estudiantes/edit/(:num)', 'Estudiantes::edit/$1');

   //http://localhost/sistema/api/estudiantes/update
   $routes->put('estudiantes/update/(:num)', 'Estudiantes::update/$1');

   //http://localhost/sistema/api/estudiantes/delete
   $routes->delete('estudiantes/delete/(:num)', 'Estudiantes::delete/$1');


   //URI PARA CONTROLADO DE TUTORES
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


   //URI PARA CONTROLADO DE ESTUDIANTES CURSOS
   //http://localhost/sistema/api/estudiantescursos/
   $routes->get('estudiantescursos', 'EstudiantesCursos::index');

   //http://localhost/sistema/api/estudiantescursos/create
   $routes->post('estudiantescursos/create', 'EstudiantesCursos::create');

   //http://localhost/sistema/api/estudiantescursos/edit/
   $routes->get('estudiantescursos/edit/(:num)', 'EstudiantesCursos::edit/$1');

   //http://localhost/sistema/api/estudiantescursos/update/
   $routes->put('estudiantescursos/update/(:num)', 'EstudiantesCursos::update/$1');

   //http://localhost/sistema/api/estudiantescursos/delete/
   $routes->delete('estudiantescursos/delete/(:num)', 'EstudiantesCursos::delete/$1');
});
