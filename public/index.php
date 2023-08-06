<?php 
require_once __DIR__ . '/../includes/app.php';

//!Aca se colocan Los Controladores
use MVC\Router;
use Controllers\AppController;
use Controllers\PacienteController;
use Controllers\ClinicaController;
use Controllers\EspecialidadController;
use Controllers\MedicoController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//!Aca se colocan lar Rutas para Pacientes
$router->get('/', [AppController::class,'index']);
$router->get('/pacientes', [PacienteController::class,'index']);
$router->post('/API/pacientes/modificar', [PacienteController::class,'modificarAPI']);
$router->post('/API/pacientes/guardar', [PacienteController::class,'guardarAPI']);
$router->post('/API/pacientes/eliminar', [PacienteController::class,'eliminarAPI']);
$router->get('/API/pacientes/buscar', [PacienteController::class,'buscarAPI']);


//!Aca se colocan lar Rutas para Clinicas
$router->get('/', [AppController::class,'index']);
$router->get('/clinicas', [ClinicaController::class,'index']);
$router->post('/API/clinicas/modificar', [ClinicaController::class,'modificarAPI']);
$router->post('/API/clinicas/guardar', [ClinicaController::class,'guardarAPI']);
$router->post('/API/clinicas/eliminar', [ClinicaController::class,'eliminarAPI']);
$router->get('/API/clinicas/buscar', [ClinicaController::class,'buscarAPI']);


//!Aca se colocan lar Rutas para Especialidades
$router->get('/', [AppController::class,'index']);
$router->get('/especialidades', [EspecialidadController::class,'index']);
$router->post('/API/especialidades/modificar', [EspecialidadController::class,'modificarAPI']);
$router->post('/API/especialidades/guardar', [EspecialidadController::class,'guardarAPI']);
$router->post('/API/especialidades/eliminar', [EspecialidadController::class,'eliminarAPI']);
$router->get('/API/especialidades/buscar', [EspecialidadController::class,'buscarAPI']);


//!Aca se colocan lar Rutas para Medicos
$router->get('/', [AppController::class,'index']);
$router->get('/medicos', [MedicoController::class,'index']);
$router->post('/API/medicos/modificar', [MedicoController::class,'modificarAPI']);
$router->post('/API/medicos/guardar', [MedicoController::class,'guardarAPI']);
$router->post('/API/medicos/eliminar', [MedicoController::class,'eliminarAPI']);
$router->get('/API/medicos/buscar', [MedicoController::class,'buscarAPI']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
