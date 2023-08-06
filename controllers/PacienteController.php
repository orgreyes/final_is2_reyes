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

    

    public static function guardarAPI(){
        try {
            $paciente = new Paciente($_POST);
            $resultado = $paciente->crear();
            
            echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }


    public static function buscarAPI(){
        // $pacientes = Paciente::all();
        $paciente_nombre = $_GET['paciente_nombre'];
        $paciente_dpi = $_GET['paciente_dpi'];
        $paciente_telefono = $_GET['paciente_telefono'];

        $sql = "SELECT * FROM pacientes WHERE paciente_situacion = 1 ";
        if($paciente_nombre != ''){
            $sql .= "AND paciente_nombre LIKE '%$paciente_nombre%' ";
        }

        if($paciente_dpi != ''){
            $sql .= "AND paciente_dpi LIKE '%$paciente_dpi%' ";
        }

        if($paciente_telefono != ''){
            $sql .= "AND paciente_telefono LIKE '%$paciente_telefono%' ";
        }

        try {
            $pacientes = Paciente::fetchArray($sql);
            echo json_encode($pacientes);
            
        } catch (exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje'=> 'Ocurrio un Error',
                    'codigo' => 0
            ]);
        }

    }


}
