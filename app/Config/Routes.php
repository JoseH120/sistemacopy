<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes){
   //http://localhost/sistema/api/estudiantes
   $routes->get('estudiantes', 'Estudiantes::index'); 

   //http://localhost/sistema/api/tutores
   $routes->get('tutores', 'Tutores::index'); 
});
