<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');


$routes->get('/admin/dashboard', 'AdminController::dashboard');

$routes->get('/admin/salas', 'SalasController::salas');

$routes->get('/admin/integrantes', 'IntegranteController::integrantes');

$routes->get('/admin/equipos', 'EquipoController::equipos');       // Vista de tabla
$routes->get('/admin/equipos/crear', 'EquipoController::crear');   // Formulario
$routes->post('/admin/equipos/guardar', 'EquipoController::guardar'); // Guardar
$routes->get('/admin/equipos/obtenerEquipos', 'EquipoController::obtenerEquipos');     // JSON dinámico
$routes->post('/admin/equipos/crear', 'EquipoController::crearEquipos');// JSON dinámico

$routes->post('/admin/equipos/crear', 'EquipoController::crearEquipos');// JSON dinámico 

$routes->get('/admin/equipos/ultimo-codigo', 'EquipoController::obtenerUltimoCodigoEquipo');

$routes->get('/admin/clientes', 'ClienteController::clientes');

$routes->get('/admin/horarios', 'HorarioController::horarios');
$routes->get('/admin/horarios/obtener', 'HorarioController::obtener'); // JSON para DataTables
$routes->get('/admin/horarios/disponibles', 'HorarioController::horariosDisponibles');
//routes->get('/admin/fechas-disponibles', 'HorarioController::fechasDisponibles');
$routes->get('/admin/horarios/fechas-ocupadas', 'HorarioController::fechasOcupadas');
$routes->get('/admin/horarios/disponibles-vista', 'HorarioController::vistaHorariosDisponibles');


$routes->get('admin/ranking', 'RankingController::ranking'); // Vista completa
$routes->get('admin/ranking/obtener', 'RankingController::obtener'); // JSON
$routes->get('admin/ranking/editar/(:num)', 'RankingController::editar/$1'); // Formulario
$routes->post('admin/ranking/actualizar/(:num)', 'RankingController::actualizar/$1'); // Guardado
$routes->put('admin/ranking/actualizar/(:num)', 'RankingController::actualizarRanking/$1'); //JSON

$routes->post('admin/ranking/api/crear', 'RankingController::crearRankingAPI');
$routes->post('/admin/ranking/registrar-resultado', 'RankingController::registrarResultado');

// Vistas y DataTables
$routes->get('/admin/reservas', 'ReservaController::reservas'); // Vista principal (listado)
$routes->get('/admin/reservas/obtener', 'ReservaController::obtenerReservas'); // JSON para DataTables

// Crear nueva reserva
$routes->post('/admin/reservas/crear', 'ReservaController::crear'); // JSON desde frontend o API (Postman)
$routes->post('/admin/reservas/guardar', 'ReservaController::guardar'); // Formulario clásico (web)


// Editar reserva
$routes->get('/admin/reservas/editar/(:num)', 'ReservaController::editar/$1'); // Formulario web
$routes->post('/admin/reservas/actualizar/(:num)', 'ReservaController::actualizar/$1');
$routes->put('/admin/reservas/api/actualizar/(:num)', 'ReservaController::actualizarReservaAPI/$1');

$routes->post('admin/reservas/cambiar-estado/(:num)', 'ReservaController::cambiarEstado/$1');

