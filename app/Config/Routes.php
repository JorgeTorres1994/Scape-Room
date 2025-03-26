<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/admin/dashboard', 'AdminController::dashboard');

$routes->get('/admin/salas', 'SalasController::salas');

$routes->get('/admin/equipos', 'EquipoController::equipos');

$routes->get('/admin/clientes', 'ClienteController::clientes');

$routes->get('/admin/horarios', 'HorarioController::index');
