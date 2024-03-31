<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//http://localhost/SISTEMA/Estudiantes
$routes->group('estudiantes', ['namespace' => 'App\Controllers\Estudiantes'], function($routes){
    //http://localhost/SISTEMA/Estudiante
    $routes->get('estudiantes', 'Estudiantes::index');
});
