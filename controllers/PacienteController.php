<?php

namespace Controllers;
use Model\Paciente;
use MVC\Router;

class PacienteController{
    public static function index(Router $router){


        $pacientes = Paciente::all();
        
        

        $router->render('pacientes/index', [
            'pacientes' => $pacientes,
        ]); 
    }
}
