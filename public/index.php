<?php 
require_once __DIR__ . '/../includes/app.php';

//!Aca se colocan Los Controladores
use MVC\Router;
use Controllers\AppController;
use Controllers\PacienteController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//!Aca se colocan lar Rutas
$router->get('/', [AppController::class,'index']);
$router->get('/pacientes', [PacienteController::class,'index']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
