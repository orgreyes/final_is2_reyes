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
                'mensaje' => 'Registro Elimino correctamente',
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
    $medico_clinica = $_GET['medico_clinica'];
    $medico_espec = $_GET['medico_espec'];

    $sql = "SELECT medicos.medico_id, medicos.medico_nombre, especialidades.espec_nombre AS medico_espec_nombre, clinicas.clinica_nombre AS medico_clinica_nombre 
    FROM medicos 
    INNER JOIN especialidades ON medicos.medico_espec = especialidades.espec_id
    INNER JOIN clinicas ON medicos.medico_clinica = clinicas.clinica_id
    WHERE medicos.medico_situacion = 1";

    if($medico_nombre != ''){
        $sql .= " AND medicos.medico_nombre LIKE '%$medico_nombre%' ";
    }

    if($medico_clinica != ''){
        $sql .= " AND clinicas.clinica_nombre LIKE '%$medico_clinica%' ";
    }

    if($medico_espec != ''){
        $sql .= " AND especialidades.espec_nombre LIKE '%$medico_espec%' ";
    }

    try {
        $medicos = Medico::fetchArray($sql);
        echo json_encode($medicos);
        
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje'=> 'Ocurrio un Error',
            'codigo' => 0
        ]);
    }
}


}

