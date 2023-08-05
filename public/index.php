<?php 
require_once __DIR__ . '/../includes/app.php';

//!Aca se colocan lar Rutas
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);
$router->get('/pacientes', [AppController::class,'pacientes']);
$router->get('/citas', [AppController::class,'citas']);
$router->get('/medicos', [AppController::class,'medicos']);
$router->get('/clinicas', [AppController::class,'clinicas']);
$router->get('/especialidades', [AppController::class,'especialidades']);
$router->get('/detalles', [AppController::class,'detalles']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
