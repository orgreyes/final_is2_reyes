<?php

namespace Controllers;
use Exception;
use Model\Cita;
use MVC\Router;

class CitaController{
    public static function index(Router $router){

        $pacientes = static::buscarPacientes();
        $medicos = static::buscarMedicos();

        $citas = Cita::all();
        
        

        $router->render('citas/index', [
            'citas' => $citas,
            'pacientes' => $pacientes,
            'medicos' => $medicos,
        ]); 
    }

//!--------------------------
public static function buscarPacientes(){
    $sql = "SELECT * FROM pacientes where paciente_situacion = 1";

    try {
        $pacientes = Cita::fetchArray($sql);

        if($pacientes){
            return $pacientes;
        }else{
            return 0;
        }
    } catch (Exception $e) {
        
    }
}
//!--------------------------
public static function buscarMedicos(){
    $sql = "SELECT * FROM medicos where medico_situacion = 1";

    try {
        $medicos = Cita::fetchArray($sql);

        if($medicos){
            return $medicos;
        }else{
            return 0;
        }
    } catch (Exception $e) {
        
    }
}


    
//!Funcion Guardar
    public static function guardarAPI(){
        try {
            $cita = new Cita($_POST);
            $resultado = $cita->crear();
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
            $cita = new Cita($_POST);
            $resultado = $cita->actualizar();

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
            $cita_id = $_POST['cita_id'];
            $cita = Cita::find($cita_id);
            $cita->cita_situacion = 0;
            $resultado = $cita->actualizar();

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
public static function buscarAPI() {

    $sql = "SELECT citas.cita_id, 
                   pacientes.paciente_nombre, 
                   medicos.medico_nombre,
                   citas.cita_fecha,
                   citas.cita_hora,
                   citas.cita_referencia
            FROM citas 
            JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id 
            JOIN medicos ON citas.cita_medico = medicos.medico_id 
            WHERE citas.cita_situacion = 1";
  
    try {
        $citas = Cita::fetchArray($sql);
        header('Content-Type: application/json');
        echo json_encode($citas);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}  


}




