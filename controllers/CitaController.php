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
        // echo json_encode($cita);
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
        $cita_id = $_POST['cita_id'];
        $cita = Cita::find($cita_id);
        // echo json_encode($cita);
        // exit;
        $cita->cita_situacion = 0;
        $resultado = $cita->actualizar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                'mensaje' => 'Registro se Elimino correctamente',
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
public static function buscarAPI()
{
    $paciente_nombre = $_GET['paciente_nombre'] ?? '';
    $medico_nombre = $_GET['medico_nombre'] ?? '';
    $cita_paciente = $_GET['cita_paciente'] ?? '';
    $cita_medico = $_GET['cita_medico'] ?? '';
    $cita_fecha = $_GET['cita_fecha'] ?? '';
    $cita_hora = $_GET['cita_hora'] ?? '';
    $cita_referencia = $_GET['cita_referencia'] ?? '';

    $sql = "SELECT
    p.paciente_nombre,
    m.medico_nombre,
    c.cita_paciente,
    c.cita_medico,
    c.cita_fecha,
    c.cita_hora,
    c.cita_referencia,
    c.cita_id
FROM
    citas c
    INNER JOIN pacientes p ON c.cita_paciente = p.paciente_id
    INNER JOIN medicos m ON c.cita_medico = m.medico_id
WHERE
    c.cita_situacion = 1";

    // Agregamos las condiciones de búsqueda según los parámetros recibidos
    if (!empty($paciente_nombre)) {
        $sql .= " AND p.paciente_nombre LIKE '%$paciente_nombre%'";
    }
    if (!empty($medico_nombre)) {
        $sql .= " AND m.medico_nombre LIKE '%$medico_nombre%'";
    }
    if (!empty($cita_paciente)) {
        $sql .= " AND c.cita_paciente = '$cita_paciente'";
    }
    // if (!empty($cita_medico)) {
    //     $sql .= " AND c.cita_medico = '$cita_medico'";
    // }
    // if (!empty($cita_fecha)) {
    //     $sql .= " AND c.cita_fecha = '$cita_fecha'";
    // }
    // if (!empty($cita_hora)) {
    //     $sql .= " AND c.cita_hora = '$cita_hora'";
    // }
    if (!empty($cita_referencia)) {
        $sql .= " AND c.cita_referencia = '$cita_referencia'";
    }

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




