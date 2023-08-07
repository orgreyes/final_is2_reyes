<?php

namespace Controllers;

use Exception;
use Model\Cita;
use Model\Paciente;
use Model\Medico;
use Model\Clinica;
use MVC\Router;

class DetalleCitasController
{
    public static function index(Router $router)
    {
        // $detallesCitas = static::getDetallesCitas();
        
        $router->render('detallecitas/index');
    }
};