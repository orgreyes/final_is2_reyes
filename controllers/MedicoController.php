<?php

namespace Controllers;
use Exception;
use Model\Medico;
use MVC\Router;

class MedicoController{
    public static function index(Router $router){

        $clinicas = static::buscarClinicas();
        $especialidades = static::buscarEspecialidades();

        $medicos = Medico::all();
        
        

        $router->render('medicos/index', [
            'medicos' => $medicos,
            'clinicas' => $clinicas,
            'especialidades' => $especialidades,
        ]); 
    }

//!--------------------------
public static function buscarClinicas(){
    $sql = "SELECT * FROM clinicas where clinica_situacion = 1";

    try {
        $clinicas = Medico::fetchArray($sql);

        if($clinicas){
            return $clinicas;
        }else{
            return 0;
        }
    } catch (Exception $e) {
        
    }
}
//!--------------------------
public static function buscarEspecialidades(){
    $sql = "SELECT * FROM especialidades where espec_situacion = 1";

    try {
        $especialidades = Medico::fetchArray($sql);

        if($especialidades){
            return $especialidades;
        }else{
            return 0;
        }
    } catch (Exception $e) {
        
    }
}


    
//!Funcion Guardar
    public static function guardarAPI(){
        try {
            $medico = new Medico($_POST);
            $resultado = $medico->crear();
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
            $medico = new Medico($_POST);
            $resultado = $medico->actualizar();

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
            $medico_id = $_POST['medico_id'];
            $medico = Medico::find($medico_id);
            $medico->medico_situacion = 0;
            $resultado = $medico->actualizar();

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


// !Funcion Buscar
public static function buscarAPI(){
    $medico_nombre = $_GET['medico_nombre'];
    $medico_clinica = $_GET['medico_clinica']; // Agrega esta línea
    $medico_espec = $_GET['medico_espec'];     // Agrega esta línea

    $sql = "SELECT * FROM medicos WHERE medico_situacion = 1";

    if($medico_nombre != ''){
        $sql .= " AND medico_nombre LIKE '%$medico_nombre%' "; // Agrega un espacio antes de AND
    }

    if($medico_clinica != ''){
        $sql .= " AND medico_clinica LIKE '%$medico_clinica%' ";
    }

    if($medico_espec != ''){
        $sql .= " AND medico_espec LIKE '%$medico_espec%' ";
    }

    try {
        $medicos = Medico::fetchArray($sql);
        echo json_encode($medicos);
        
    } catch (Exception $e) { // Cambia "exception" por "Exception" para que coincida con la clase Exception
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje'=> 'Ocurrio un Error',
            'codigo' => 0
        ]);
    }
}

}

