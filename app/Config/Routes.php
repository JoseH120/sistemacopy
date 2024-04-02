<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes){
   $routes->get('estudiantes', 'Estudiantes::index'); 
});
