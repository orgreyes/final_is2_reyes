<?php

namespace Controllers;
use Exception;
use Model\Especialidad;
use MVC\Router;

class EspecialidadController{
    public static function index(Router $router){


        $especialidades = Especialidad::all();
        
        

        $router->render('especialidades/index', [
            'especialidades' => $especialidades,
        ]); 
    }

    
//!Funcion Guardar
    public static function guardarAPI(){
        try {
            $especialidad = new Especialidad($_POST);
            $resultado = $especialidad->crear();
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
            $especialidad = new Especialidad($_POST);
            $resultado = $especialidad->actualizar();

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
            $espec_id = $_POST['espec_id'];
            $espec = Especialidad::find($espec_id);
            $espec->espec_situacion = 0;
            $resultado = $espec->actualizar();

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
        $especialidad_nombre = $_GET['espec_nombre'];


        $sql = "SELECT * FROM especialidades WHERE espec_situacion = 1 ";
        if($especialidad_nombre != ''){
            $sql .= "AND espec_nombre LIKE '%$especialidad_nombre%' ";
        }


        try {
            $especialidades = Especialidad::fetchArray($sql);
            echo json_encode($especialidades);
            
        } catch (exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje'=> 'Ocurrio un Error',
                    'codigo' => 0
            ]);
        }

    }


}
