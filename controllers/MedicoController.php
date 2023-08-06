<?php

namespace Controllers;
use Exception;
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
            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }

    public static function modificarAPI(){
        try{
            $producto = new Paciente($_POST);
            $resultado = $producto->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
        }catch(Exception $e){
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }


    public static function eliminarAPI(){
        try{
            $paciente_id = $_POST['paciente_id'];
            $paciente = Paciente::find($paciente_id);
            $paciente->paciente_situacion = 0;
            $resultado = $paciente->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
        }catch(Exception $e){
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
