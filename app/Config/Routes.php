<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/admin/dashboard', 'AdminController::dashboard');

$routes->get('/admin/salas', 'SalasController::salas');

$routes->get('/admin/equipos', 'EquipoController::equipos');       // Vista de tabla
$routes->get('/admin/equipos/crear', 'EquipoController::crear');   // Formulario
$routes->post('/admin/equipos/guardar', 'EquipoController::guardar'); // Guardar
$routes->get('/admin/equipos/obtenerEquipos', 'EquipoController::obtenerEquipos');     // JSON dinámico

$routes->get('/admin/clientes', 'ClienteController::clientes');

$routes->get('/admin/horarios', 'HorarioController::horarios');
$routes->get('/admin/horarios/obtener', 'HorarioController::obtener'); // JSON para DataTables

$routes->get('admin/ranking', 'RankingController::ranking'); // Vista completa
$routes->get('admin/ranking/obtener', 'RankingController::obtener'); // JSON
$routes->get('admin/ranking/editar/(:num)', 'RankingController::editar/$1'); // Formulario
$routes->post('admin/ranking/actualizar/(:num)', 'RankingController::actualizar/$1'); // Guardado


$routes->get('admin/reservas', 'ReservaController::reservas');
$routes->get('admin/reservas/obtener', 'ReservaController::obtenerReservas');
$routes->post('admin/reservas/crear', 'ReservaController::crear');

