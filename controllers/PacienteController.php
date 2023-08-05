<?php

namespace Controllers;
use Model\Paciente;
use MVC\Router;

class PacienteController{
    public static function index(Router $router){


        $pacientes = Paciente::all();
        var_dump($pacientes);
        exit;
        

        $router->render('pacientes/index');
    }
}
