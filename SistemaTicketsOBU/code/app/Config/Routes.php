<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true); // Usa AutoRoute solo si controlas bien tus rutas

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Ruta pública (login)
$routes->get('/', 'Auth::index');

// 🔐 Rutas protegidas con el filtro 'auth'
$routes->group('', ['filter' => 'auth'], function($routes) {
    //Gestión de caja
    $routes->get('caja_admin', 'CajaAdmin::index');

    // Gestión de estudiantes
    $routes->get('estudiantes', 'Estudiantes::index');

    // Platos del día
    $routes->get('platos', 'Platos::index');

    // Gestión de tickets
    $routes->get('tickets', 'Tickets::index');

    // Asistencias
    $routes->get('asistencias', 'Asistencias::index');

    // Incidencias
    $routes->get('incidencias', 'Incidencias::index');

    // Actividad estudiantil
    $routes->get('actividad', 'Actividad::index');

    // Configuración
    $routes->get('configuracion', 'Configuracion::index');

    // Tickets estudiante (dos alias usados en distintas vistas: ticket/* y TicketEstudiante/*)
    $routes->get('ticket/hoy', 'TicketEstudiante::hoy');
    $routes->get('ticket/historial', 'TicketEstudiante::historial');
    $routes->get('ticket/pdf/(:num)', 'TicketEstudiante::pdf/$1'); // Para recibir el ID

    $routes->get('TicketEstudiante/hoy', 'TicketEstudiante::hoy');
    $routes->get('TicketEstudiante/historial', 'TicketEstudiante::historial');
    $routes->get('TicketEstudiante/pdf/(:num)', 'TicketEstudiante::pdf/$1');
    $routes->post('TicketEstudiante/registrar', 'TicketEstudiante::registrar');

    // Verificación de ticket en el mostrador (personal del comedor escanea el QR)
    $routes->get('verificar_ticket/(:num)', 'TicketEstudiante::verificar/$1');

     // Mi perfil
    $routes->get('perfil', 'EstudiantePerfil::index');
    $routes->post('perfil/actualizar', 'EstudiantePerfil::actualizar');


});

/*
 * --------------------------------------------------------------------
 * Additional Routing por entorno
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}


