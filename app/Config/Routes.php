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

$routes->get('/admin/horarios', 'HorarioController::horarios');

$routes->get('/admin/rankings', 'RankingController::rankings');

$routes->get('admin/reservas', 'ReservaController::reservas');
$routes->get('admin/reservas/obtener', 'ReservaController::obtenerReservas');
$routes->post('admin/reservas/crear', 'ReservaController::crear');

