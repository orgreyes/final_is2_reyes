<?php

namespace Controllers;
use Exception;
use Model\Clinica;
use MVC\Router;

class ClinicaController{
    public static function index(Router $router){


        $clinicas = Clinica::all();
        
        

        $router->render('clinicas/index', [
            'clinicas' => $clinicas,
        ]); 
    }

    
//!Funcion Guardar
    public static function guardarAPI(){
        try {
            $clinica = new Clinica($_POST);
            $resultado = $clinica->crear();
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

//!Funcion Modificar
    public static function modificarAPI(){
        try{
            $clinica = new Clinica($_POST);
            $resultado = $clinica->actualizar();
            // echo json_encode($clinica);
            // exit;
    
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

//!Funcion Eliminar
    public static function eliminarAPI(){
        try{
            $clinica_id = $_POST['clinica_id'];
            $clinica = Clinica::find($clinica_id);
            $clinica->clinica_situacion = 0;
            $resultado = $clinica->actualizar();

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


//!Funcion Buscar
    public static function buscarAPI(){
        $clinica_nombre = $_GET['clinica_nombre'];


        $sql = "SELECT * FROM clinicas WHERE clinica_situacion = 1 ";
        if($clinica_nombre != ''){
            $sql .= "AND clinica_nombre LIKE '%$clinica_nombre%' ";
        }


        try {
            $clinicas = Clinica::fetchArray($sql);
            echo json_encode($clinicas);
            
        } catch (exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje'=> 'Ocurrio un Error',
                    'codigo' => 0
            ]);
        }

    }


}
