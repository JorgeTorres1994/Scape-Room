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

// Vistas y DataTables
$routes->get('/admin/reservas', 'ReservaController::reservas'); // Vista principal (listado)
$routes->get('/admin/reservas/obtener', 'ReservaController::obtenerReservas'); // JSON para DataTables

// Crear nueva reserva
$routes->post('/admin/reservas/crear', 'ReservaController::crear'); // JSON desde frontend o API (Postman)
$routes->post('/admin/reservas/guardar', 'ReservaController::guardar'); // Formulario clásico (web)

// Editar reserva
$routes->get('/admin/reservas/editar/(:num)', 'ReservaController::editar/$1'); // Formulario web
$routes->post('/admin/reservas/actualizar/(:num)', 'ReservaController::actualizar/$1'); // Web o JSON POST

// Notificaciones
$routes->get('/admin/notificaciones', 'NotificacionController::obtener');
$routes->post('/admin/notificaciones/marcar-leida/(:num)', 'NotificacionController::marcarLeida/$1');
